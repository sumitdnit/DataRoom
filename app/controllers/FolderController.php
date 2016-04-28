<?php

set_time_limit(0);

use Intervention\Image\ImageManagerStatic as Image;
class FolderController extends BaseController {
	
	public $userid;
	public $email;
	public $folderModel;
	
	
	public function __construct() {		 
		
		$this->beforeFilter('auth');
		parent::__construct();
		if (Sentry::check()) {
			$this->user = Sentry::getUser();
			$this->userid = $this->user->id;		   
			$tmp = DB::table('users')->select('email')->where('id','=', $this->user->id)->first();
			$this->folderModel=new ProjectFolder();
			$this->email = $tmp->email;
		}
	}
	

	// @pankaj  ControllerFor creating Folder under dataRoom and Project
	public function listFolder(){ 
		// GEt user Dataroom
		$arrListedArray = array();
		$encodeproj='0';
		$encodedatroom='0';
		$projarr=Input::get('p');
		$encodedatroom='0';
		$arrUserDataRoom=array();
		$arrUserProject=null;
		try{
			
			if($projarr){
			  $encodeproj=base64_decode($projarr);
				
				// Check user is authodished to access that project
				if($this->user->usertype != "admin"){
						$checkUserForDataRoom = UserProject::where('project_id', $encodeproj)->where('user_id',$this->user->id)->first();
						if($checkUserForDataRoom == null){
							return View::make('project/error');
						}
				}
			}
		
			checkLocations::getUserlog('view','folder');
			$arrUserDataRoom = Dataroom::getAllDataRoom($this->user->id, $this->user->usertype);
			if($projarr){
			  if($encodeproj){
					$datarrom=DB::table('projects')->where('id',$encodeproj)->where('status','1')->select('data_room_id as dataroom_id')->first();
					$encodedatroom=$datarrom->dataroom_id;
					if($encodedatroom){
						$arrUserProject = Project::getAllProjects($encodedatroom,$this->user->id,$this->user->usertype);
					}
				}
			}else{
				if($arrUserDataRoom && count($arrUserDataRoom)>0){
					$encodedatroom=$arrUserDataRoom[0]->roomid;
					$arrUserProject = Project::getAllProjects($encodedatroom,$this->user->id,$this->user->usertype);
					//print_r($arrUserProject);die;
					if($arrUserProject && count($arrUserProject)>0){
						$encodeproj=$arrUserProject[0]->projid;
					}
					
				}				
			}
		}catch(Exception $e){}
		
		$arrUDataRoom = $arrUserDataRoom;
		
		$arr = array('dataroom'=>$arrUDataRoom,'projects'=>$arrUserProject,'currentUserType'=>$this->user->usertype,'projectid'=>$encodeproj ,'dataroomid'=>$encodedatroom);	
		return View::make('folder/user-folder')->with('data', $arr);
	}
	

	//  Controller function is used to list project related with user dataroom
	public function getUserProject(){
		 
			$varDataRoomID = addslashes(Input::get('drId'));
			return $arrUserProject = Project::getAllProjects($varDataRoomID,$this->user->id,$this->user->usertype);
		  
	}
	
	// @pankaj Controller function is used to get project related with user dataroom
	public function getProjectInfo(){
		try{
			$varProjectID = addslashes(Input::get('drId'));
			$roleView=Project::where('id',$varProjectID)->first();
			$userrole='';
			if($roleView && count($roleView)>0){			
				$roilearr=$this->folderModel->getRoles($roleView,$this->user);					
				$currentrole=$roilearr[0];	
				$projectUsers = DB::table('user_project')
					->leftJoin('profiles', 'user_project.user_id', '=', 'profiles.user_id')            
					->select('profiles.user_id', 'firstname', 'lastname','profiles.photo')->where('project_id',$roleView->id)
					->get();
						 
				
				echo json_encode(array('role'=>$currentrole,'folder'=>array(),'users'=>$projectUsers)); exit();
				
				
			}else{
			 echo json_encode(array('role'=>'','folder'=>array(),'users'=>array())); exit();	
			}	
		}catch(Exception $e){
			echo $e;die;
		  echo json_encode(array('role'=>'','folder'=>array(),'users'=>array())); exit();		
		}	
		
	}


	// @pankaj Controller function is used to list all folder recursevily
	public function listfolders(){
		try{	 	
			$projectID 		= Input::get('projectID');

			$project= Project::where('id',$projectID)->first();
			if(!$project || count($project)==0){
				
				echo json_encode( array('visiblility'=>$visible,'folder'=>'error::Unauthorished access for this folder!!')); exit();
			}
			
			$roleObj='view';
			$visible=0;		
			$roilearr=$this->folderModel->getRoles($project,$this->user);		
			$roleObj=$roilearr[0];
			$visible=$roilearr[1];
			$folders=ProjectFolder::where('project_id',$projectID)->where('parent_id','0')->get();
			$expanded="";
			$foldernodes=array();

			if($folders && count($folders)>0){
			$i=0;
			$ctr=0;
			
				foreach($folders as $fldr){
					
					$foldernodes[$i]['text']=$fldr->alias;
					$foldernodes[$i]['id']=base64_encode($fldr->id);				
					$access=0;
					if($roleObj=='upload'){
						if($fldr->created_by==$this->user->id){
							$access=2;	
						}else{
								$access=1;	
						}
					}elseif($roleObj=='admin'){
					  $access=2;	
					}
					
					$foldernodes[$i]['access']=$access;				
					$result=$this->folderModel->getCategoryTreeForParentId($fldr->id,$roleObj);
					if($result && count($result)>0){
						$foldernodes[$i++]['nodes']=$result;
					}
				}			
				echo json_encode( array('visiblility'=>$visible,'folder'=>$foldernodes));die;
				
			}else{
				
			  echo json_encode(array('visiblility'=>$visible,'folder'=>array()));die;
			}
		
		}catch(Exception $e){
			//echo $e;
			echo json_encode(array('visiblility'=>'0','folder'=>array()));die;
		}
		
			
	}
	
	// Developed by kapil
	//modified by  @pankaj Controller  function used to create folder name
	public function getEditFolder(){
		
		
			$varFolderID 		= base64_decode(Input::get('folderId'));
			$projectID 		= Input::get('projectID');
			$project=$this->folderModel->checkValidProject($projectID,$this->user);
			if(!$project){
					echo  json_encode(array('flag'=>1,'error'=>'Unauthorished access for this folder!!')); exit;
			}
		
			$roilearr=$this->folderModel->getRoles($project,$this->user);		
			$currentrole=$roilearr[0];			
			
			if($currentrole=='admin' || $currentrole=='upload' ){
			
					$varFolderName  = str_replace("'",'', str_replace('"','', str_replace('-','_', str_replace(' ','',Input::get('foldername')))));		
					$realname  = addslashes(Input::get('foldername'));
				
			}	else {
				echo  json_encode(array('flag'=>1,'error'=>'You have not access to create folder!!')); exit;
				exit;
			}

			try {
				
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
							
							$revpath=$this->folderModel->getFolderStructure($varFolderID );
							$varfolderPath.= '/'.$revpath[0];
							if($objProjectFolder->save()){
								checkLocations::getUserlog('post add','folder',$varFolderID);
								$old = umask(0);
								mkdir($varfolderPath .$objProjectFolder->id, 0775);
								umask($old);
								DB::commit();
								echo  json_encode(array('flag'=>0,'folder'=>$revpath[1])); exit;
								
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
		}catch(Exception $e){
			
					echo  json_encode(array('flag'=>1,'error'=>'Something gone wrong!!')); exit;
					exit;
		}
	}
	
	// @pankaj Controller function for rename folder
	public function getupdatefolder(){
		
		$varFolderID 		= base64_decode(Input::get('folderId'));
		$projectID 		= Input::get('projectID');
		$project=$this->folderModel->checkValidProject($projectID,$this->user);
		if(!$project){
					echo  json_encode(array('flag'=>1,'error'=>'Unauthorished access for this folder!!')); exit;
		}
		
		$folders=$this->folderModel->checkValidFolder($varFolderID );
		if(!$folders){
					echo  json_encode(array('flag'=>1,'error'=>'Unauthorished access for this folder!!')); exit;
		}
		
		if($folders->parent_id==0){
				echo  json_encode(array('flag'=>1,'error'=>'You can\'t edit paraent folder!!')); exit;
				return false;
				 
		}
		
		$roilearr=$this->folderModel->getRoles($project,$this->user);
		$currentrole=$roilearr[0];
		if($currentrole=='admin' ){
				
				if($currentrole=='upload'){
				   if($folders->created_by!= $this->user->id){
						echo  json_encode(array('flag'=>1,'error'=>'You have not access to edit folder!!')); exit;
						exit;					   
				   }	
				}
				
		}	else {
			echo  json_encode(array('flag'=>1,'error'=>'You have not access to edit folder!!')); exit;
			exit;
		}
		
		$varFolderName  = str_replace("'",'', str_replace('"','', str_replace('-','_', str_replace(' ','',Input::get('foldername')))));
		$realname  = addslashes(Input::get('foldername'));
		
		if($varFolderName){
				
				$varfolderPath =  public_path().'/public/folders';
				$revpath=$this->folderModel->getFolderStructure($varFolderID );
				$folderstructure=$revpath[1];
				$folderstructure[]=$folders->id;
				$varfolderPath.= '/'.$revpath[0];
				try{
								
					$projectfoldercheck=ProjectFolder::where('folder_name',$varFolderName)->where('id','<>',$folders->id)->where('parent_id',$varFolderID)->where('project_id',$projectID)->first();
					if($projectfoldercheck && count($projectfoldercheck)>0){						
							echo  json_encode(array('flag'=>1,'error'=>'Folder already exist!!')); exit; 
							exit;					
					}
				
				
					$update = ProjectFolder::where('id', $folders->id)->update(array('folder_name' => $varFolderName,'alias'=> $realname , 'updated_at' =>date('Y-m-d H:i:s')));
					$logid = checkLocations::getUserlog('post update','folder',$varFolderID);
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
	//modified by  @pankaj Controller  function is used to delete the folder
	public function deleteFolder(){
		try{
			
			$varFolderID 		= base64_decode(Input::get('fid'));
			$folder=$this->folderModel->checkValidFolder($varFolderID );
			if(!$folder){
						echo  json_encode(array('flag'=>1,'error'=>'Unauthorished access for this folder!!')); exit;
			}
			
			$project=$this->folderModel->checkValidProject($folder->project_id,$this->user);
			if(!$project){
						echo  json_encode(array('flag'=>1,'error'=>'Unauthorished access for this folder!!')); exit;
			}		
			
			if($folder->parent_id=='0'){
				echo json_encode(array('flag'=>-2,'error'=>'Can\'t delete parent folder!!'));exit();
			}
			$roilearr=$this->folderModel->getRoles($project,$this->user);
			$currentrole=$roilearr[0];
			if($currentrole=='admin'){				
					if($currentrole=='upload'){
					   if($folder->created_by!= $this->user->id){
							echo json_encode(array('flag'=>-2));exit();
							exit;					   
					   }	
					}
					
			}	else {
				echo json_encode(array('flag'=>-2));exit();
				exit;
			}
			
			
					$varfolderPath =  public_path().'/public/folders';
					$revpath=$this->folderModel->getFolderStructure($folder->parent_id );
					$varfolderPath.= '/'.$revpath[0];
					
					$this->folderModel->deleteRecursive($varFolderID);
					$this->folderModel->deletedID[]=$folder->id;				
					
					if($this->folderModel->deletedID && count($this->folderModel->deletedID)>0){
						DB::beginTransaction();					 
						try{
							ProjectFolder::whereIn('id', $this->folderModel->deletedID)->delete();
							Files::whereIn('folder_id', $this->folderModel->deletedID)->delete();
							$logid = checkLocations::getUserlog('delete','folder',$varFolderID);
							DB::commit();
							
						}catch(Exception $e){
							
							DB::rollback();
							echo json_encode(array('flag'=>-2));exit();
						}	
						$this->folderModel->removeDirectory($varfolderPath . $folder->id);						
						//@rmdir($varfolderPath.$folder->id);
						echo json_encode(array('flag'=>1, 'folder'=>$revpath[1]));exit();
						
						
						
					}else{
						
						echo json_encode(array('flag'=>-1));exit();
						
					}
		
		}catch(Exception $e){
			echo json_encode(array('flag'=>-2));exit();
		}
	}
	

	// @pankaj Controller function for show all files
	public function showfiles() {
		 
				$paramsFolder= base64_decode(Input::get('folder'));
				if ($paramsFolder) {
					
					$folders=$this->folderModel->checkValidFolder($paramsFolder );
					if(!$folders){
							$response['status'] = 'error';
							$response['message'] = 'Folder not found!';
							return Response::json($response);
					}
					$projectID 		= $folders->project_id;
					$project=$this->folderModel->checkValidProject($folders->project_id,$this->user);
					if(!$project){
								echo  json_encode(array('status'=>'error','message'=>'Unauthorished access for this folder!!')); exit;
					}
				
					$flag=false;
					$roilearr=$this->folderModel->getRoles($paramsFolder,$project,$this->user);		
					$roleObj=$roilearr[0];
								
					
					$response['status'] = 'success';
					$response['result'] = $this->folderModel->getFiles($folders->id,$roleObj,$this->user);
					return Response::json($response);
					
					
					
				}else{
					$response['status'] = 'error';
					$response['message'] = 'Folder not found!';
					return Response::json($response);
				}
		
	}
	
		
	// @pankaj Controller function for rename files
	public function renamefiles() {
		 
		if (Input::has('files') && Input::has('fid')) {
			  $fid=base64_decode(Input::get('fid'));
			  
			  
			$files=$this->folderModel->checkValidFiles($fid );
			if(!$files)	{
					$response['status'] = 'error';
					$response['message'] = 'Files not found!';
					return Response::json($response);
			}
			
			$folders=$this->folderModel->checkValidFolder($files->folder_id );
			if(!$folders){
					$response['status'] = 'error';
					$response['message'] = 'Folder not found!';
					return Response::json($response);
			}
			
			$projectID 		= $folders->project_id;
			$project=$this->folderModel->checkValidProject($folders->project_id,$this->user);
			if(!$project){
						echo  json_encode(array('status'=>'error','message'=>'Unauthorished access for this folder!!')); exit;
			}  
			
		
			$roilearr=$this->folderModel->getRoles($project,$this->user);
			$currentrole=$roilearr[0];
			if($currentrole=='admin' || $currentrole=='upload'){
					if($currentrole=='upload'){
					   if($files->created_by!= $this->user->id){
							$response['status'] = 'error';
							$response['message'] = 'You have not access on this file!';
							return Response::json($response);					   
					   }	
					}
					
			}	else {
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
				$revpath=$this->folderModel->getFolderStructure($folders->parent_id );	
				$varfolderPath.= $revpath[0]; 
			
			try{
				
				$duplicate=Files::where('id','<>',$fid)->where('file_name',$new_name)->where('folder_id',$files->folder_id)->first();
				if($duplicate && count($duplicate)>0){
					$response['status'] = 'error';
					$response['message'] = 'Duplicate File. File already exist!';
					return Response::json($response);
				}
				
				$dir=$varfolderPath. $folders->id .'/'.$files->id . '.'. $files->ext;			
				if (file_exists($dir)) {
						$logid = checkLocations::getUserlog('rename','file',$files->id );
						$update = Files::where('id', $files->id)->update(array(/*'ext'=>$extension,*/'file_name' => $new_name,'alias'=> Input::get('files') , 'updated_at' =>date('Y-m-d H:i:s')));
						$response['status'] = 'success';
						$response['message'] = 'File was renamed successfully!';
						return Response::json($response);
					
				}else{
					
						$response['status'] = 'error';
						$response['message'] = 'File structure not found on server .Something gone wrong.!';
						return Response::json($response);
				}
				
			}catch(Exception $e){
					
						$response['status'] = 'error';
						$response['message'] = 'Something gone wrong please try again.!';
						return Response::json($response);
						
			}	
			
		}else{
			
			$response['status'] = 'error';
			$response['message'] = 'Folder not found!';
			return Response::json($response);
		}
	}
	
	// @pankaj Controller function for delete files
	public function deletefiles() {
		 
		if (Input::has('fid')) {
			  $fid=base64_decode(Input::get('fid'));
		$files=$this->folderModel->checkValidFiles($fid );
		if(!$files)	{
				$response['status'] = 'error';
				$response['message'] = 'Files not found!';
				return Response::json($response);
		}
		
		$folders=$this->folderModel->checkValidFolder($files->folder_id );
		if(!$folders){
				$response['status'] = 'error';
				$response['message'] = 'Folder not found!';
				return Response::json($response);
		}
		
		$projectID 		= $folders->project_id;
		$project=$this->folderModel->checkValidProject($folders->project_id,$this->user);
		if(!$project){
					echo  json_encode(array('status'=>'error','message'=>'Unauthorished access for this project!!')); exit;
		} 
			
		
		
		$roilearr=$this->folderModel->getRoles($project,$this->user);
		$currentrole=$roilearr[0];
		if($currentrole=='admin' || $currentrole=='upload'){
				if($currentrole=='upload'){
				   if($files->created_by!= $this->user->id){
						$response['status'] = 'error';
						$response['message'] = 'You have not access on this file!';
						return Response::json($response);					   
				   }	
				}
				
		}	else {
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
				
			$revpath=$this->folderModel->getFolderStructure($folders->parent_id );			 
			$varfolderPath.= '/'.$revpath[0]. $folders->id .'/'; 
			DB::beginTransaction();		 
			try{
				if($delete = Files::where('id', $files->id)->delete()){
					
						unlink($varfolderPath.$files->id. '.'.$files->ext);
						$logid = checkLocations::getUserlog('delete','file',$files->id );
						$response['status'] = 'success';
						$response['message'] = 'Files was deleted successfully!';
						DB::commit();
						return Response::json($response);
				}else{
					DB::rollback();
					$response['status'] = 'error';
					$response['message'] = 'Something gone wrong.!';
					return Response::json($response);
				}
			}catch(Exception $e){
				echo $e;
						DB::rollback();
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
	
	// @pankaj Controller function for copy  files
	public function copyFile(){
		$fid=base64_decode(Input::get('src'));
		$files=$this->folderModel->checkValidFiles($fid );
		if(!$files)	{
				$response['status'] = 'error';
				$response['message'] = 'Files not found!';
				return Response::json($response);
		}
		
		$folders=$this->folderModel->checkValidFolder($files->folder_id );
		if(!$folders){
				$response['status'] = 'error';
				$response['message'] = 'File not found!';
				return Response::json($response);
		}
		
		$projectID 		= $folders->project_id;
		$project=$this->folderModel->checkValidProject($folders->project_id,$this->user);
		if(!$project){
					echo  json_encode(array('status'=>'error','message'=>'Unauthorished access for this file!!')); exit;
		} 
		
		
		if($this->user->usertype!='admin'){
			echo  json_encode(array('status'=>'error','message'=>'Unauthorished access for this file!!')); exit;
		}
		$varfolderPath =  public_path().'/public/folders';
			if (!File::isDirectory($varfolderPath)){
				
				$response['status'] = 'error';
				$response['message'] = 'Server error File not found!';
				return Response::json($response);
			}	
				
			$revpath=$this->folderModel->getFolderStructure($folders->parent_id );	
			$varfolderPath.= '/'.$revpath[0]; 
			$dir=$varfolderPath. $folders->id .'/'.$files->id . '.' . $files->ext; 
			if (file_exists($dir)) {
				 $new_name =  str_replace("'",'', str_replace('"','', str_replace('-','_', str_replace(' ','', Input::get('des')))));
				DB::beginTransaction();	
				try{	
					$duplicate=Files::where('folder_id',$folders->id)->where('file_name',$new_name)->first();
					if($duplicate && count($duplicate)>0){
						$response['success'] = false;
						$response['error'] = '9';
						$response['message'] = 'Duplicate File. File already exist!';
						return Response::json($response);
					}
				
					$flag=false;
					$objProjectFolder = new Files;
					$objProjectFolder->file_name=$new_name;
					$objProjectFolder->folder_id=$files->folder_id;
					$objProjectFolder->size=$files->size;
					$objProjectFolder->ext=$files->ext;
					$objProjectFolder->mime=$files->mime;
					$objProjectFolder->created_at=date('Y-m-d H:i:s');
					$objProjectFolder->updated_at=date('Y-m-d H:i:s');
					$objProjectFolder->created_by=$this->user->id;
					$objProjectFolder->alias=Input::get('des');
					if($objProjectFolder->save()){
						if(copy( $dir , $varfolderPath. $folders->id .'/'.$objProjectFolder->id . '.' . $files->ext )){
							$logid = checkLocations::getUserlog('copy','file',$files->id );
							DB::commit();
							$flag=true;
							$response['success'] = true;						
							$response['message'] = 'File has copied successfully!';	
							return Response::json($response);
						}else{
						 $flag=false;	
						}
					}else{
					  $flag=false;
					}
					
					if(!$flag){
						$response['success'] = false;
						$response['error'] = '9';
						$response['message'] = 'Something gone wrong. Please try again!';
						DB::rollback();
						return Response::json($response);
					}
					
				}catch(Exception $e){
					$response['success'] = false;
					$response['error'] = '9';
					$response['message'] = 'Something gone wrong. Please try again!';
					DB::rollback();
					return Response::json($response);
				}
				
				
			}else{
				$response['status'] = 'error';
				$response['message'] = 'Server error File not found!';
				return Response::json($response);
			}
		
			
		
	}
	
	// @pankaj Controller function for download files
	public function download() {
		 
		if (Input::has('file')) {
			  $fid=base64_decode(Input::get('file'));  
			  
			$files=$this->folderModel->checkValidFiles($fid );
			if(!$files)	{
					$response['status'] = 'error';
					$response['message'] = 'Files not found!';
					return Response::json($response);
			}
			
			$folders=$this->folderModel->checkValidFolder($files->folder_id );
			if(!$folders){
					$response['status'] = 'error';
					$response['message'] = 'Folder not found!';
					return Response::json($response);
			}
			
			$projectID 		= $folders->project_id;
			$project=$this->folderModel->checkValidProject($folders->project_id,$this->user);
			if(!$project){
						echo  json_encode(array('status'=>'error','message'=>'Unauthorished access for this folder!!')); exit;
			} 
			  
			$flag=false;
			$roilearr=$this->folderModel->getRoles($project,$this->user);		
			$roleObj=$roilearr[0];
			if($roleObj=='admin' || $roleObj=='upload' || $roleObj=='download'){
					if (Input::has('check')) {
						$response['status'] = 'success';					
						return Response::json($response);
					}
					
			}else{
					$response['status'] = 'error';					
					return Response::json($response);	
			}
			
				
			
		
			
			$varfolderPath =  public_path().'/public/folders';
			if (!File::isDirectory($varfolderPath)){

					$response['status'] = 'error';					
					return Response::json($response);
			}	
				
			$revpath=$this->folderModel->getFolderStructure($folders->parent_id );	
			
			$varfolderPath.= '/'.$revpath[0]; 
			$dir=$varfolderPath. $folders->id .'/'.$files->id . '.' . $files->ext; 
			if (file_exists($dir)) {
				$logid = checkLocations::getUserlog('download','file',$files->id );
				header('Content-Description: File Transfer');
				header('Content-Type: '. $files->mime);
				header('Content-Disposition: attachment; filename='.$files->alias);
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
				$response['status'] = 'error';					
					return Response::json($response);
			}
			
		}else{
			
			$response['status'] = 'error';					
					return Response::json($response);
		}
	}
	
	// @pankaj Controller function for upload multiple files	
	public function uploadFile() {
		
		$response = array();
		$path = '';
		$new_name = '';
		$params=Input::all();
		$folderPar=base64_decode(Input::get('folder')); 
		
		if (Input::has('qquuid') && $folderPar) {
				
			$folders=$this->folderModel->checkValidFolder($folderPar );
			if(!$folders){
					$response['status'] = 'error';
					$response['message'] = 'Folder not found!';
					return Response::json($response);
			}
			$projectID 		= $folders->project_id;
			$project=$this->folderModel->checkValidProject($folders->project_id,$this->user);
			if(!$project){
						echo  json_encode(array('status'=>'error','message'=>'Unauthorished access for this folder!!')); exit;
			}
			$flag=false;
			$roilearr=$this->folderModel->getRoles($project,$this->user);		
			$roleObj=$roilearr[0];
			if($roleObj=='admin' || $roleObj=='upload') $flag=true;
			
				
			if($flag){
				$fileobj = Input::file('qqfile');
				
				
				if($fileobj->getError()==1 || $fileobj->getError()==2){
					$response['success'] = false;
					$response['message'] = 'Server error. There is limit for max file size 2 GB!';
					return Response::json($response);
				}else if($fileobj->getError()>2){
					$response['success'] = false;
					$response['message'] = 'This file has some error!';
					return Response::json($response);
				}
				
				if($fileobj->getSize() >1048576*1024*2){
					
					$response['success'] = false;
					$response['error'] = 9;
					$response['message'] = 'You can upload file upto 2 GB!';
					return Response::json($response);
				}
				
				$mime_type =$fileobj->getMimeType();
				$ext = $fileobj->getClientOriginalExtension();
				$orgName = $fileobj->getClientOriginalName();
				$size=$fileobj->getSize();
				$mime=$fileobj->getMimeType();
				$new_name =  str_replace("'",'', str_replace('"','', str_replace('-','_', str_replace(' ','', $fileobj->getClientOriginalName()))));
				
				
				$varfolderPath =  public_path().'/public/folders/';
				if (!File::isDirectory($varfolderPath)){
					$response['success'] = false;
					$response['message'] = 'Server error. Folder directory not found!';
					return Response::json($response);
				}	
					$revpath=$this->folderModel->getFolderStructure($folders->parent_id );					
					$varfolderPath.= '/'.$revpath[0]. $folders->id .'/'; 
					DB::beginTransaction();	
					try{
						
						$duplicate=Files::where('folder_id',$folders->id)->where('file_name',$new_name)->first();
						if($duplicate && count($duplicate)>0){
							$response['success'] = false;
							$response['error'] = '9';
							$response['message'] = 'Duplicate File. File already exist!';
							return Response::json($response);
						}
					
					
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
						if($objProjectFolder->save()){
							
							
							if($path = $fileobj->move($varfolderPath,$objProjectFolder->id.'.'.$ext)){
								
								$logid = checkLocations::getUserlog('upload','file',$objProjectFolder->id);
								$response['success'] = true;
								$response['message'] = 'File - ' .  $orgName . '  has been uploaded successfully';
								DB::commit();
								return Response::json($response);
							}else{
								$response['success'] = false;
								$response['message'] = 'Something gone wrong . Please try again';
								DB::rollback();
								return Response::json($response);							
							}
							
						}else{
								$response['success'] = false;
								$response['message'] = 'Something gone wrong . Please try again';
								DB::commit();
								return Response::json($response);
							
						}
					}catch(Exception $e)	{
						
							$response['success'] = false;
							$response['message'] = 'Something gone wrong . Please try again';
							DB::rollback();
							return Response::json($response);
					}
			
			}else{
				
					$response['success'] = false;
					$response['message'] = 'You have not access to upload file.';
				
			}
	
	   }else{
					$response['success'] = false;
					$response['message'] = 'Unauthorized Access';
	   }

		return Response::json($response);
	}
	
	// @pankaj Controller function for share multiple files	
	public function shareFile(){
		$fid=base64_decode(Input::get('shared'));
		$files=$this->folderModel->checkValidFiles($fid );
		if(!$files)	{
				$response['status'] = 'error';
				$response['message'] = 'Files not found!';
				return Response::json($response);
		}
		
		$folders=$this->folderModel->checkValidFolder($files->folder_id );
		if(!$folders){
				$response['status'] = 'error';
				$response['message'] = 'File not found!';
				return Response::json($response);
		}
		
		$projectID 		= $folders->project_id;
		$project=$this->folderModel->checkValidProject($folders->project_id,$this->user);
		if(!$project){
					echo  json_encode(array('status'=>'error','message'=>'Unauthorished access for this file!!')); exit;
		} 
		
		$roilearr=$this->folderModel->getRoles($project,$this->user);
		$currentrole=$roilearr[0];
		if($currentrole=='view' || $currentrole==''){
						echo  json_encode(array('status'=>'error','message'=>'Unauthorished access for this file!!')); exit;
		}
		
		try{
			$logid = checkLocations::getUserlog('share','file',$files->id);
			$url = URL::to('/folder/shared').'?users='. md5($files->id);
			$users=Input::get('usersval');
			if($users && count($users)>0){
					foreach($users as $usr){
						if(!$usr) continue;
						$userInfo = User::where('id',$usr)->first();
						$abemail = $userInfo->email;	
						$data = array(
							'url' => $url,
							'user_email' => $abemail, 
						);
						$email_data = array(
							'email_message' => Lang::get('invite', $data),
							'email_action_url' => $url,
							'email_action_text' => 'A file is shared on dataroom. Click to access File'
						);
						
						Mail::send('emails.share', $email_data, function($messag)use($data) { 
							$messag->to($data['user_email'], 'Name')->subject('A files shared on dataroom');
						});
					
						
						
					}
				
			}
			$response['success'] = true;
			$response['message'] = 'Shared link was sent on email of selected users';	
			return Response::json($response);
		
		}catch(Exception $e){
			$response['success'] = false;
			$response['message'] = 'Something gone wrong . Please try again';
			return Response::json($response);
		}
	}

}
