<?php
class ProjectController extends BaseController {
	
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
	 
	//Editor:@Pradeep
	//UpdatedAt:09/03/2016	
	public function getProjects() {
			$varGetDataRoomId = base64_decode(Input::get('d'));
		$varGetDataRoomEncId = Input::get('d');
		
		// check User is valid to access this data room
			if($this->user->usertype=="admin"){
				$arrDataRoom = Dataroom::getDataRoomForSupoerADmin();
			}
			else {
				$checkUserForDataRoom = UserDataroom::where('data_room_id', $varGetDataRoomId)->where('user_id',$this->user->id)->first();
				if($checkUserForDataRoom == null && $this->user->usertype != "admin"){
					return View::make('dataroom/error');
				}
				$arrDataRoom = Dataroom::getDataRoomByUserId($this->user->id);
			}
		
		
		if(!$varGetDataRoomId) { 
		
			if(sizeof($arrDataRoom)>0) { 
               	 foreach($arrDataRoom as $dkey => $dr) { 
				 	if(trim($dr->name)) {						
						if(!$varGetDataRoomId) { 							
								$varGetDataRoomId = $dr->roomid;
								$varGetDataRoomEncId = base64_decode($dr->roomid);		
								break;
						}
					}
				 }
			}
		} 
				
		if($varGetDataRoomId > 0 && $varGetDataRoomId!=''){
			return View::make('project/view-project')->with(array('arrDataRoom' => $arrDataRoom,'UserRole' => $this->user->usertype, 'did'=>$varGetDataRoomId,'encyid' => $varGetDataRoomEncId));
		}
		else{
			return View::make('project/view-project')->with(array('arrDataRoom' => $arrDataRoom,'UserRole' => $this->user->usertype,'did'=>'','encyid' =>''));
		}
	}
	
    public function ProjectCreate() {
		
			$varGetDataRoomId = base64_decode(Input::get('d'));
			$varGetDataRoomEncId = Input::get('d');
			//check log//
			checkLocations::getUserlog('pre add','project');
			
			if(($varGetDataRoomId > 0 &&  $varGetDataRoomId!='') && $this->user->usertype=="admin"){
				return View::make('project.add-project')->with(array('UserRole' => $this->user->usertype, 'did'=>$varGetDataRoomId))->with('currentUser',$this->user->email);
			}
			else if($varGetDataRoomId=='' && 	$this->user->usertype=="admin"){
				$arrDataRooms = Dataroom::getAllDataRoom($this->user->id, 'admin');
				return View::make('project.add-project')->with(array('UserRole' => $this->user->usertype, 'did'=>$varGetDataRoomId,'arrDr'=>$arrDataRooms))->with('currentUser',$this->user->email);

			}
			else{
					Toastr::error(Lang::get('messages.msg_unauthorished_access_for_create_project'));
					return Redirect::to('/project/view?d='.$varGetDataRoomEncId);
			}
        
    }
		

		public function saveProjects() {  
			$arrInviteExternalUserEmail = array();	
			$arrInviteInternalUserEmail = array();
			if(sizeof(Input::get('userEmail'))>0) {
				$i = 0;
			
				foreach (Input::get('userEmail') as $key => $val) {
					$UserType		= Input::get("source.$key");						
					if($UserType=="internal") {								
						$arrInviteInternalUserEmail[$key]['email'] = Input::get("userEmail.$key");
						$arrInviteInternalUserEmail[$key]['id'] = Input::get("userId.$key");
						$arrInviteInternalUserEmail[$key]['role'] = Input::get("userRole.$key");							

					
					} else { 							
						$arrInviteExternalUserEmail[$key]['email'] = Input::get("userEmail.$key");
						$arrInviteExternalUserEmail[$key]['role'] = Input::get("userRole.$key");
					}	
				}					
			}	
				
			$varDataRoomRedirectId = Input::get('dataRoomRedirectId');
			if($varDataRoomRedirectId > 0)
				$varDataRoomRedirectId = base64_encode($varDataRoomRedirectId);
			else
				$varDataRoomRedirectId = '';
				
			
			
			$varDataRoomId = trim(Input::get('dataRoomId'));
			if($varDataRoomId > 0 && $varDataRoomId!=''){
				$varSubmitForm = addslashes(Input::get('addProjectRoom'));
				if($varSubmitForm == 'add'){	
					$varAddProjectRoom = addslashes(Input::get('projectRoom'));
					if($varAddProjectRoom != null || $varAddProjectRoom != ''){
						$company = Input::get('company');
						$domain_restrict = Input::get('domain_restrict');
						$internel_user = Input::get('internel_user');
						$view_only = Input::get('view_only');
						$description = Input::get('description');
						$dataimg =Input::get('userprofile_picture');
					
					
						$varAddDataRoomStatus = '1';
						$checkProjectRoom = Project::where('name', $varAddProjectRoom)->where('data_room_id',$varDataRoomId)->first();	
						if($checkProjectRoom == null){
							DB::beginTransaction();
							try{
								$ObjProject = new Project;
								$ObjProject->data_room_id = $varDataRoomId;
								$ObjProject->name = $varAddProjectRoom;
								$ObjProject->company = $company;
								$ObjProject->photo = $dataimg;
								$ObjProject->description = $description;
								$ObjProject->domain_restrict = $domain_restrict;
								$ObjProject->internal_user = $internel_user;
								$ObjProject->view_only = $view_only;
								$ObjProject->created_by = $this->user->id;
								$ObjProject->status = $varAddDataRoomStatus;
								$ObjProject->created_at = date('Y-m-d H:i:s');
								$ObjProject->updated_at = date('Y-m-d H:i:s');
								if($ObjProject->save()){
										$varLastInsertId = $ObjProject->id;
										$objUserProjectroom = new UserProject;
										$objUserProjectroom->user_id = $this->user->id;
										$objUserProjectroom->project_id = $varLastInsertId;
										$objUserProjectroom->dataroom_id = $varDataRoomId;
										$objUserProjectroom->role = 'admin';
										$objUserProjectroom->created_at = date('Y-m-d H:i:s');
										$objUserProjectroom->updated_at = date('Y-m-d H:i:s');
										//save user log// 	
	                                    checkLocations::getUserlog('post add','project',$varLastInsertId);
										if($objUserProjectroom->save()){																				
											if(sizeof($arrInviteInternalUserEmail)>0) {	
												ProjectController::inviteInernalUserProjectroom($varLastInsertId,$varDataRoomId,$arrInviteInternalUserEmail);							
											}
											
											$internel_user = Input::get('internel_user');
											if($internel_user==0) {
												if(sizeof($arrInviteExternalUserEmail)>0) {
													//ProjectController::inviteExternalUserProjectroom($varLastInsertId,$varDataRoomId,$arrInviteExternalUserEmail);
												}
											}
											//creating folders
											$varfolderPath =  public_path().'/public/folders/';
											if($varLastInsertId){
												
												$objProjectFolder = new ProjectFolder;
												$objProjectFolder->folder_name = $varAddProjectRoom;
												$objProjectFolder->alias = $varAddProjectRoom;
												$objProjectFolder->parent_id = '0';
												$objProjectFolder->created_at = date('Y-m-d H:i:s');
												$objProjectFolder->updated_at = date('Y-m-d H:i:s');
												$objProjectFolder->created_by = $this->user->id;
												$objProjectFolder->project_id = $varLastInsertId;
												if($objProjectFolder->save()){
													$old = umask(0);
													mkdir($varfolderPath .$objProjectFolder->id, 0775);
													umask($old);
												}else{
													
													 DB::rollback();
													 echo  json_encode(array('flag'=>1,'error'=>Lang::get('messages.something_gone_wrong_msg'))); exit;
												}	
												
											}	
											DB::commit();
											echo json_encode(array('flag'=>'success','msg'=>Lang::get('messages.msg_project_successfully'),'did'=>base64_encode($varDataRoomId)));
										}else{
											DB::rollback();
										echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.something_gone_wrong_msg'),'did'=>base64_encode($varDataRoomId)));							
										}
								}else{
										DB::rollback();
										echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.something_gone_wrong_msg'),'did'=>base64_encode($varDataRoomId)));
								}
							
							}catch(Exception $e){
										DB::rollback();
										echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.something_gone_wrong_msg'),'did'=>base64_encode($varDataRoomId)));
							}
						
						}
						else{ 
							echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_project_already_in_use'),'did'=>base64_encode($varDataRoomId)));
							exit;
						}
					}
					else{
						echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_plz_enter_project_name'),'did'=>base64_encode($varDataRoomId)));
						exit;
					}
				}
				else{
					echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_project_wrong_access'),'did'=>base64_encode($varDataRoomId)));
					exit;
				}
			}
			else {
				echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_project_wrong_access'),'did'=>base64_encode($varDataRoomId)));
				exit;
			}
    }
	
	public function inviteInernalUserProjectroom($varProjectRoomId,$varDataRoomId,$users){
		foreach($users AS $User){ 
			$email = $User['email'];
			$varInviteUserId = $User['id'];
			$varInviteUserRole = $User['role'];
			//$checkProjectRoom = Userexternal::where('email', $email)->first();	
			//if($checkProjectRoom == null){
				// Add Project
				$objProjectRoomRelation = new UserProject;
				$objProjectRoomRelation->user_id = $varInviteUserId;
				$objProjectRoomRelation->project_id = $varProjectRoomId;
				$objProjectRoomRelation->dataroom_id = $varDataRoomId;
				$objProjectRoomRelation->role = $varInviteUserRole;
				$objProjectRoomRelation->save();
				$checkIE = User::where('id',$varInviteUserId)->first();
				if($checkIE){
					if($checkIE->source == "external"){
						$varToken=$checkIE->activation_code;
						$url = URL::to('/sign-up').'?token='.$varToken.'&p='.base64_encode($varDataRoomId).'&u='.base64_encode($varInviteUserId);
					}
					else{
						$url = URL::to('/dataroom/view-dataroom');
					}
				}
				$data = array(
				'url' => $url,
				'user_email' => $email, 
				);
				$email_data = array(
				'email_message' => Lang::get('invite', $data),
				'email_action_url' => $url,
				'email_action_text' => Lang::get('messages.msg_invite_projectroom'),
				);

				Mail::send('emails.inviteproject', $email_data, function($messag)use($data) { 
				$messag->to($data['user_email'], 'Name')->subject(Lang::get('messages.msg_invite_to_join_project'));
				});	
			//}
		} 
	}
	
	public function inviteExternalUserProjectroom($varProjectRoomId,$varDataRoomId,$varInviteUserEmail){
			if(count($varInviteUserEmail) > 0){
				if($varProjectRoomId > 0 && $varProjectRoomId!=''){
					foreach($varInviteUserEmail AS $email){				 
						$checkDataRoom = Userexternal::where('email', $email)->first();	
							if($checkDataRoom == null){
								$varToken = Dataroom::generateRandomString(); 
								$user = new Userexternal;
								$user->email = $email['email'];
								$user->password = '';
								$user->permissions = NULL;
								$user->activated = '0';
								$user->activation_code = $varToken;
								$user->activated_at = NULL;
								$user->source = 'external';
								$user->reset_password_code =  NULL;
								$user->first_name =  NULL;
								$user->last_name =  NULL;
								$user->login_time =  1;
								$user->usertype =  $email['role'];
								$user->created_at = date('Y-m-d');
								$user->updated_at = date('Y-m-d');
								$user->save();
								$varLastInsertId = $user->id;
													
								$objProjectRoomRelation = new UserProject;
								$objProjectRoomRelation->user_id = $varLastInsertId;
								$objProjectRoomRelation->project_id = $varProjectRoomId;
								$objProjectRoomRelation->dataroom_id = $varDataRoomId;
								$objProjectRoomRelation->role = $email['role'];
								$objProjectRoomRelation->save();
								
								$url = URL::to('/sign-up').'?token='.$varToken.'&p='.base64_encode($varDataRoomId).'&u='.base64_encode($varLastInsertId);
													
									
								$data = array(
									'url' => $url,
									'user_email' => $email, 
								);
								$email_data = array(
									'email_message' => Lang::get('invite', $data),
									'email_action_url' => $url,
									'email_action_text' => Lang::get('Join')
									);
								
								Mail::send('emails.inviteproject', $email_data, function($messag)use($data) { 
									$messag->to($data['user_email'], 'Name')->subject(Lang::get('messages.msg_invite_to_join_project'));
								});
							}
					}
				}
			}
		}
	
	public function EditProjectView() {
		$projarr=Input::get('p');
		$encodeproj='0';
		if($projarr){
			$encodeproj=base64_decode($projarr); 
		}
		$projectId = $encodeproj;
		$user_id = $this->user->id;
		
		$project_data =  Project::getProjectInfoByProjectId($projectId,$user_id);
		return Response::json(array('data'=>$project_data));      
    }
	
	public function saveupdateProject(){
		$params=Input::all();
		$convrtarr = array();
		$arrInviteInternalUserEmail = array();	
		if(sizeof($params["usersList"])>0) {
			foreach ($params["usersList"] as $key => $val) {
				$UserType		= "internal";						
				if($UserType=="internal") {								
					$arrInviteInternalUserEmail[$key]['email'] = $val["addemail"];
					$arrInviteInternalUserEmail[$key]['id'] = $val["addemailid"];
					$arrInviteInternalUserEmail[$key]['role'] = $val["addrole"];
				}
			}
		}
		DB::beginTransaction();
		try {
			/* save user log */ 
			$projectIDforLog =  base64_decode($params["proid"]);	
			$dIDforLog =  $params["dataroom_id"];				
			$logid = checkLocations::getUserlog('post update','project',$projectIDforLog);				
			ProjectController::SaveProjectLog($logid,$dIDforLog,$projectIDforLog);	
			$previousUser = UserProject::where('project_id',$projectIDforLog)->get();
		
			if($params["addtableid"]){
				foreach($params["addtableid"] as $k=> $oneObj){
					$del = UserProject::where('id', $oneObj)->where('project_id', $projectIDforLog )->delete();
				}					
			}
			if(count($arrInviteInternalUserEmail)>0){
				ProjectController::inviteInernalUserProjectroom($projectIDforLog ,$dIDforLog,$arrInviteInternalUserEmail);
			}
		
			$varProjecName = trim($params["name"]);		
			if($varProjecName != null || $varProjecName != ''){
				$Projectupdate 		   	    = Project::where('id', $projectIDforLog)->first(); 			
				$Projectupdate->name     	   = $varProjecName;
				$Projectupdate->company  	  	= $params["company"];	
				$Projectupdate->domain_restrict  = $params["domain_restrict"];
				$Projectupdate->description      = $params["description"];
				$Projectupdate->internal_user    = $params["internel_user"];
				$Projectupdate->view_only        = $params["view_only"];
				$Projectupdate->updated_at       = date('Y-m-d H:i:s');								
				$Projectupdate->save();
				
				$ProjectFolderupdate = ProjectFolder::where('project_id', $projectIDforLog)->where('parent_id', 0)->first(); 			
				$ProjectFolderupdate->folder_name= $varProjecName;
				$ProjectFolderupdate->alias  	 = $varProjecName;									
				$ProjectFolderupdate->updated_at = date('Y-m-d H:i:s');								
				$ProjectFolderupdate->save();
				 
				ProjectController::SaveLogUserAsocaitedwithProject($logid ,$dIDforLog,$projectIDforLog,$previousUser);
				DB::commit();				
				 echo json_encode(array('error'=>'3','msg'=>Lang::get('messages.msg_project_update_successfully'),'dataroomId'=>base64_encode($params["dataroom_id"]))); exit();			 
			}
			else{					
				echo json_encode(array('error'=>'2','msg'=>Lang::get('messages.msg_plz_enter_project_name'))); exit();
			}
		} catch (\Exception $e) {
			DB::rollback();
			echo  json_encode(array('error'=>1,'error'=>Lang::get('messages.something_gone_wrong_msg'))); exit;	
		}	
		//echo json_encode(array('error'=>'1','msg'=>Lang::get('messages.msg_try_again'))); exit();	
	}
	
	
	
	public function DeleteProject(){
		$params = Input::all();
		$varProjectRoomId = base64_decode($params['p']);
		$varDataRoomId = base64_decode($params['dataRoomen']);
		
		//save user log// 	
		$logid = checkLocations::getUserlog('delete','project',$varProjectRoomId);	
		ProjectController::SaveProjectLog($logid,$varDataRoomId,$varProjectRoomId);	
		$previousUser = UserProject::where('project_id',$varProjectRoomId)->get();
		ProjectController::SaveLogUserAsocaitedwithProject($logid,$varDataRoomId,$varProjectRoomId,$previousUser,true);
		
		if($varProjectRoomId && $varDataRoomId){
				DB::beginTransaction();
				try{
					$dtCont= new DataroomController();
					$folders= ProjectFolder::where('project_id', $varProjectRoomId)->where('parent_id', 0)->first();
					$return=$dtCont->removeFolder($folders->id);		
									
					
					$UserProjects = UserProject::where('dataroom_id', $varDataRoomId)->where('project_id', $varProjectRoomId)->delete(); 
					$delete = Project::where('id', $varProjectRoomId)->delete();					
					DB::commit();
					try{
						$fldrCont= new FolderController();
						$fldrCont->removeDirectory($return . $folders->id);
					}catch(Exception $e){}
					echo json_encode(array('error'=>3,'msg'=>Lang::get('messages.msg_project_deleted_successfully'))); exit();
				}catch(Exception $e)	{
					DB::rollback();
					echo json_encode(array('error'=>1,'msg'=>Lang::get('messages.msg_try_again'))); exit();
			}	
		}
		else {
					echo json_encode(array('error'=>1,'msg'=>Lang::get('messages.msg_not_found_for_edit'))); exit();
			}
	}
	
	  public function getprojectlist(){
		  $overrideVal= '';
		  $page = (Input::has('page')) ? Input::get('page') : 1;
		  $varDataRoomId = base64_decode(Input::get('d'));
	  	$arrReturn = array();
	  
		if($this->user->usertype=="admin"){
			$projectDetails = Project::getProjectForSupoerADmin($varDataRoomId, $page);
			$overRide = Dataroom::select('internal_user','domain_restrict','view_only')->where('id',$varDataRoomId)->first();
			if(strlen($overRide->domain_restrict)>0 || $overRide->internal_user>0|| $overRide->view_only>0 ){
				$overrideVal = 'active';
			}
		}
		else {
			$projectDetails = Project::getProjectForUser($this->user->id,$varDataRoomId, $page);
			$overRide = Dataroom::select('internal_user','domain_restrict','view_only')->where('id',$varDataRoomId)->first();
			if(strlen($overRide->domain_restrict)>0 || $overRide->internal_user>0|| $overRide->view_only>0 ){
				$overrideVal = 'active';
			}
		}
		
	   
		foreach($projectDetails AS $key=>$val){
			if(strlen($val->domain_restrict)>0 || $val->internal_user>0|| $val->view_only>0 ){
				$overrideVal = 'active';
			}
			$arrReturn[$key]['id'] = $val->projid;
			$arrReturn[$key]['encyptid'] = base64_encode($val->projid);
			$arrReturn[$key]['name'] = ucfirst($val->name);
			$arrReturn[$key]['user_id'] = $val->user_id;
			$arrReturn[$key]['dataroom_id'] = $val->dataroom_id;
            $arrReturn[$key]['dataroomid'] = base64_encode($val->dataroom_id);			
			$arrReturn[$key]['updated_at'] =  date('m/d/Y | H:i A',strtotime($val->updated_at));
			$arrReturn[$key]['dataroom_name'] = ucfirst(Dataroom::getDataRoomName($val->dataroom_id));
			$arrUserInfo = User::getUserInfo($val->user_id);
			$arrReturn[$key]['user_name'] = User::getUserFulName($val->user_id);
			$arrReturn[$key]['role'] = ucfirst($val->role);
			$arrReturn[$key]['status'] = ($val->projstatus)?'Active':'Inactive';
			$arrReturn[$key]['statusval'] = $val->projstatus;
			$arrReturn[$key]['currentuserType'] = $this->user->usertype;
			$arrReturn[$key]['user_count'] = UserProject::getUsercount($val->projid);
			$arrReturn[$key]['over_ride'] = $overrideVal;
			$overrideVal = '';
		}
		//echo'<pre>';
	  		//print_r($arrReturn);
			
			//die;
	  
		return Response::json(array('data'=>$arrReturn, 'resultcount'=>count($arrReturn)));
	}
	
	
	public function shareTo(){
				$arrUserProject = array();
				$varProjectId = addslashes(Input::get('varProjectId'));
				$varDataRoomId = addslashes(Input::get('varDataRoomId'));
				$arrRoomInfo = Project::find($varProjectId)->first()->toArray();				
				$role = UserProject::getRoleProjectUser($varDataRoomId,$varProjectId,$this->user->id);
				if($role=='admin' || $this->user->usertype == "admin") {
				$arrRooms = UserProject::getProjectForUser($varProjectId);
				if(count($arrRooms) > 0){
					foreach($arrRooms as $k=>$v){
						$arrUserProject[$k]['id'] =$v['id']; 
						$arrUserProject[$k]['user_id'] = $v['user_id'];
						$arrUserProject[$k]['project_id'] = $v['project_id'];
						$arrUserProject[$k]['varDataRoomId'] = $varDataRoomId;
						$arrUserProject[$k]['user_name'] = User::getUserFulName($v['user_id']);
						$arrUserProject[$k]['role'] =$v['role']; 
					}
				}
			
				$arrProject = array('projectroom'=>$arrUserProject, 'roomname'=>$arrRoomInfo['name']);	
				
				return View::make('project.share-to')->with('data', $arrProject);
				} else {
				Toastr::error(Lang::get('messages.msg_not_authorished_for_view_project'));
				return Redirect::to('/dataroom/view-dataroom');	
		}
			}
			
	
	public function shareWith(){
				$arr = array();	
				$varProjectId = addslashes(Input::get('varProjectId'));
				$varProjectName = addslashes(Input::get('varProjectName'));
				$varProjectdataroomid = addslashes(Input::get('varProjectdataroomid'));
				
				
				$users = DB::table('users')
								->join('profiles', 'profiles.user_id', '=', 'users.id')
								->select('profiles.user_id as userid', 'profiles.firstname','profiles.lastname')
								->where('users.id', '<>', $this->user->id)
								->where('users.activated', 1)
								->get();
				
				$arr = array('users'=>$users, 'roomID'=>$varProjectId, 'roomName'=>$varProjectName,'varProjectdataroomid'=>$varProjectdataroomid);	
				return View::make('project.share-with')->with('data', $arr);
			}
			
			public function saveshare(){
				// echo "<pre>";print_r($_POST);
				$varProjectId = Input::get('addproject');
				$varProjectUser = addslashes(Input::get('dataRoomUser'));
				$varProjectRole = addslashes(Input::get('dataRoomRole'));
				$varProjectdataroomid=addslashes(Input::get('varProjectdataroomid'));
				
				if($varProjectId > 0){
					DB::beginTransaction();
					try {					
						if($varProjectUser !=null || $varProjectUser != ''){
							if($varProjectRole !=null || $varProjectRole != ''){
								$checkProject = UserProject::where('user_id', $varProjectUser)->where('project_id',$varProjectId )->first();
								//print_r($checkProject);
								//die;
								if(count($checkProject) == 0){
									$userDataroom = new UserProject;
									$userDataroom->user_id = $varProjectUser;
									$userDataroom->project_id = $varProjectId;
									$userDataroom->dataroom_id = $varProjectdataroomid;
									$userDataroom->role = $varProjectRole;
									$userDataroom->created_at = date('Y-m-d');
									$userDataroom->updated_at = date('Y-m-d');
									$userDataroom->save();
									DB::commit();
									Toastr::success(Lang::get('messages.msg_project_added_successfully'));
									return Redirect::to('/dataroom/view-dataroom');
								}
								else{
									DB::rollback();
									Toastr::error(Lang::get('messages.msg_proejct_shared_sucessfully'));
									return Redirect::to('/dataroom/view-dataroom');
								}
							}
							else{
								DB::rollback();
								Toastr::error(Lang::get('messages.msg_role_not_selected_for_project'));
								return Redirect::to('/dataroom/view-dataroom');
							}
						}
						else{
							Toastr::error(Lang::get('messages.msg_no_user_for_project_plz_select'));
							return Redirect::to('/dataroom/view-dataroom');
						}
					} 
					catch (\Exception $e) {
						DB::rollback();
						Toastr::error(Lang::get('messages.something_gone_wrong_msg'));						
						return Redirect::to('/dataroom/view-dataroom');
					}	
				}
				else{
					Toastr::error(Lang::get('messages.msg_no_project_selected_plz_select_first'));
					return Redirect::to('/dataroom/view-dataroom');
				}
			}
			
			public function inviteUserforProject(){
			
			    $arrUserProject = array();
				$varProjectId = Input::get('varProjectId');
				$varProjectName = Input::get('varProjectName');
				$varProjectdataid = Input::get('varProjectdataroomid');
			
		if($varProjectId && $varProjectId > 0){
			$arr = array('varProjectId'=>$varProjectId,'varProjectName'=>$varProjectName,'varProjectdataid'=>$varProjectdataid);	
			return View::make('project.invite')->with('data', $arr);
		}
		else {
			Toastr::error(Lang::get('messages.msg_plz_select_project'));	
			return Redirect::to('/dataroom/view-dataroom');
		}
		
			}
			
		
			public function inviteUserSave(){
			
			
			
			    //$arrUserProject = array();
		$varProjectdataid = Input::get('varProjectDataRoomId');				
		$addProject = Input::get('addProject');
		$varProjectName = Input::get('varProjectName');
		$varProjectID = Input::get('addProjectID');
		$varUserFirstName = Input::get('userFirstName');
		$varUserLastName = Input::get('userLastName');
		$varUserEmail = Input::get('userEmail');
		$varDataRoomRole = Input::get('dataRoomRole');
				
			if($addProject == 'add'){
				DB::beginTransaction();
				try {
					if($varProjectID > 0){ 
						if($varDataRoomRole){
							if($varUserFirstName !='' && $varUserLastName !=''){ 
								if($varUserEmail!=''){
									$checkUser = User::where('email', $varUserEmail)->first();
									if(count($checkUser) == 0){
										$varAutoGeneratePassword = '$2y$10$mdeoZIHDrT3jAZg4vpGzs.0Q/haLBX3cdbDJ3lDUQcC3JAg4rJ4Ja';//Pass@123
										$user = new Userexternal;
										$user->email = $varUserEmail;
										$user->password = $varAutoGeneratePassword;
										$user->permissions = NULL;
										$user->activated = '0';
										$user->activated_at = NULL;
										$user->source = 'external';
										$user->reset_password_code =  NULL;
										$user->first_name =  NULL;
										$user->last_name =  NULL;
										$user->login_time =  1;
										$user->usertype =  'user';
										$user->created_at = date('Y-m-d');
										$user->updated_at = date('Y-m-d');
										$user->save();
										$varLastInsertId = $user->id;
										
										// Save user information  for profile table
										$userProfile = new Profile;
										$userProfile->user_id = $varLastInsertId;
										$userProfile->firstname = $varUserFirstName;
										$userProfile->lastname = $varUserLastName;
										$userProfile->photo = '';
										$userProfile->location = '';
										$userProfile->timezone = 'America/Edmonton';
										$userProfile->job_title = '';
										$userProfile->organisation = '';
										$userProfile->created_at = date('Y-m-d H:i:s');
										$userProfile->updated_at = date('Y-m-d H:i:s');
										$userProfile->save();
										
										// Save data room information for user.
										
										$userProject = new UserProject;
										$userProject->user_id = $varLastInsertId;
										$userProject->project_id = $varProjectID;
										$userProject->dataroom_id = $varProjectdataid;
										$userProject->role = $varDataRoomRole;
										$userProject->created_at = date('Y-m-d H:i:s');
										$userProject->updated_at = date('Y-m-d H:i:s');
										$userProject->save();
																		
										$decodeUser = base64_encode($varLastInsertId);
										$DataRoomId = base64_encode($varProjectdataid);
										
										$url = URL::to('http://dataroom.socialsofttest.com/auth/project-invite'. '/'.$decodeUser);
										$data = array('url' => $url);
										$email_data = array(
												'username' => $varUserEmail,
												'userpassword' => $varAutoGeneratePassword,
												'email_action_url' => $url,
												'email_action_text' => Lang::get('messages.label_click_sign_up'), 
										);
										Mail::send('project.invite-mail', $email_data, function($message) use($user) {
											$message->to(Input::get('userEmail'), 'Name')->subject(Lang::get('messages.msg_invite_for_project'));
										});
										DB::commit();
										Toastr::success(Lang::get('messages.msg_email_password_email_sent'));
										return Redirect::to('/dataroom/view-dataroom');
									}
									else {
										Toastr::error(Lang::get('messages.msg_email_already_in_used'));		
										return Redirect::to('/dataroom/view-dataroom');
									}
								}
								else {
									Toastr::error(Lang::get('messages.msg_plz_enter_user_email'));
									return Redirect::to('/dataroom/view-dataroom');	
								}
							}
							else{
								Toastr::error(Lang::get('messages.msg_for_first_last_name'));	
								return Redirect::to('/dataroom/view-dataroom');	
							}
						}
						else {
							Toastr::error(Lang::get('messages.msg_select_dataroom_for_user'));
							return Redirect::to('/dataroom/view-dataroom');	
						}
					}
					else {
						DB::rollback();
						Toastr::error(Lang::get('messages.msg_unauthorished_access'));
						return Redirect::to('/dataroom/view-dataroom');	
					}
				} 
				catch (\Exception $e) {
					DB::rollback();
					Toastr::error(Lang::get('messages.something_gone_wrong_msg'));						
					return Redirect::to('/dataroom/view-dataroom');
				}	
			}
			else {
				Toastr::error(Lang::get('messages.msg_unauthorished_access'));
				return Redirect::to('/dataroom/view-dataroom');
			}
	}
	public function RemoveUserfromProjectRoom(){
		$varDataRoomId = Input::get('varDataRoomId');
		$varProjectRoomId = Input::get('varProjectRoomId');
		$varUserId = Input::get('varUserId');
		if($varUserId && $varProjectRoomId && $varDataRoomId){
			DB::beginTransaction();
			try {
				UserProject::where('project_id', $varProjectRoomId)->where('user_id', $varUserId)->where('dataroom_id', $varDataRoomId)->delete();
				Toastr::success(Lang::get('messages.msg_removed_user_successfully'));	
				return Redirect::to('/dataroom/view-dataroom');
			} catch (\Exception $e) {
				DB::rollback();
				Toastr::error(Lang::get('messages.something_gone_wrong_msg'));	
				return Redirect::to('/dataroom/view-dataroom');
			}	
		}
		else {
			Toastr::error(Lang::get('messages.msg_remove_user_problem'));	
			return Redirect::to('/dataroom/view-dataroom');
		}
	}
	
		public function getUserEmails()
	{
		return $user_details= User::where('email', 'LIKE', '%' . Input::get('term') . '%')
					->lists('email');
					
	}
	
	 public function postProjectPhoto() {
        $response = array();
        $path = '';
        $new_name = '';
        if (Input::hasFile('profile_pic')) { 
            $ext = Input::file('profile_pic')->getClientOriginalExtension();
            $new_name = uniqid() . '_' . time() . '.' . $ext;
            Image::make(Input::file('profile_pic')->getRealPath())->resize(140, 140)->save((('./public/uploads/' . $new_name)));
        } 
        if ($new_name != '') {
            $response['status'] = 'success';			
            $response['result'] = array('image_name' => $new_name,'image_url' => URL::asset('public/uploads/'.$new_name));
        } else {
            $response['status'] = 'error';
            $response['result'] = Lang::get('messages.msg_no_photo_upload');
        }
        //print_r($response);
		//die;
		return Response::json($response);
    }	
	
	public function getEditProjectView(){
		$proj=Input::get('p');
		$datas = Project::select('data_room_id')->where('id', base64_decode($proj))->first();
		$did = $datas->data_room_id;
		
		return View::make('project/edit-project')
		->with(array('UserRole' => $this->user->usertype,'proId'=>$proj))
		->with('currentUser',$this->user->email)
		->with('did',$did);

	}
	function CopyProject() { 
		$did		          =	Input::get('did');
		$pid		          =	Input::get('pid');
		$dName			   =	Input::get('dName');	
		$CopyWithfiles		=	(Input::get('CopyWithfiles'))?true:false;
		$encodededdid = base64_encode($did);		
		if($pid && $did && $dName) {
		   $Dataroom 	= Dataroom::find($did);
		   $Project 	= Project::find($pid);
			 $NameCheck    = Project::where('name',$dName)->where('data_room_id',$did)->get();

		
		  if(sizeof($Dataroom)>0 && sizeof($Project)>0) {
			  if(sizeof($NameCheck)<=0) {
				  DB::beginTransaction();
					try{
				   /*copy project from old data room to new one */
						$Projects = Project::where('id', $pid)->get();
						foreach($Projects as $key => $Project) {
							$ObjProject = new Project(); 
							$ObjProject->data_room_id = $did;
							$ObjProject->name = $dName;
							$ObjProject->company = $Project->company;
							$ObjProject->photo = $Project->photo;
							$ObjProject->description = $Project->description;
							$ObjProject->domain_restrict = $Project->domain_restrict;
							$ObjProject->internal_user = $Project->internal_user;
							$ObjProject->view_only = $Project->view_only;
							$ObjProject->created_by = $this->user->id;
							$ObjProject->status = $Project->status;
							$ObjProject->created_at = date('Y-m-d H:i:s');
							$ObjProject->updated_at = date('Y-m-d H:i:s');
							$ObjProject->save();
							$LastestProjectId  = $ObjProject->id;
							
							//save user log// 	
							 checkLocations::getUserlog('copy','project',$LastestProjectId);
							/*copy user from old project to new one */
							$UserProjects = UserProject::where('dataroom_id', $did)->where('project_id', $Project->id)->get();
							 
							foreach($UserProjects as $UserProject) {
								$NewUserProject = new UserProject(); 								
								$NewUserProject->dataroom_id    = $did;
								$NewUserProject->project_id      = $LastestProjectId;
								$NewUserProject->role 		  = $UserProject->role;
								$NewUserProject->user_id 	    = $UserProject->user_id;					
								$NewUserProject->created_at 	 = date('Y-m-d H:i:s');
								$NewUserProject->updated_at 	 = date('Y-m-d H:i:s');
								$NewUserProject->save();
							}
							/*copy folders from old project to new one */
							$path = base_path().'/public/folders'; 
							DataroomController::CreateFolders($path,$Project->id,$LastestProjectId,0,0,$CopyWithfiles,$dName);																	
						}
						DB::commit();
						echo json_encode(array('flag'=>'success','msg'=>Lang::get('messages.project_copied_successfully'),'den'=>$encodededdid));
					} 
					catch (\Exception $e) {
						DB::rollback();
						echo  json_encode(array('flag'=>'error','error'=>Lang::get('messages.something_gone_wrong_msg'),'den'=>$encodededdid));	
					}	
		   	} 
				else { 
					echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_same_name_already_exist'),'den'=>$encodededdid));
				}
			} 
			else { 
		   	echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_something_gone_wrong'),'den'=>$encodededdid));				
			}
		} 
		else {
			echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_something_gone_wrong'),'den'=>$encodededdid));
	  }
	  exit;
	}
	 
	  public function SaveProjectLog($logid,$did,$pid) {		  
		$old = Project::where('id',$pid)->first();		
		if($old) {

			$ProjectLog 		   		= new ProjectLog(); 
			$ProjectLog->logid      	   = $logid;
			$ProjectLog->data_room_id      = $did;
			$ProjectLog->project_id      = $old->id;
			$ProjectLog->name  	         = $old->name;											
			$ProjectLog->company           = $old->company;			
			$ProjectLog->photo  	        = $old->photo;
			$ProjectLog->description       = $old->description;									
			$ProjectLog->internal_user     = $old->internal_user;
			$ProjectLog->domain_restrict   = $old->domain_restrict;
			$ProjectLog->view_only         = $old->view_only;
			$ProjectLog->status            = $old->status;														
			$ProjectLog->created_at 	   = $old->created_at;
			$ProjectLog->updated_at        = $old->updated_at;
			$ProjectLog->save();
		}

	}
	
	function SaveLogUserAsocaitedwithProject($logid,$did,$pid,$previousUser,$flag = false) {
	  	
		if(!$flag) {
			$PreUsr = array();
			$PreUsrDetails = array();
			
			foreach($previousUser as $usr) {
				$PreUsr[] = $usr->user_id;
				$PreUsrDetails[$usr->user_id]['role'] = $usr->role;
			}
			
			$NewUserDatarooms = UserProject::where('project_id',$pid)->get();
			
			$NewUsr = array();
			
			foreach($NewUserDatarooms as $usr) {
				$NewUsr[] = $usr->user_id;			
			}
							
			/* code to added and role updtaed Users from dataroom */	
			foreach($NewUserDatarooms as $key => $NewUserDataroom) {
				
				
				if(!in_array($NewUserDataroom->user_id,$PreUsr)) {
					$UserProjectLog 		   	    = new UserProjectLog(); 			
					$UserProjectLog->logid     	  = $logid;
					$UserProjectLog->data_room_id  	= $did;
					$UserProjectLog->project_id  	= $pid;
					$UserProjectLog->user_id          = $NewUserDataroom->user_id;																								
					$UserProjectLog->created_at       = date('Y-m-d H:i:s');
					$UserProjectLog->updated_at       = date('Y-m-d H:i:s');	
					$UserProjectLog->action           = 'Added';
					$UserProjectLog->role             = $NewUserDataroom->role;
					$UserProjectLog->save();
				} else if(in_array($NewUserDataroom->user_id,$PreUsr)) { 
						if($NewUserDataroom->role!=$PreUsrDetails[$NewUserDataroom->user_id]['role']) { 
							$UserProjectLog 		   	    = new UserProjectLog(); 			
							$UserProjectLog->logid     	  = $logid;
							$UserProjectLog->data_room_id  	= $did;
							$UserProjectLog->project_id  	= $pid;
							$UserProjectLog->user_id          = $NewUserDataroom->user_id;																								
							$UserProjectLog->created_at       = date('Y-m-d H:i:s');
							$UserProjectLog->updated_at       = date('Y-m-d H:i:s');	
							$UserProjectLog->action           = 'Role Updated';
							$UserProjectLog->role             = $PreUsrDetails[$NewUserDataroom->user_id]['role'];
							$UserProjectLog->save();
						}
				}
			}
			
			/* code code to Deleted Users from dataroom */
			
			$DeletedUsers = array_diff($PreUsr, $NewUsr);
			
			foreach($DeletedUsers as $key => $Deleted) {
				$UserProjectLog 		   	    = new UserProjectLog(); 
				$UserProjectLog->logid     	  = $logid;
				$UserProjectLog->data_room_id  	= $did;
				$UserProjectLog->project_id  	= $pid;
				$UserProjectLog->user_id          = $Deleted;																								
				$UserProjectLog->created_at       = date('Y-m-d H:i:s');
				$UserProjectLog->updated_at       = date('Y-m-d H:i:s');							
				$UserProjectLog->action           = 'Deleted';
				$UserProjectLog->role             = $PreUsrDetails[$Deleted]['role'];
				$UserProjectLog->save();			
				
			}
			
			/* end code to Deleted Users from dataroom */
		} else {
			/* executed code when a data room deleted */ 
			
			$allUserDatarooms = UserProject::where('dataroom_id',$did)->get();
			
			foreach($allUserDatarooms as $key => $allUserDataroom) {
					$UserProjectLog 		   	    = new UserProjectLog(); 			
					$UserProjectLog->logid     	  = $logid;
					$UserProjectLog->data_room_id  	= $did;
					$UserProjectLog->project_id  	= $pid;
					$UserProjectLog->user_id          = $allUserDataroom->user_id;																								
					$UserProjectLog->created_at       = date('Y-m-d H:i:s');
					$UserProjectLog->updated_at       = date('Y-m-d H:i:s');	
					$UserProjectLog->action           = 'Deleted';
					$UserProjectLog->role             = $allUserDataroom->role;
					$UserProjectLog->save();
			}
		}
		
	}
	
	public function getUsernames(){ 
		$profiles = DB::table('users')
		  //->join('profiles', 'profiles.user_id', '=', 'users.id' )
		  ->join('user_dataroom', 'users.id', '=', 'user_dataroom.user_id' )
		  ->where('user_dataroom.data_room_id','=',trim(Input::get('dataRoomId')))
		  ->where('email', 'Like', '%'.Input::get('term').'%')->where('users.id','<>' , $this->user->id )
		  ->get(array('users.id as id','email','usertype'));
		 $json =array(); 
		 if($profiles && count($profiles)>0) {
			 $json['incomplete_results']= false; 
			 $json['total_count']= count($profiles);
			 $i=0;
			 foreach($profiles as $prof){
				$json['items'][$i]['email']= $prof->email;
				$json['items'][$i]['usertype']= $prof->usertype;
				$json['items'][$i]['id']= $prof->id;
				$json['items'][$i]['firstname']= User::getUserFirstName($prof->id);
				$json['items'][$i++]['photo']= ( $prof->photo)? URL::to('/') . '/public/uploads/'.  $prof->photo : URL::to('/') . '/assets/images/small-profile-icon.png';
			 }
		 }
		 echo json_encode($json); die;
					
	}	
}
