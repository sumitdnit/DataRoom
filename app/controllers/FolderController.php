<?php

set_time_limit(0);

use Intervention\Image\ImageManagerStatic as Image;
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
			$datarrom=DB::table('projects')->where('status','1')->select('data_room_id as dataroom_id')->first();
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
			
			$roilearr=$this->getRoles($roleView);		
			$currentrole=$roilearr[0];
				
			echo json_encode(array('role'=>$currentrole,'folder'=>array())); exit();
			
			
		}else{
		 echo json_encode(array('role'=>'','folder'=>array())); exit();	
		}	
		
		
	}
	
	private $folderPath='';
	private function getPath($folder){
			if($folder==0){ 
				
				$this->folderPath .='';
				
			}else{
					$folderObj=ProjectFolder::where('id',$folder)->first();
					if($folderObj && count($folderObj)>0){
						$this->folderPath .=$folderObj->id .'/';
						if($folderObj->parent_id>0){
							 //$this->folderPath .=$folderObj->folder_name .'/';
							$this->getPath($folderObj->parent_id);
						}
					}
			}		
			
			
	}
	
	private $folderViewPath='';
	private function showFolders($id,$role){
		$folderObj=ProjectFolder::where('parent_id',$id)->get();
		
		if($folderObj && count($folderObj)>0){
			
			$this->folderViewPath .= '<ul>';
			foreach($folderObj as $fldr){
				$this->folderViewPath .='<li id="list_'.  $fldr->id .'" data-fld="'. $fldr->id . '"  ><a  href="#">'. $fldr->alias .'</a>';
				if($role=='admin'){
					$paralias=ProjectFolder::where('id',$fldr->parent_id)->first();
					if($paralias && count($paralias)>0){
						$parentalias=$paralias->alias;
					}else{
						$parentalias='Root';
					}
					$this->folderViewPath .='<div class="editUpdatePrj">
																
								<a href="javascript:void(0)">
									<i  class="fa fa-pencil pencil" parentalias="'. $parentalias .'"  data-id="'. $fldr->id . '" foldername="'. $fldr->alias .'"  ></i>
								</a> 
								<a href="javascript:void(0)">
									<i class="fa fa-times delete" data-id="'. $fldr->id . '" foldername="'. $fldr->alias .'"  ></i>
								</a>
							
								
							</div>';
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

		$project= Project::where('id',$projectID)->first();
		if(!$project || count($project)==0){
			
			echo json_encode( array('visiblility'=>$visible,'folder'=>'error::Unauthorished access for this folder!!')); exit();
		}
		
		$roleObj='view';
		$visible=0;
		
		$roilearr=$this->getRoles($project);		
		$roleObj=$roilearr[0];
		$visible=$roilearr[1];
		
		
		
		$folders=ProjectFolder::where('project_id',$projectID)->where('parent_id','0')->get();
		$expanded="";
		if($folders && count($folders)>0){
		$i=0;
			foreach($folders as $fldr){
				//echo $role;
				$expanded .='<li  id="list_'.  $fldr->id .'"  data-fld="'. $fldr->id . '" ><a  href="#">'. $fldr->alias .'</a>';
				$adminRole='0';
				if($roleObj=='admin'){
					$adminRole='1';
					$paralias=ProjectFolder::where('id',$fldr->parent_id)->first();
					if($paralias && count($paralias)>0){
						$parentalias=$paralias->alias;
					}else{
						$parentalias='Root';
					}
					if($i++>0){
						$expanded .='<div class="editUpdatePrj">
								
								<a href="javascript:void(0)">
									<i  class="fa fa-pencil pencil" parentalias="'. $parentalias .'"  data-id="'. $fldr->id . '" foldername="'. $fldr->alias .'"  ></i>
								</a> 
								<a href="javascript:void(0)">
									<i class="fa fa-times delete" data-id="'. $fldr->id . '" foldername="'. $fldr->alias .'"  ></i>
								</a>
							</div>';
					}		
				}
				 				
				 $expanded .='<small>Update: ' . $fldr->updated_at .'</small>';
				 
				 $this->showFolders($fldr->id,$roleObj);
				
				$expanded .=$this->folderViewPath; 
				$this->folderViewPath='';
				$expanded .='</li>';
			}
			
			echo json_encode( array('visiblility'=>$visible,'folder'=>$expanded));die;
			
		}else{
			
		  echo json_encode(array('visiblility'=>$visible,'folder'=>'<div style=" width: 85%; margin: 0 auto"><p class="alert alert-danger">No folders or files found!</p></div>'));die;
		}
		
			
	}
	
	// Developed by kapil
	// This function used to create folder name
	public function getEditFolder(){
		$varFolderID 		= Input::get('folderId');
		$projectID 		= Input::get('projectID');
		$project= Project::where('id',$projectID)->first();
		if(!$project || count($project)==0){
			echo  json_encode(array('flag'=>1,'error'=>'Unauthorished access for this folder!!')); exit;
		}
		if($this->user->usertype!='admin'){
			$usrProject=UserProject::where('project_id',$projectID)->where('user_id',$this->user->id)->first();			
			if($usrProject->role!='admin'){
				echo  json_encode(array('flag'=>1,'error'=>'Unauthorished access for this folder!!')); exit;
				 
			}
		}
		
		
		
		$varFolderName  = str_replace("'",'', str_replace('"','', str_replace('-','_', str_replace(' ','',Input::get('foldername')))));		
		$realname  = addslashes(Input::get('foldername'));
		//$checkFolder = ProjectFolder::checkFolder($varFolderID);
			if($varFolderName){
				
				$varfolderPath =  public_path().'/public/folders';
				if (!File::isDirectory($varfolderPath)){
					$old = umask(0);
					mkdir($varfolderPath, 0775);
					umask($old);
				}
				
				$projectfoldercheck=ProjectFolder::where('folder_name',$varFolderName)->where('parent_id',$varFolderID)->where('project_id',$projectID)->first();
				if($projectfoldercheck && count($projectfoldercheck)>0){
						 
						echo  json_encode(array('flag'=>1,'error'=>'Folder already exist!!')); exit;
						exit;					
				}
				
				//transaction started
				DB::beginTransaction();
				try {
						$objProjectFolder = new ProjectFolder;
						$objProjectFolder->folder_name = $varFolderName;
						$objProjectFolder->alias = $realname;
						$objProjectFolder->parent_id = $varFolderID;
						$objProjectFolder->created_at = date('Y-m-d H:i:s');
						$objProjectFolder->updated_at = date('Y-m-d H:i:s');
						$objProjectFolder->created_by = $this->user->id;
						$objProjectFolder->project_id = $projectID;
						$this->getPath($varFolderID );	
						 	$paths=explode('/',$this->folderPath);
							$revpath='';
							$folderstructure=array();
							if($paths && count($paths)>0){
								for($i=count($paths)-1 ; $i>=0;$i--){
									  if($paths[$i]){
										   $revpath .=$paths[$i].'/';
										   $folderstructure[]=$paths[$i];
									  }	   
								}
							}
						 
						$varfolderPath.= '/'.$revpath;
						if($objProjectFolder->save()){
							$old = umask(0);
							mkdir($varfolderPath .$objProjectFolder->id, 0775);
							umask($old);
							DB::commit();
							
							echo  json_encode(array('flag'=>0,'folder'=>$folderstructure)); exit;
							
						}else{
							
							 DB::rollback();
							 echo  json_encode(array('flag'=>1,'error'=>'Something gone wrong . Please try again!!')); exit;
							  
						}	
				
				} catch (\Exception $e) {
					//echo $e;
					DB::rollback();
					echo  json_encode(array('flag'=>1,'error'=>'Something gone wrong . Please try again!!')); exit; 
					
				}
			
				
			}
			else {
				 
				echo  json_encode(array('flag'=>1,'error'=>'Unauthorished access for this folder!!')); exit;
				exit;
			}
	}
	
	
	public function getupdatefolder(){
		
		$varFolderID 		= Input::get('folderId');
		$projectID 		= Input::get('projectID');
		
		$folders= ProjectFolder::where('id',$varFolderID)->first();
		if(!$folders || count($folders)==0){
			echo  json_encode(array('flag'=>1,'error'=>'Unauthorished access for this folder!!')); exit; 
			
		}
		if($folders->parent_id==0){
			echo  json_encode(array('flag'=>1,'error'=>'Unauthorished access for this folder!!')); exit; 
			 
		}
		
		$project= Project::where('id',$projectID)->first();
		if(!$project || count($project)==0){
			echo  json_encode(array('flag'=>1,'error'=>'Unauthorished access for this folder!!')); exit; 
			 
		}
		
		if($this->user->usertype!='admin'){
			$usrProject=UserProject::where('project_id',$projectID)->where('user_id',$this->user->id)->first();			
			if($usrProject->role!='admin'){				
				echo  json_encode(array('flag'=>1,'error'=>'Unauthorished access for this folder!!')); exit; 
				 
			}
		}
		
		$varFolderName  = str_replace("'",'', str_replace('"','', str_replace('-','_', str_replace(' ','',Input::get('foldername')))));
		$realname  = addslashes(Input::get('foldername'));
		
		if($varFolderName){
				
				$varfolderPath =  public_path().'/public/folders';
				
				$this->getPath($folders->parent_id );	
				$paths=explode('/',$this->folderPath);
				$revpath='';
				$folderstructure=array();
				if($paths && count($paths)>0){
					for($i=count($paths)-1 ; $i>=0;$i--){
									  if($paths[$i]){
										   $revpath .=$paths[$i].'/';
										   $folderstructure[]=$paths[$i];
									  }	 
					}
				}
				$folderstructure[]=$folders->id;
				$varfolderPath.= '/'.$revpath;
							
				$projectfoldercheck=ProjectFolder::where('folder_name',$varFolderName)->where('id','<>',$folders->id)->where('parent_id',$varFolderID)->where('project_id',$projectID)->first();
				if($projectfoldercheck && count($projectfoldercheck)>0){						
						echo  json_encode(array('flag'=>1,'error'=>'Folder already exist!!')); exit; 
						exit;					
				}
				
				try{
					$update = ProjectFolder::where('id', $folders->id)->update(array('folder_name' => $varFolderName,'alias'=> $realname , 'updated_at' =>date('Y-m-d H:i:s')));
					if (!File::isDirectory($varfolderPath .$folders->id )){
						$old = umask(0);
						mkdir($varfolderPath.$folders->id, 0775);
						umask($old);
					}
					echo  json_encode(array('flag'=>0,'folder'=>$folderstructure)); exit; 
				}catch(Exception $e){
					echo  json_encode(array('flag'=>1,'error'=>'Something gone wrong . Please try again!!')); exit; 
				}
				
			}
			else {
				echo  json_encode(array('flag'=>1,'error'=>'Unauthorished access for this folder!!')); exit; 				
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
			echo json_encode(array('flag'=>-2));exit();
		}
		
		if($folder->parent_id==''){
			echo json_encode(array('flag'=>-2));exit();
		}
		
		if($this->user->usertype!='admin'){
			$usrProject=UserProject::where('project_id',$folder->project_id)->where('user_id',$this->user->id)->first();			
			if($usrProject->role!='admin'){
				
				echo json_encode(array('flag'=>-2));exit();
			}
		}
				$varfolderPath =  public_path().'/public/folders';
				$this->getPath($folder->parent_id );	
				$paths=explode('/',$this->folderPath);
				$revpath='';
				$folderstructure=array();
				if($paths && count($paths)>0){
					for($i=count($paths)-1 ; $i>=0;$i--){
									  if($paths[$i]){
										   $revpath .=$paths[$i].'/';
										   $folderstructure[]=$paths[$i];
									  }	 
					}
				}
			 
				$varfolderPath.= '/'.$revpath;	
				$this->deletedID=array();
				$this->deleteRecursive($varFolderID);
				$this->deletedID[]=$folder->id;				
				
				if($this->deletedID && count($this->deletedID)>0){
					DB::beginTransaction();					 
					try{
						ProjectFolder::whereIn('id', $this->deletedID)->delete();
						Files::whereIn('folder_id', $this->deletedID)->delete();
						DB::commit();
						
					}catch(Exception $e){
						
						DB::rollback();
						echo json_encode(array('flag'=>-2));exit();
					}	
					$this->removeDirectory($varfolderPath . $folder->id);						
					//@rmdir($varfolderPath.$folder->id);
					echo json_encode(array('flag'=>1, 'folder'=>$folderstructure));exit();
					
					
					
				}else{
					
					echo json_encode(array('flag'=>-1));exit();
					
				}
			
		}
		else {
			echo json_encode(array('flag'=>-1));exit();
			
		}
	}
	
	private function removeDirectory($path) {
		$files = glob($path . '/*');
		foreach ($files as $file) {
			is_dir($file) ? $this->removeDirectory($file) : unlink($file);
		}
		rmdir($path);
		return;
	}
	private $deletedID=array();
	
	private function deleteRecursive($id){
	
			$par=ProjectFolder::where('parent_id',$id)->get();
			if($par && count($par)>0){
				foreach($par as $pr){
					$this->deletedID[]=$pr->id;
					$this->deleteRecursive($pr->id);
				}
			}
		
	}
	
	private function getRoles($roleView){
		
	 if($this->user->usertype=="admin") {
			
			$roleObj='admin';
			$visible=1;
			
		}else{
			
			$dataRoomID=$roleView->data_room_id	;
					$datObj=Dataroom::where('id',$dataRoomID);
					if($datObj->view_only==1){
						$roleObj='view';
						$visible=0;
					}else{
						
						if($roleView->view_only == 1){
							$roleObj="view";
							$visible=0;
						}else{
							
							$role=UserProject::where('project_id',$projectID)->where('user_id',$this->user->id)->first();	
							if($role && count($role)>0){
							
										if($role->role=='admin'){
											$roleObj=$role->role;
											$visible=1;
										}else if($userrole=='download'){
											$roleObj=$role->role;
											$visible=2;
										}else if($userrole=='upload'){
											$roleObj=$role->role;
											$visible=3;
										}else{
											$roleObj=$role->role;
											$visible=0;
										}
								}
						}						
				    }
			}
			
			return array($roleObj,$visible);
	}
	
	
	public function showfiles() {
		 
		if (Input::has('folder')) {
			
			$folders=ProjectFolder::where('id',Input::get('folder'))->first();
			if(!$folders || count($folders)==0)	{
					$response['status'] = 'error';
					$response['message'] = 'Folder not found!';
					return Response::json($response);
			}
				
			$projectID 		= $folders->project_id;
			$project= Project::where('id',$projectID)->first();
			if(!$project || count($project)==0){
				
					$response['status'] = 'error';
					$response['message'] = 'You have not access on this project!';
					return Response::json($response);
			}
			$flag=false;
			$roilearr=$this->getRoles($project);		
			$roleObj=$roilearr[0];
			
			$files=Files::where('folder_id',$folders->id)->get();
			 
			$filesarr=array();
			if($files && count($files)>0){
				$i=0;
				foreach($files as $fls){
						$filesarr[$i]['id']=base64_encode($fls->id);
						$filesarr[$i]['code']=($fls->id);
						$filesarr[$i]['name']=$fls->alias;
						$filesarr[$i]['dated']= date('m/d/Y | h:i A',strtotime($fls->date));
						$filesarr[$i++]['role']=$roleObj;
				}
			}
			$response['status'] = 'success';
			$response['result'] = $filesarr;
			return Response::json($response);
			
			
			
		}else{
			$response['status'] = 'error';
			$response['message'] = 'Folder not found!';
			return Response::json($response);
		}
	}
	
		
	
	public function renamefiles() {
		 
		if (Input::has('files') && Input::has('fid')) {
			  $fid=base64_decode(Input::get('fid'));
			$files=Files::where('id',$fid)->first();
			if(!$files || count($files)==0)	{
					$response['status'] = 'error';
					$response['message'] = 'Files not found!';
					return Response::json($response);
			}
			
			$folders=ProjectFolder::where('id',$files->folder_id)->first();
			if(!$folders || count($folders)==0)	{
					$response['status'] = 'error';
					$response['message'] = 'Folder not found!';
					return Response::json($response);
			}
				
			$projectID 		= $folders->project_id;
			$project= Project::where('id',$projectID)->first();
			if(!$project || count($project)==0){
				
					$response['status'] = 'error';
					$response['message'] = 'You have not access on this project!';
					return Response::json($response);
			}
			$flag=false;
			$roilearr=$this->getRoles($project);		
			$roleObj=$roilearr[0];
			if($roleObj!='admin'){
				$response['status'] = 'error';
					$response['message'] = 'You have not access on this file!';
					return Response::json($response);
			}
			
			
			$new_name =  str_replace("'",'', str_replace('"','', str_replace('-','_', str_replace(' ','', Input::get('files')))));
			
			
			$varfolderPath =  public_path().'/public/folders/';
			if (!File::isDirectory($varfolderPath)){
				$response['status'] = 'error';
				$response['message'] = 'Server error. Folder directory not found!';
				return Response::json($response);
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
			$varfolderPath.= '/'.$revpath; 
			//try{
				
				$duplicate=Files::where('id','<>',$fid)->where('file_name',$new_name)->first();
				if($duplicate && count($duplicate)>0){
					$response['status'] = 'error';
					$response['message'] = 'Duplicate File. File already exist!';
					return Response::json($response);
				}
				
				$dir=$varfolderPath. $folders->id .'/'.$files->file_name;			
				if (file_exists($dir)) {
				
					if(rename ( $dir ,$varfolderPath . $folders->id .'/'. $new_name)){
						
						$update = Files::where('id', $files->id)->update(array('file_name' => $new_name,'alias'=> Input::get('files') , 'updated_at' =>date('Y-m-d H:i:s')));
						$response['status'] = 'success';
						$response['message'] = 'Files is renamed successfully!';
						return Response::json($response);
					}else{
					
						$response['status'] = 'error';
						$response['message'] = 'File structure not found on server .Something gone wrong.!';
						return Response::json($response);
					}
				}else{
					
					$response['status'] = 'error';
						$response['message'] = 'File structure not found on server .Something gone wrong.!';
						return Response::json($response);
				}
			
		}else{
			
			$response['status'] = 'error';
			$response['message'] = 'Folder not found!';
			return Response::json($response);
		}
	}
	
	public function deletefiles() {
		 
		if (Input::has('fid')) {
			  $fid=base64_decode(Input::get('fid'));
			$files=Files::where('id',$fid)->first();
			if(!$files || count($files)==0)	{
					$response['status'] = 'error';
					$response['message'] = 'Files not found!';
					return Response::json($response);
			}
			
			$folders=ProjectFolder::where('id',$files->folder_id)->first();
			if(!$folders || count($folders)==0)	{
					$response['status'] = 'error';
					$response['message'] = 'Folder not found!';
					return Response::json($response);
			}
				
			$projectID 		= $folders->project_id;
			$project= Project::where('id',$projectID)->first();
			if(!$project || count($project)==0){
				
					$response['status'] = 'error';
					$response['message'] = 'You have not access on this project!';
					return Response::json($response);
			}
			$flag=false;
			$roilearr=$this->getRoles($project);		
			$roleObj=$roilearr[0];
			if($roleObj!='admin'){
				$response['status'] = 'error';
					$response['message'] = 'You have not access on this file!';
					return Response::json($response);
			}
			
		
			
			$varfolderPath =  public_path().'/public/folders';
			if (!File::isDirectory($varfolderPath)){
				$response['status'] = 'error';
				$response['message'] = 'Server error. Folder directory not found!';
				return Response::json($response);
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
			$varfolderPath.= '/'.$revpath; 
			
			if($delete = Files::where('id', $files->id)->delete()){
				
					@unlink($varfolderPath.$files->file_name);
					$response['status'] = 'success';
					$response['message'] = 'Files is deleted successfully!';
					return Response::json($response);
			}else{
			
				$response['status'] = 'error';
				$response['message'] = 'Something gone wrong.!';
				return Response::json($response);
			}
				
			
		}else{
			
			$response['status'] = 'error';
			$response['message'] = 'Files not found!';
			return Response::json($response);
		}
	}
	
	
	public function download() {
		 
		if (Input::has('file')) {
			  $fid=base64_decode(Input::get('file'));  
			$files=Files::where('id',$fid)->first();
			if(!$files || count($files)==0)	{
					Toastr::error('You have not access on this file!');	
					return Redirect::to('/dataroom/users/folder');
			}
			
			$folders=ProjectFolder::where('id',$files->folder_id)->first();
			if(!$folders || count($folders)==0)	{
					Toastr::error('You have not access on this file!');	
					return Redirect::to('/dataroom/users/folder/');
			}
				
			$projectID 		= $folders->project_id;
			$project= Project::where('id',$projectID)->first();
			if(!$project || count($project)==0){
				
					Toastr::error('You have not access on this file!');	
					return Redirect::to('/dataroom/users/folder/?p='.base64_encode($projectID));
			}
			$flag=false;
			$roilearr=$this->getRoles($project);		
			$roleObj=$roilearr[0];
			if($roleObj!='admin'){

					Toastr::error('You have not access on this file!');	
					return Redirect::to('/dataroom/users/folder/?p='.base64_encode($projectID));
			}
			
		
			
			$varfolderPath =  public_path().'/public/folders';
			if (!File::isDirectory($varfolderPath)){

				Toastr::error('Server error. Folder directory not found!');	
				return Redirect::to('/dataroom/users/folder/?p='.base64_encode($projectID));
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
			$varfolderPath.= '/'.$revpath; 
			$dir=$varfolderPath. $folders->id .'/'.$files->file_name; 
			if (file_exists($dir)) {
				header('Content-Description: File Transfer');
				header('Content-Type: '. $files->mime);
				header('Content-Disposition: attachment; filename='.basename($dir));
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize($dir));
				ob_clean();
				flush();
				readfile($dir);
				exit();
				
			}else{
				Toastr::error('File not found!!');	
				return Redirect::to('/dataroom/users/folder/?p='.base64_encode($projectID));
			}
			
		}else{
			
			Toastr::error('File not found!!');	
			return Redirect::to('/dataroom/users/folder');
		}
	}
	
		
	public function uploadFile() {
		$response = array();
		$path = '';
		$new_name = '';
		if (Input::hasFile('files_multiple') && Input::has('folder')) {
			
		$folders=ProjectFolder::where('id',Input::get('folder'))->first();
		if(!$folders || count($folders)==0)	{
				$response['status'] = 'error';
				$response['message'] = 'Folder not found!';
				return Response::json($response);
		}
			
		$projectID 		= $folders->project_id;
		$project= Project::where('id',$projectID)->first();
		if(!$project || count($project)==0){
			
				$response['status'] = 'error';
				$response['message'] = 'You have not access on this project!';
				return Response::json($response);
		}
		$flag=false;
		$roilearr=$this->getRoles($project);		
		$roleObj=$roilearr[0];
		if($roleObj=='admin' || $roleObj=='upload') $flag=true;
		
			
		if($flag){
			$fileobj = Input::file('files_multiple')[0];
			
			//print_r($fileobj);
			if($fileobj->getError()==1 || $fileobj->getError()==2){
				$response['status'] = 'error';
				$response['message'] = 'Server error. There is limit for max file size 2 GB!';
				return Response::json($response);
			}else if($fileobj->getError()>2){
				$response['status'] = 'error';
				$response['message'] = 'This file has some error!';
				return Response::json($response);
			}
			
			if($fileobj->getMaxFilesize() >1073741824*2){
				
				$response['status'] = 'error';
				$response['message'] = 'You can upload file upto 2 GB!';
				return Response::json($response);
			}
			
			$mime_type =$fileobj->getMimeType();
			$ext = $fileobj->getClientOriginalExtension();
			$orgName = $fileobj->getClientOriginalName();
			$size=$fileobj->getMaxFilesize();
			$mime=$fileobj->getMimeType();
			$new_name =  str_replace("'",'', str_replace('"','', str_replace('-','_', str_replace(' ','', $fileobj->getClientOriginalName()))));
			
			
			$varfolderPath =  public_path().'/public/folders/';
			if (!File::isDirectory($varfolderPath)){
				$response['status'] = 'error';
				$response['message'] = 'Server error. Folder directory not found!';
				return Response::json($response);
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
			$varfolderPath.= '/'.$revpath. $folders->id .'/'; 
			//try{
				
				$duplicate=Files::where('folder_id',$folders->id)->where('file_name',$new_name)->first();
				if($duplicate && count($duplicate)>0){
					$response['status'] = 'error';
					$response['message'] = 'Duplicate File. File already exist!';
					return Response::json($response);
				}
				
				
				$path = $fileobj->move($varfolderPath,$new_name);
				 
				
				
				if($path){
					
					$objProjectFolder = new Files;
					$objProjectFolder->file_name=$new_name;
					$objProjectFolder->folder_id=$folders->id;
					$objProjectFolder->size=$size;
					$objProjectFolder->ext=$ext;
					$objProjectFolder->mime=$mime;
					$objProjectFolder->created_at=date('Y-m-d H:i:s');
					$objProjectFolder->updated_at=date('Y-m-d H:i:s');
					$objProjectFolder->created_by=$this->user->id;
					$objProjectFolder->alias=$orgName;
					if(!$objProjectFolder->save()){
						$response['status'] = 'error';
						$response['message'] = 'Something gone wrong . Please try again';
						
					}else{
					
						$response['status'] = 'success';
						$response['message'] = 'File has been uploaded successfully';
					
						return Response::json($response);
						
					}
					
								
				}else{
					
					$response['status'] = 'error';
					$response['message'] = 'Unable to upload this file. Please try again.';
					
				}
			//}catch(Exception $e){
				
				//$response['status'] = 'error';
				//$response['message'] = $e->getMessage();
			//}
			
		}else{
			
			 	$response['status'] = 'error';
				$response['message'] = 'You have not access to upload file.';
			
		}
	
	   }else{
					$response['status'] = 'error';
					$response['message'] = 'Unauthorized Access';
	   }

		return Response::json($response);
	}
	
}
