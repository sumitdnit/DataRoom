<?php
class FolderController extends BaseController {
	
	public $userid;
	public $email;
	
	public function __construct() {
		$this->beforeFilter('auth');
		parent::__construct();
		if (Sentry::check()) {
			$this->user = Sentry::getUser();
			$this->userid = $this->user->id;		   
			$tmp = DB::table('users')->select('email')->where('id','=', $this->user->id)->first();
			
			$this->email = $tmp->email;
		}
	}
	
	//Developed by kapil
	// For creating Folder under dataRoom and Project
	public function listFolder(){ 
		// GEt user Dataroom
		$arrListedArray = array();
		$projarr=Input::get('p');
		$encodeproj='0';
		$encodedatroom='0';
		$arrUserProject=null;
		if($projarr){
		 $encodeproj=base64_decode($projarr); 
		 if($encodeproj){
			$datarrom=DB::table('projects')
				->join('user_project', 'projects.id', '=', 'user_project.project_id')->where('user_project.project_id',$encodeproj)
				->select('dataroom_id')->first();
			$encodedatroom=$datarrom->dataroom_id;
			if($encodedatroom){
				$arrUserProject = Project::getAllProjects($encodedatroom,$this->user->id,$this->user->usertype);
			}
		}
		}
		$arrUserDataRoom = Dataroom::getAllDataRoom($this->user->id, $this->user->usertype);
		$arrUDataRoom = $arrUserDataRoom;
		$arr = array('dataroom'=>$arrUDataRoom,'projects'=>$arrUserProject,'currentUserType'=>$this->user->usertype,'projectid'=>$encodeproj ,'dataroomid'=>$encodedatroom);	
		return View::make('folder/user-folder')->with('data', $arr);
	}
	

	// this function is used to list project related with user dataroom
	public function getUserProject(){
		$varDataRoomID = addslashes(Input::get('drId'));
		return $arrUserProject = Project::getAllProjects($varDataRoomID,$this->user->id,$this->user->usertype);
	}
	
	// this function is used to get project related with user dataroom
	public function getProjectInfo(){
		$varProjectID = addslashes(Input::get('drId'));
		$roleView=Project::where('id',$varProjectID)->first();
		$userrole='';
		if($roleView && count($roleView)>0){
			
			if($this->user->usertype=="admin") {
				
				echo json_encode(array('role'=>'admin','folder'=>array())); exit();
			}else{	
				if($roleView->view_only == 1){
				  $userrole="view";
				}
				
				//check roles
				$currentrole='';
				$role=UserProject::where('project_id',$varProjectID)->where('user_id',$this->user->id)->first();	
				if($role && count($role)>0){
					
					if($role->role=='admin'){
						$currentrole='admin';
					}else if($userrole=='view'){
						$currentrole='view';
					}else{
						$currentrole=$role->role;
					}
					
					echo json_encode(array('role'=>$currentrole,'folder'=>array())); exit();
					
				}else{
				   
				   echo json_encode(array('role'=>'','folder'=>array())); exit();			
					
				}
			}
		}else{
		 echo json_encode(array('role'=>'','folder'=>array())); exit();	
		}	
		
		
	}
	
	public $folderPath='';
	public function getPath($folder){
			if($folder==0){ 
				
				$this->folderPath .='';
				
			}else{
					$folderObj=ProjectFolder::where('id',$folder)->first();
					if($folderObj && count($folderObj)>0){
						$this->folderPath .=$folderObj->folder_name .'/';
						if($folderObj->parent_id>0){
							 //$this->folderPath .=$folderObj->folder_name .'/';
							$this->getPath($folderObj->parent_id);
						}
					}
			}		
			
			
	}
	
	public $folderViewPath='';
	public function showFolders($id,$role){
		$folderObj=ProjectFolder::where('parent_id',$id)->get();
		
		if($folderObj && count($folderObj)>0){
			
			$this->folderViewPath .= '<ul>';
			foreach($folderObj as $fldr){
				$this->folderViewPath .='<li><a href="#">'. $fldr->alias .'</a>';
				if($role=='admin'){
					$paralias=ProjectFolder::where('id',$fldr->parent_id)->first();
					if($paralias && count($paralias)>0){
						$parentalias=$paralias->alias;
					}else{
						$parentalias='Root';
					}
					$this->folderViewPath .='<div class="editUpdatePrj">
								
								<a href="javascript:void(0)">
									<i  class="fa fa-plus plus"  data-id="'. $fldr->id . '" foldername="'. $fldr->alias .'"  ></i>
								</a> 
								<a href="javascript:void(0)">
									<i  class="fa fa-pencil pencil" parentalias="'. $parentalias .'"  data-id="'. $fldr->id . '" foldername="'. $fldr->alias .'"  ></i>
								</a> 
								<a href="javascript:void(0)">
									<i class="fa fa-times delete" data-id="'. $fldr->id . '" foldername="'. $fldr->alias .'"  ></i>
								</a>
								<a href="javascript:void(0)">
								<i class="fa fa-upload upload" ></i>
								</a>
								 
								
							</div>';
				}elseif($role=='upload'){
					
					$this->folderViewPath .='<div class="editUpdatePrj">								
								<a href="javascript:void(0)">
								<i class="fa fa-upload upload" ></i>
								</a>
							</div>';
					
				}elseif($role=='download'){
					
					/*$this->folderViewPath .='<div class="editUpdatePrj">								
								<a href="javascript:void(0)">
								<i class="fa fa-download download" ></i>
								</a>
							</div>';*/
				} 	
				
				
				$this->folderViewPath .=' <small>Update: ' . $fldr->updated_at .'</small>';
				
				$this->showFolders($fldr->id,$role);
				$this->folderViewPath .='</li>';
			}	
			$this->folderViewPath .= '</ul>';
			
		}	
		
	}
	
	
	public function listfolders(){
			 	
		$projectID 		= Input::get('projectID');
		$role 		= Input::get('role');
		$project= Project::where('id',$projectID)->first();
		if(!$project || count($project)==0){
			echo 'error::Unauthorished access for this folder!!';exit();
		}
		
		
		$folders=ProjectFolder::where('project_id',$projectID)->where('parent_id','0')->get();
		$expanded="";
		if($folders && count($folders)>0){
			
			foreach($folders as $fldr){
				//echo $role;
				$expanded .='<li><a href="#">'. $fldr->alias .'</a>';
				if($role=='admin'){
					$paralias=ProjectFolder::where('id',$fldr->parent_id)->first();
					if($paralias && count($paralias)>0){
						$parentalias=$paralias->alias;
					}else{
						$parentalias='Root';
					}
					$expanded .='<div class="editUpdatePrj">
								
									
								<a href="javascript:void(0)">
									<i  class="fa fa-plus plus"  data-id="'. $fldr->id . '" foldername="'. $fldr->alias .'"  ></i>
								</a> 
								<a href="javascript:void(0)">
									<i  class="fa fa-pencil pencil" parentalias="'. $parentalias .'"  data-id="'. $fldr->id . '" foldername="'. $fldr->alias .'"  ></i>
								</a> 
								<a href="javascript:void(0)">
									<i class="fa fa-times delete" data-id="'. $fldr->id . '" foldername="'. $fldr->alias .'"  ></i>
								</a>
								<a href="javascript:void(0)">
								<i class="fa fa-upload upload" ></i>
								</a>
								
								
							</div>';
				}elseif($role=='upload'){
					
					$expanded .='<div class="editUpdatePrj">								
								<a href="javascript:void(0)">
								<i class="fa fa-upload upload" ></i>
								</a>
							</div>';
					
				}elseif($role=='download'){
					
					/*$expanded .='<div class="editUpdatePrj">								
								<a href="javascript:void(0)">
								<i class="fa fa-download download" ></i>
								</a>
							</div>';*/
				} 				
				 $expanded .='<small>Update: ' . $fldr->updated_at .'</small>';
				 
				//if($fldr->alias=='Parent1' || $fldr->alias=='Parent'){
					//echo $fldr->id;
					$this->showFolders($fldr->id,$role);
				//}
				$expanded .=$this->folderViewPath; 
				$this->folderViewPath='';
				$expanded .='</li>';
			}
			
			echo $expanded;
			
		}else{
			
		  echo '<div style=" width: 85%; margin: 0 auto"><p class="alert alert-danger">No folders or files found!</p></div>';
		}
		
			
	}
	
	// Developed by kapil
	// This function used to create folder name
	public function getEditFolder(){
		$varFolderID 		= Input::get('folderId');
		$projectID 		= Input::get('projectID');
		$project= Project::where('id',$projectID)->first();
		if(!$project || count($project)==0){
			echo 'error::Unauthorished access for this folder!!';exit();
		}
		if($this->user->usertype!='admin'){
			$usrProject=UserProject::where('project_id',$projectID)->where('user_id',$this->user->id)->first();			
			if($usrProject->role!='admin'){
				
				echo 'error::Unauthorished access for this folder!!';exit();
			}
		}
		
		$varFolderName  = str_replace(' ','_',addslashes(Input::get('foldername')));
		$realname  = addslashes(Input::get('foldername'));
		//$checkFolder = ProjectFolder::checkFolder($varFolderID);
			if($varFolderName){
				
				$varfolderPath =  public_path().'/public/folders/'.$projectID;
				if (!File::isDirectory($varfolderPath)){
					$old = umask(0);
					mkdir($varfolderPath, 0775);
					umask($old);
				}	
				
				$this->getPath($varFolderID );	
				$paths=explode('/',$this->folderPath);
				$revpath='';
				if($paths && count($paths)>0){
					for($i=count($paths)-1 ; $i>=0;$i--){
				          if($paths[$i]) $revpath .=$paths[$i].'/';
					}
				}
			 //echo $revpath;
				$varfolderPath.= '/'.$revpath;//die;
				
				if (File::isDirectory($varfolderPath .$varFolderName )){
						echo 'error::Folder already exist!!';
						exit;
				}
				
				$projectfoldercheck=ProjectFolder::where('folder_name',$varFolderName)->where('parent_id',$varFolderID)->where('project_id',$projectID)->first();
				if($projectfoldercheck && count($projectfoldercheck)>0){
						echo 'error::Folder already exist!!';
						exit;					
				}
				
				$objProjectFolder = new ProjectFolder;
				$objProjectFolder->folder_name = $varFolderName;
				$objProjectFolder->alias = $realname;
				$objProjectFolder->parent_id = $varFolderID;
				$objProjectFolder->created_at = date('Y-m-d H:i:s');
				$objProjectFolder->updated_at = date('Y-m-d H:i:s');
				$objProjectFolder->created_by = $this->user->id;
				$objProjectFolder->project_id = $projectID;
				if($objProjectFolder->save()){
					$old = umask(0);
					mkdir($varfolderPath .$varFolderName, 0775);
					umask($old);
					echo '1';exit;
				}else{
					echo 'error::Something gone wrong . Please try again!!';	exit;
				}
				
			}
			else {
				echo 'error::Unauthorished access for this folder!!';
				exit;
			}
	}
	
	
	public function getupdatefolder(){
		
		$varFolderID 		= Input::get('folderId');
		$projectID 		= Input::get('projectID');
		
		$folders= ProjectFolder::where('id',$varFolderID)->first();
		if(!$folders || count($folders)==0){
			echo 'error::Unauthorished access for this folder!!';exit();
		}
		
		$project= Project::where('id',$projectID)->first();
		if(!$project || count($project)==0){
			echo 'error::Unauthorished access for this folder!!';exit();
		}
		
		if($this->user->usertype!='admin'){
			$usrProject=UserProject::where('project_id',$projectID)->where('user_id',$this->user->id)->first();			
			if($usrProject->role!='admin'){				
				echo 'error::Unauthorished access for this folder!!';exit();
			}
		}
		
		$varFolderName  = str_replace(' ','_',addslashes(Input::get('foldername')));
		$realname  = addslashes(Input::get('foldername'));
		
		if($varFolderName){
				
				$varfolderPath =  public_path().'/public/folders/'.$projectID;
				if (!File::isDirectory($varfolderPath)){
					$old = umask(0);
					mkdir($varfolderPath, 0775);
					umask($old);
				}	
				
				$this->getPath($folders->parent_id );	
				$paths=explode('/',$this->folderPath);
				$revpath='';
				if($paths && count($paths)>0){
					for($i=count($paths)-1 ; $i>=0;$i--){
				          if($paths[$i]) $revpath .=$paths[$i].'/';
					}
				}
			 //echo $revpath;
				$varfolderPath.= '/'.$revpath;//die;
				$oldfilename=$folders->folder_name;
							
				$projectfoldercheck=ProjectFolder::where('folder_name',$varFolderName)->where('id','<>',$folders->id)->where('parent_id',$varFolderID)->where('project_id',$projectID)->first();
				if($projectfoldercheck && count($projectfoldercheck)>0){
						echo 'error::Folder already exist!!';
						exit;					
				}
				
				
				$update = ProjectFolder::where('id', $folders->id)->update(array('folder_name' => $varFolderName,'alias'=> $realname , 'updated_at' =>date('Y-m-d H:i:s')));
				if (File::isDirectory($varfolderPath .$oldfilename )){
						
						rename($varfolderPath .$oldfilename, $varfolderPath .$varFolderName);						
						echo '1';exit;
						
				}else{
					
					$old = umask(0);
					mkdir($varfolderPath .$varFolderName, 0775);
					umask($old);
				}
				
				echo '1';exit;
				
			}
			else {
				echo 'error::Unauthorished access for this folder!!';
				exit;
			}
		
	}
	
	
	
	// Developed by kapil
	// This function is used to delete the folder
	public function deleteFolder(){
		$varFolderID 		= Input::get('folderId');
		$checkFolder = ProjectFolder::checkFolder($varFolderID);
		if($checkFolder){
		$folder= ProjectFolder::where('id', $varFolderID)->first();
		$project= Project::where('id',$folder->project_id)->first();
		if(!$project || count($project)==0){
			echo '-2';exit();
		}
		if($this->user->usertype!='admin'){
			$usrProject=UserProject::where('project_id',$folder->project_id)->where('user_id',$this->user->id)->first();			
			if($usrProject->role!='admin'){
				
				echo '-2';exit();
			}
		}
				$varfolderPath =  public_path().'/public/folders/'.$folder->project_id;
				$this->getPath($folder->parent_id );	
				$paths=explode('/',$this->folderPath);
				$revpath='';
				if($paths && count($paths)>0){
					for($i=count($paths)-1 ; $i>=0;$i--){
				          if($paths[$i]) $revpath .=$paths[$i].'/';
					}
				}
			 //echo $revpath;
				$varfolderPath.= '/'.$revpath;//die;	
			
			
			if (File::isDirectory($varfolderPath .$folder->folder_name)){								
				$delete = ProjectFolder::where('id', $varFolderID)->delete();
				rmdir($varfolderPath .$folder->folder_name);
				echo '1';
				exit;
			}
			else {
				echo '-1';
				exit;
			}
		}
		else {
			echo '-1';
			exit;
		}
	}
	
}
