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
		
		if($varGetDataRoomId > 0 && $varGetDataRoomId!=''){
			return View::make('project/view-project')->with(array('UserRole' => $this->user->usertype, 'did'=>$varGetDataRoomId,'encyid' => $varGetDataRoomEncId));
		}
		else{
			return View::make('project/view-project')->with(array('UserRole' => $this->user->usertype,'did'=>'','encyid' =>''));
		}
	}
	
    public function ProjectCreate() {
		
			$varGetDataRoomId = base64_decode(Input::get('d'));
			$varGetDataRoomEncId = Input::get('d');
			
			if(($varGetDataRoomId > 0 &&  $varGetDataRoomId!='') && $this->user->usertype=="admin"){
				return View::make('project.add-project')->with(array('UserRole' => $this->user->usertype, 'did'=>$varGetDataRoomId));
			}
			else if($varGetDataRoomId=='' && 	$this->user->usertype=="admin"){
				$arrDataRooms = Dataroom::getAllDataRoom($this->user->id, 'admin');
				return View::make('project.add-project')->with(array('UserRole' => $this->user->usertype, 'did'=>$varGetDataRoomId,'arrDr'=>$arrDataRooms));
				
			}
			else{
					Toastr::error('Unauthorished access to create project(s)!');
					return Redirect::to('/project/view?d='.$varGetDataRoomEncId);
			}
        
    }
		
		public function saveProjects() {
		$arrInviteExternalUserEmail = array();	
		$arrInviteInternalUserEmail = array();
	  if(sizeof(Input::get('userEmail'))>0) {
			$i = 0;
			$arrInviteExternalUserEmail = array();	
			$arrInviteInternalUserEmail = array();
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
				
		$varDataRoomId = addslashes(Input::get('dataRoomId'));
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
								$ObjProject->save();
								$varLastInsertId = $ObjProject->id;
							
								
								$objUserProjectroom = new UserProject;
								$objUserProjectroom->user_id = $this->user->id;
								$objUserProjectroom->project_id = $varLastInsertId;
								$objUserProjectroom->dataroom_id = $varDataRoomId;
								$objUserProjectroom->role = 'admin';
								$objUserProjectroom->created_at = date('Y-m-d H:i:s');
								$objUserProjectroom->updated_at = date('Y-m-d H:i:s');
								$objUserProjectroom->save();
																	
								if(sizeof($arrInviteInternalUserEmail)>0) {	
									ProjectController::inviteInernalUserProjectroom($varLastInsertId,$varDataRoomId,$arrInviteInternalUserEmail);							
								}
								
								$internel_user = Input::get('internel_user');
								if($internel_user==0) {
									if(sizeof($arrInviteExternalUserEmail)>0) {
										//ProjectController::inviteExternalUserProjectroom($varLastInsertId,$varDataRoomId,$arrInviteExternalUserEmail);
									}
								}
								
								Toastr::success('Project room Succesfully Added!!');
								return Redirect::to('/project/view?d='.base64_encode($varDataRoomId));
							}
							else{
								Toastr::error('That Project Room is already in used !!');
								return Redirect::to('/project/view?d='.base64_encode($varDataRoomId));
							}
					}
					else{
						Toastr::error('Projectroom cat not be blank !!');
					return Redirect::to('/project/view?d='.base64_encode($varDataRoomId));
					}
				
			}
			else{
					Toastr::error('Projectroom wrong access !!');
					return Redirect::to('/project/view?d='.base64_encode($varDataRoomId));
			}
		}
		else {
					Toastr::error('Projectroom wrong access !!');
					return Redirect::to('/project/view?d='.base64_encode($varDataRoomId));
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
				$url = URL::to('/project/view');
				$data = array(
				'url' => $url,
				'user_email' => $email, 
				);
				$email_data = array(
				'email_message' => Lang::get('invite', $data),
				'email_action_url' => $url,
				'email_action_text' => "Join now.",
				);

				Mail::send('emails.inviteproject', $email_data, function($messag)use($data) { 
				$messag->to($data['user_email'], 'Name')->subject('invited you to join the Project !');
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
									$messag->to($data['user_email'], 'Name')->subject('invited you to join the Project Room !');
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
		
		$project_data = Project::getProjectInfoByProjectId($projectId);
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
				if($params["addtableid"]){
					foreach($params["addtableid"] as $k=> $oneObj){
						$del = UserProject::where('id', $oneObj)->where('project_id', base64_decode($params["proid"]))->delete();
					}					
				}
				if(count($arrInviteInternalUserEmail)>0){
						ProjectController::inviteInernalUserProjectroom(base64_decode($params["proid"]),$params["dataroom_id"],$arrInviteInternalUserEmail);
				}						
				$varProjectAction = 'update';
				$varProjecName = $params["name"];
				$varProjecId = base64_decode($params["proid"]);
				$varUpdated = date('Y-m-d h:i:s');
					if($varProjectAction == 'update'){
						if($varProjecName != null || $varProjecName != ''){
								 $update = Project::where('id', $varProjecId)->update(array('name' => $params["name"],'company' => $params["company"],'description' => $params["description"],'domain_restrict' => $params["domain_restrict"],'internal_user' => $params["internel_user"],'view_only' => $params["view_only"], 'updated_at' =>$varUpdated));
									echo json_encode(array('error'=>3,'msg'=>"Project room has successfully updated")); exit();
						}
						else{
							echo json_encode(array('error'=>1,'msg'=>"Please enter Project room or Project room description")); exit();
						}
					}
					else{
						echo json_encode(array('error'=>1,'msg'=>"Project room not found to edit")); exit();
					}
				
				}
	
	
	
	public function DeleteProject(){
		$params = Input::all();
		$varProjectRoomId = base64_decode($params['p']);
		$varDataRoomId = base64_decode($params['dataRoomen']);
		if($varProjectRoomId && $varDataRoomId){
					$UserProjects = UserProject::where('dataroom_id', $varDataRoomId)->where('project_id', $varProjectRoomId)->delete(); 
					$delete = Project::where('id', $varProjectRoomId)->delete();
					echo json_encode(array('error'=>3,'msg'=>"Project room has successfully deleted")); exit();
		}
		else {
					echo json_encode(array('error'=>1,'msg'=>"Project room not found to edit")); exit();
			}
	}
	
	  public function getprojectlist(){
		  $varDataRoomId = base64_decode(Input::get('d'));
	  	$arrReturn = array();
	  
		if($this->user->usertype=="admin"){
			$projectDetails = Project::getProjectForSupoerADmin($varDataRoomId);
		}
		else {
			$projectDetails = Project::getProjectForUser($this->user->id,$varDataRoomId);
		}
		
	   
		foreach($projectDetails AS $key=>$val){
		
			$arrReturn[$key]['id'] = $val->projid;
			$arrReturn[$key]['encyptid'] = base64_encode($val->projid);
			$arrReturn[$key]['name'] = ucfirst($val->name);
			$arrReturn[$key]['user_id'] = $val->user_id;
			$arrReturn[$key]['dataroom_id'] = $val->dataroom_id;			
			$arrReturn[$key]['updated_at'] =  date('m/d/Y | H:i A',strtotime($val->updated_at));
			$arrReturn[$key]['dataroom_name'] = ucfirst(Dataroom::getDataRoomName($val->dataroom_id));
			$arrUserInfo = User::getUserInfo($val->user_id);
			$arrReturn[$key]['user_name'] = User::getUserFulName($val->user_id);
			$arrReturn[$key]['role'] = ucfirst($val->role);
			$arrReturn[$key]['status'] = ($val->projstatus)?'Active':'Inactive';
			$arrReturn[$key]['statusval'] = $val->projstatus;
			$arrReturn[$key]['currentuserType'] = $this->user->usertype;
			$arrReturn[$key]['user_count'] = UserProject::getUsercount($val->projid);
			
		}
		//echo'<pre>';
	  		//print_r($arrReturn);
			
			//die;
	  
		return Response::json(array('data'=>$arrReturn));
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
				Toastr::error('you are not authrise for this project.');
				return Redirect::to('/project/view');	
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
										Toastr::success('Project Succesfully Added!!');
										return Redirect::to('/project/view');
									}
									else{
										Toastr::error('Project is already shared with this user!!');
										return Redirect::to('/project/view');
									}
							}
							else{
								Toastr::error('No role selected for project. Please select user role!!');
								return Redirect::to('/project/view');
							}
						}
						else{
								Toastr::error('No user selected for project. Please select user first!!');
							return Redirect::to('/project/view');
						}
					}
					else{
					
					//echo "dddhhddddd";die;
							Toastr::error('No Project Selected. Please select first project!!');
							return Redirect::to('/project/view');
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
			Toastr::error('Please first select any project!!');	
			return Redirect::to('/project/view');
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
										'email_action_text' => 'Click for signup', 
								);
								Mail::send('project.invite-mail', $email_data, function($message) use($user) {
									$message->to(Input::get('userEmail'), 'Name')->subject('Invite for Project');
								});
								
								Toastr::success('An email containing user name and Password has been sent to you');
								return Redirect::to('/project/view');
							}
							else {
								Toastr::error('User email is already in use!!');	
								return Redirect::to('/project/view');
							}
						}
						else {
							Toastr::error('Please enter user email!!');	
							return Redirect::to('/project/view');	
						}
					}
					else{
						Toastr::error('Please enter first name and lastname!!');	
						return Redirect::to('/project/view');	
					}
				}
				else {
					Toastr::error('Please select data room role for user!!');	
					return Redirect::to('/project/view');	
				}
			}
			else {
				Toastr::error('Unbauthorished access!!');	
				return Redirect::to('/project/view');	
			}
			
		}
		else {
			Toastr::error('Unbauthorished access!!');	
			return Redirect::to('/project/view');
		}
	}
	public function RemoveUserfromProjectRoom(){
		$varDataRoomId = Input::get('varDataRoomId');
		$varProjectRoomId = Input::get('varProjectRoomId');
		$varUserId = Input::get('varUserId');
		if($varUserId && $varProjectRoomId && $varDataRoomId){
					UserProject::where('project_id', $varProjectRoomId)->where('user_id', $varUserId)->where('dataroom_id', $varDataRoomId)->delete();
					Toastr::success('User Removed successfully !!');	
					return Redirect::to('/project/view');
		}
		else {
					Toastr::error('There is some problem to remove this user!!');	
					return Redirect::to('/project/view');
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
            $response['result'] = 'No photo uploaded.';
        }
        //print_r($response);
		//die;
		return Response::json($response);
    }	
	
	public function getEditProjectView(){
		$proj=Input::get('p');
		return View::make('project/edit-project')->with(array('UserRole' => $this->user->usertype,'proId'=>$proj));
	}
	
}