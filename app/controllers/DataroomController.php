<?php

class DataroomController extends BaseController {

    public $user = null;
	public $pathFiles;
	public $userid;

    public function __construct() {
        $this->beforeFilter('auth');
        parent::__construct(); 
        if (Sentry::check()) {
            $this->user = Sentry::getUser();
        }
		$this->pathFiles 		    = public_path().'/dataroomfiles/';	
		$old = umask(0);
	File::makeDirectory($this->pathFiles, 0755, true, true);
	umask($old);
    
    }

    public function getGeneralSetting() {
        $timezone_details = Profile::getUserTimeZonelist();
        return View::make('setting/user-setting')->with(array('user' => $this->user,'timezone_details'=>$timezone_details));
    }

    public function postUpdateUserProfile() {
      
        Toastr::success(Lang::get('success.profile', ['name' => $profile->firstname]), $title = null, $options = []);
        return Redirect::to('general-settings');
    }

	
	public function removeFolder($varFolderID){
				$folder= ProjectFolder::where('id', $varFolderID)->first();
				$varfolderPath =  public_path().'/public/folders';
				$fldrCont= new FolderController();
				$fldrCont->getPath($folder->parent_id );	
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
				$fldrCont->deletedID=array();
				$fldrCont->deleteRecursive($varFolderID);
				$fldrCont->deletedID[]=$folder->id;				
				
				if($fldrCont->deletedID && count($fldrCont->deletedID)>0){
						ProjectFolder::whereIn('id', $fldrCont->deletedID)->delete();
						Files::whereIn('folder_id', $fldrCont->deletedID)->delete();						
						return $varfolderPath;
						
				}
				return false;
				
	}
	
	public function deleteDataroom(){
		$varId = trim(addslashes(Input::get('DataRoomId')));
		$DataRoomUserId = trim(addslashes(Input::get('DataRoomUserId')));
	  //save user log// 	
		$logid = checkLocations::getUserlog('delete','dataroom',$varId);	
		DataroomController::SaveDataRoomLog($logid,$varId);	
		$previousUser = UserDataroom::where('data_room_id',$varId)->get();
		DataroomController::SaveLogUserAsocaitedwithDataRoom($logid,$varId,$previousUser,true);
	    
		if($this->user->usertype=="admin") {
			if($varId > 0){
				DB::beginTransaction();
				try { 
					
					$projects=Project::where('data_room_id', $varId)->get();
					if($projects && count($projects)>0){
						
						foreach($projects as $pro){
									$folders= ProjectFolder::where('project_id', $pro->id)->where('parent_id', 0)->first();
									$return=$this->removeFolder($folders->id);		
									//echo $return . $folders->id;
									try{
										$fldrCont= new FolderController();
									$fldrCont->removeDirectory($return . $folders->id);
									}catch(Exception $e){
										
									}
							
						}
					}
					
					
					$UserProjects = UserProject::where('dataroom_id', $varId)->delete();
					$deleteproject = Project::where('data_room_id', $varId)->delete(); 
					
					$Dataroomdelete = UserDataroom::where('data_room_id', $varId)->delete();
					$deletedata = Dataroom::where('id', $varId)->delete();
					
					DB::commit();
					Toastr::success(Lang::get('messages.dataroom_del_msg'));	
					return Redirect::to('/dataroom/view-dataroom');
				} catch (\Exception $e) {
					DB::rollback();
					Toastr::error(Lang::get('messages.msg_problem_to_delete'));	
					return Redirect::to('/dataroom/view-dataroom');
				}
			}
			else {
				Toastr::error(Lang::get('messages.msg_problem_to_delete'));	
				return Redirect::to('/dataroom/view-dataroom');
			}
		}
		else {
			return Redirect::to('/error');
		}
	}
				
	public function updateDataroom(){
	  if($this->user->usertype=="admin") {
			$roomId = trim(addslashes(Input::get('varDataRoomId')));
			$varDataRoomUserId =trim(addslashes(Input::get('varDataRoomUserId')));
			//save user log// 	
			checkLocations::getUserlog('pre update','dataroom',$roomId);
			  
			 $user_id = $this->user->id;
			 $DataRoominfo 	= Dataroom::where('id', $roomId)->first();
			  
			$varDataRoomRole = Input::get('varDataRoomRole');
			$varDataRoomName = $DataRoominfo['name'];
			$varDataRoomcomp = $DataRoominfo['company'];
			$varDataRoomdisc = $DataRoominfo['description'];
			$varDataRoomdomain = $DataRoominfo['domain_restrict'];
			$internel_user =$DataRoominfo['internal_user'];
			$view_only =$DataRoominfo['view_only'];
			
			//$inviteDataRoom = UserDataroom::where('user_id', $varDataRoomUserId)->where('data_room_id',$roomId)->first();
			
			
			$dataInfo = array();
		$dataAddUser = array();
			 $dataroomData= DB::table('data_room')->join('user_dataroom', 'data_room.id', '=', 'user_dataroom.data_room_id')
				->join('users', 'user_dataroom.user_id', '=', 'users.id')
				->leftjoin('profiles','users.id','=','profiles.user_id')
				->select('data_room.id as roomid', 'user_dataroom.role as addedUserRole','user_dataroom.user_id as addedUser','user_dataroom.id as addedUserId','users.email as addedUserEmail','user_dataroom.data_room_id','profiles.photo')
				->where('data_room.id', $roomId)
				->where('user_dataroom.user_id','<>', $this->user->id)
				->whereRaw('data_room.created_by <> user_dataroom.user_id')
				->groupBy('users.id')
				->get();
				
			if($dataroomData){
			$varbaseUrl = URL::to('/');
			foreach($dataroomData as $key=>$data){
				$varGetPhoto = '';
				$varPath = '';
				$varGetPhoto = ($data->photo!='')?$varbaseUrl.'/public/uploads/'.$data->photo:$varbaseUrl.'/assets/images/icon-profile.png';
				$dataAddUser[] = array(
					'addemail' => $data->addedUserEmail,
					'addrole' => $data->addedUserRole,
					'addtableid' => $data->addedUserId,
					'addemailid' => $data->addedUser,
					'userphoto'=>$varGetPhoto,
					'id'=>$data->addedUser,
				);
			}
			
		}
			
			$photo = $DataRoominfo['photo'];
			$data = array('id'=>$roomId,'name'=>$varDataRoomName,'user_id'=>$user_id, 'role'=>$varDataRoomRole,'company'=>$varDataRoomcomp,'description'=>$varDataRoomdisc,'domain_restrict'=>$varDataRoomdomain,'photo'=>$photo,'internel_user'=>$internel_user,'view_only'=>$view_only,'varDataRoomUserId'=>$varDataRoomUserId, 'addedUsersInfo'=>$dataAddUser);	
			return View::make('dataroom.update-dataroom')->with('data', $data)->with('currentUser',$this->user->email);;
			
		}
		else
		{
		
		return Redirect::to('/error');
		}	
	}
				
				
	public function saveupdateDataroom(){
	
	$arrInviteExternalUserEmail = array();
	$arrInviteInternalUserEmail = array();	
	$arrInviteInternaladminUserEmail = array();	
	$arrInviteInternaluserUserEmail = array();
	$varDataRoomId = Input::get('dataRoomId');
	
	//save user log// 	
	$logid = checkLocations::getUserlog('post update','dataroom',$varDataRoomId);	
	DataroomController::SaveDataRoomLog($logid,$varDataRoomId);	
	$previousUser = UserDataroom::where('data_room_id',$varDataRoomId)->get();
	
	
	  if(sizeof(Input::get('userEmail'))>0) {
		  $i = 0;			
			foreach (Input::get('userEmail') as $key => $val) {
				$UserType		= Input::get("source.$key");						
				if($UserType=="admin" || $UserType=="user" || $UserType=="internaluser" || $UserType=="view" ) {
					if("old"==Input::get("newold.$key")){
						$arrInviteInternaladminUserEmail[$key]['email'] = Input::get("userEmail.$key");
						$arrInviteInternaladminUserEmail[$key]['id'] = Input::get("userId.$key");
						$arrInviteInternaladminUserEmail[$key]['role'] = Input::get("userRole.$key");
					}else{
						$arrInviteInternalUserEmail[$key]['email'] = Input::get("userEmail.$key");
						$arrInviteInternalUserEmail[$key]['id'] = Input::get("userId.$key");
						$arrInviteInternalUserEmail[$key]['role'] = Input::get("userRole.$key");
					}
				}				
				elseif($UserType=="external") {						
					$arrInviteExternalUserEmail[$key]['email'] = Input::get("userEmail.$key");
					$arrInviteExternalUserEmail[$key]['role'] = Input::get("userRole.$key");
				}
				
			}	
		}
		
		$varDataRoomAction = Input::get('Action');
		$varDataRoomName = Input::get('dataRoom');		
		$varDataRoomcompany = Input::get('company');
		$varDataRoomdescription = Input::get('description');
		$varUpdated = date('Y-m-d h:i:s');
		$dataimg =Input::get('userprofile_picture');
		$varDataRoomAdminId =Input::get('varDataRoomAdminId');
		
		$domain_restrict = Input::get('domain_restrict');
		$internal_user =Input::get('internel_user');
		$view_only =Input::get('view_only');
		if($this->user->usertype=="admin" && $varDataRoomAction == 'update') {		
				if($varDataRoomName != null || $varDataRoomName != ''){
					DB::beginTransaction();
					try{
					$update = Dataroom::where('id', $varDataRoomId)->update(array('name' => $varDataRoomName, 'company' => $varDataRoomcompany, 'description' => $varDataRoomdescription, 'updated_at' =>$varUpdated, 'photo'=>$dataimg,'domain_restrict'=>$domain_restrict,'internal_user'=>$internal_user,'view_only'=>$view_only));
						if(sizeof(Input::get('userOldId'))>0) {
							foreach (Input::get('userOldId') as $key => $val) {									
								UserDataroom::where('id', $val)->delete();
							}
							
						}							
						
						if(sizeof($arrInviteInternaladminUserEmail)>0){
							foreach($arrInviteInternaladminUserEmail AS $User){
								
								$checkUser = UserDataroom::where('user_id',$User['id'])->where('data_room_id',$varDataRoomId)->first();									
								if(sizeof($checkUser)<=0){
									$email = $User['email'];
									$varInviteUserId = $User['id'];
									$varInviteUserRole = $User['role'];
									$dataRoomRelation = new UserDataroom;
									$dataRoomRelation->user_id = $varInviteUserId;
									/*if($varInviteUserId == $varDataRoomAdminId){
									$varInviteUserRole = 'admin';
									 }*/
									$dataRoomRelation->data_room_id = $varDataRoomId;
									$dataRoomRelation->role =$User['role'];
									$dataRoomRelation->save();
								}	
							}
						}
						if(sizeof($arrInviteInternaluserUserEmail)>0){
							foreach($arrInviteInternaluserUserEmail AS $User){
								$checkUser = UserDataroom::where('user_id',$User['id'])->where('data_room_id',$varDataRoomId)->first();
								if(sizeof($checkUser)<=0){
									$email = $User['email'];
									$varInviteUserId = $User['id'];
									$varInviteUserRole = $User['role'];
									$dataRoomRelation = new UserDataroom;
									$dataRoomRelation->user_id = $varInviteUserId;
									if($varInviteUserId == $varDataRoomAdminId){
									$varInviteUserRole = 'admin';
									 }
									$dataRoomRelation->data_room_id = $varDataRoomId;
									$dataRoomRelation->role = $User['role'];
									$dataRoomRelation->save();
								}	
							}
						}
						
						
						
						if(sizeof($arrInviteInternalUserEmail)>0) {
														
							DataroomController::inviteInernalUserDataroom($varDataRoomId,$arrInviteInternalUserEmail,1);					
						}
						
						$internel_user = Input::get('internel_user');
						
						//if($internel_user==0) {
							if(sizeof($arrInviteExternalUserEmail)>0) {
								DataroomController::inviteExternalUserDataroom($varDataRoomId,$arrInviteExternalUserEmail);
							}
						//}
						
						DataroomController::SaveLogUserAsocaitedwithDataRoom($logid ,$varDataRoomId,$previousUser);
						DB::commit();
						Toastr::success(Lang::get('messages.dataroom_update_msg'));
						return Redirect::to('/dataroom/view-dataroom?den='.base64_encode($varDataRoomId));
					} catch (\Exception $e) {
						DB::rollback();
						Toastr::error(Lang::get('messages.something_gone_wrong_msg'));
						return Redirect::to('/dataroom/view-dataroom?den='.base64_encode($varDataRoomId));
					}
				}
				else{
					Toastr::error(Lang::get('messages.msg_dataroom_catnot_blank'));
					return Redirect::to('/dataroom/view-dataroom?den='.base64_encode($varDataRoomId));
				}
			}
			else{
				Toastr::error(Lang::get('messages.msg_dataroom_wrong_access'));
				return Redirect::to('/dataroom/view-dataroom?den='.base64_encode($varDataRoomId));
			}
		
		
	
	}
				
	public function addDataroom(){
		if($this->user->usertype=="admin") { 
		  
			//save user log// 	
			checkLocations::getUserlog('pre add','dataroom');
			return View::make('dataroom.add-dataroom')->with('currentUser',$this->user->email);
		} else {
		Toastr::error(Lang::get('messages.msg_you_are_not_authorished'));
		return Redirect::to('dataroom/view-dataroom');
		}
	}
						
	public function saveDataroom(){	
		//print_r(Input::all()); die;
		$arrInviteExternalUserEmail = array();
		$arrInviteInternalUserEmail = array();	
	  if(sizeof(Input::get('userEmail'))>0) {
		  $i = 0;			
			foreach (Input::get('userEmail') as $key => $val) {
				$UserType		= Input::get("source.$key");						
				if($UserType=="admin" || $UserType=="user" || $UserType=="internaluser") {								
					$arrInviteInternalUserEmail[$key]['email'] = Input::get("userEmail.$key");
					$arrInviteInternalUserEmail[$key]['id'] = Input::get("userId.$key");
					$arrInviteInternalUserEmail[$key]['role'] = Input::get("userRole.$key");
					/*if(Input::get("userRole.$key")!="user")
						$arrInviteInternalUserEmail[$key]['role'] = (!Input::get("userRole.$key")) ? 'view' : Input::get("userRole.$key");
					else 
						$arrInviteInternalUserEmail[$key]['role'] ='view';*/
				} 
				else { 							
					$arrInviteExternalUserEmail[$key]['email'] = Input::get("userEmail.$key");
					$arrInviteExternalUserEmail[$key]['role'] = Input::get("userRole.$key");
				}
				
			}					
		}
		
		
		$varSubmitForm = addslashes(Input::get('addDataRoom'));
			if($varSubmitForm == 'add'){
				$varAddDataRoom = addslashes(Input::get('dataRoom'));
				if($varAddDataRoom != null || $varAddDataRoom != ''){
					$company = Input::get('company');
					$domain_restrict = Input::get('domain_restrict');
					$internel_user = Input::get('internel_user');
					$view_only = Input::get('view_only');
					$description = Input::get('description');
					$dataimg =Input::get('userprofile_picture');
					$varAddDataRoomStatus = '1';
					$checkDataRoom = Dataroom::where('name', $varAddDataRoom)->first();	
					if($checkDataRoom == null){
						DB::beginTransaction();
						try {
							//date_default_timezone_set("Asia/Kolkata");
							$Dataroom = new Dataroom;
							$Dataroom->name = $varAddDataRoom;
							$Dataroom->company = $company;
							$Dataroom->photo = $dataimg;
							$Dataroom->description = $description;
							$Dataroom->domain_restrict = $domain_restrict;
							$Dataroom->internal_user = $internel_user;
							$Dataroom->view_only = $view_only;
							$Dataroom->created_by = $this->user->id;
							$Dataroom->status = $varAddDataRoomStatus;
							$Dataroom->created_at = date('Y-m-d H:i:s');
							$Dataroom->updated_at = date('Y-m-d H:i:s');
							$Dataroom->save();
							$varLastInsertId = $Dataroom->id;
								//save user log// 	
							checkLocations::getUserlog('post add','dataroom',$varLastInsertId);
						   
							/*$domainDataroom = new DomainDataroom;
							$domainDataroom->domain = $domain_restrict;
							$domainDataroom->dataroom_id = $varLastInsertId;
							$domainDataroom->created_at = date('Y-m-d');
							$domainDataroom->updated_at = date('Y-m-d');
							$domainDataroom->save();
							$vardomainInsertId = $Dataroom->id;*/
								
							$userDataroom = new UserDataroom;
							$userDataroom->user_id = $this->user->id;
							$userDataroom->data_room_id = $varLastInsertId;
							$userDataroom->role = 'admin';
							$userDataroom->created_at = date('Y-m-d H:i:s');
							$userDataroom->updated_at = date('Y-m-d H:i:s');
							$userDataroom->save();
							if(sizeof($arrInviteInternalUserEmail)>0) {
								DataroomController::inviteInernalUserDataroom($varLastInsertId,$arrInviteInternalUserEmail);			
							}
							
							$internel_user = Input::get('internel_user');
							//if($internel_user==0) {
								if(sizeof($arrInviteExternalUserEmail)>0) {
									DataroomController::inviteExternalUserDataroom($varLastInsertId,$arrInviteExternalUserEmail);
								}
							//}
							DB::commit();
							echo json_encode(array('flag'=>'success','msg'=>Lang::get('messages.msg_dataroom_added_successfully')));
							exit;
						} catch (\Exception $e) {
							DB::rollback();
							echo  json_encode(array('flag'=>'error','msg'=>Lang::get('messages.something_gone_wrong_msg'))); exit;	
						}	
					}
					else{
						echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_dataroom_in_used')));
						exit;
					}
				}
				else{
					echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_for_dataroom')));
					exit;
				}
			}
			else{
				echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_dataroom_wrong_access')));
				exit;
			}
	}
				
				
    public function getDRView() {
	    return View::make('dataroom/list-view')->with('UserRole', $this->user->usertype);
    }
		
		public function inviteExternalUserDataroom($varDataRoomId,$varInviteUserEmail){
			if(count($varInviteUserEmail) > 0){
				if($varDataRoomId > 0 && $varDataRoomId!=''){
					foreach($varInviteUserEmail AS $email){
						$checkDataRoom = Userexternal::where('email', $email['email'])->first();	
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
								
							// Add Relation
							$dataRoomRelation = new UserDataroom;
							$dataRoomRelation->user_id = $varLastInsertId;
							$dataRoomRelation->data_room_id = $varDataRoomId;
							$dataRoomRelation->role = $email['role'];
							$dataRoomRelation->save();
						
							$url = URL::to('/sign-up').'?token='.$varToken.'&p='.base64_encode($varDataRoomId).'&u='.base64_encode($varLastInsertId);
											
							$abemail = $email['email'];	
							$data = array(
								'url' => $url,
								'user_email' => $abemail, 
							);
							$email_data = array(
								'email_message' => Lang::get('invite', $data),
								'email_action_url' => $url,
								'email_action_text' => Lang::get('messages.msg_invite_dataroom')
							);
							
							Mail::send('emails.invite', $email_data, function($messag)use($data) { 
								$messag->to($data['user_email'], 'Name')->subject(Lang::get('messages.msg_invite_for_dataroom'));
							});
						}
					}
				}
			}
		}

		
	public function getroomlist(){
		$overrideVal='gray';
	 	$page = (Input::has('page')) ? Input::get('page') : 1;
		$arrReturn = array();
		if($this->user->usertype=="admin")
		$arrDataRoom = Dataroom::getDataRoomForSupoerADmin($page);	
		else 
		$arrDataRoom = Dataroom::getDataRoomByUserId($this->user->id, $page);
				
		
		foreach($arrDataRoom AS $key => $val){
			if(strlen($val->roomdomain_restrict)>0 || $val->roominternal_user>0|| $val->roomview_only>0 ){
				$overrideVal = 'red';
			}
			$arrReturn[$key]['id'] = $val->roomid;
			$arrReturn[$key]['encyptid'] = base64_encode($val->roomid);
			$arrReturn[$key]['name'] = $val->name;
			$arrReturn[$key]['user_id'] = $val->user_id;
			$arrReturn[$key]['updated_at'] =  date('m/d/Y | H:i A',strtotime($val->updated_at));
			$arrUserInfo = User::getUserInfo($val->user_id);
			$arrReturn[$key]['user_name'] = User::getUserFulName($val->user_id);
			$arrReturn[$key]['role'] = ucfirst($val->role);
			$arrReturn[$key]['status'] = ($val->roomstatus)?'Active':'Inactive';
			$arrReturn[$key]['statusval'] = $val->roomstatus;
			$arrReturn[$key]['currentuserType'] = $this->user->usertype;
			$arrReturn[$key]['user_count'] = UserDataroom::getUsercount($val->roomid);
			$arrReturn[$key]['over_ride'] = $overrideVal;
			
			$overrideVal='gray';
			
		}
		
		//echo "<pre>";print_r($arrReturn);die;
		return Response::json(array('data'=>$arrReturn, 'resultcount'=>count($arrReturn)));
	}
				
	public function shareTo(){
		$arrUserDataRoom = array();
		$varDataRoomId = addslashes(Input::get('varDataRoomId'));
		$arrRoomInfo = Dataroom::find($varDataRoomId)->first()->toArray();
		$role = UserDataroom::getRoleDataRoomUser($varDataRoomId,$this->user->id);
	
		if($role=='admin' || $this->user->usertype == "admin") {
		$arrRooms = UserDataroom::getDataRoomForUser($varDataRoomId);
		
		if(count($arrRooms) > 0){
			foreach($arrRooms as $k=>$v){
				$arrUserDataRoom[$k]['id'] =$v['id']; 
				$arrUserDataRoom[$k]['data_room_id'] =$v['data_room_id']; 
				$arrUserDataRoom[$k]['user_id'] = $v['user_id']; 
				$arrUserDataRoom[$k]['user_name'] = User::getUserFulName($v['user_id']);
				$arrUserDataRoom[$k]['role'] =$v['role']; 
			}
		}
	
		$arrDataRoom = array('dataroom'=>$arrUserDataRoom, 'roomname'=>$arrRoomInfo['name']);	
		
		return View::make('dataroom.share-to')->with('data', $arrDataRoom);
		} else {
				Toastr::error(Lang::get('messages.msg_not_authorished_for_dataroom'));
				return Redirect::to('/dataroom/view-dataroom');	
		}
		
	}	
			
	public function shareWith(){
		$arr = array();	
		$varDataRoomId = addslashes(Input::get('varDataRoomId'));
		$varDataRoomName = addslashes(Input::get('varDataRoomName'));
		
		$users = DB::table('users')
						->join('profiles', 'profiles.user_id', '=', 'users.id')
						->select('profiles.user_id as userid', 'profiles.firstname','profiles.lastname')
						->where('users.id', '<>', $this->user->id)
						->where('users.activated', 1)
						->get();
		
		$arr = array('users'=>$users, 'roomID'=>$varDataRoomId, 'roomName'=>$varDataRoomName);	
		return View::make('dataroom.share-with')->with('data', $arr);
	}
				
	public function saveshare(){
			$varDataRoomId = addslashes(Input::get('addDataRoom'));
		     $varDataRoomUser = addslashes(Input::get('dataRoomUser'));
			$varDataRoomRole = addslashes(Input::get('dataRoomRole'));
			
			if($varDataRoomId != null || $varDataRoomId != ''){
				if($varDataRoomUser !=null || $varDataRoomUser != ''){
					if($varDataRoomRole !=null || $varDataRoomRole != ''){
							$checkDataRoom = UserDataroom::where('user_id', $varDataRoomUser)->where('data_room_id',$varDataRoomId )->first();
							if(count($checkDataRoom) == 0){
								DB::beginTransaction();
								try {
									$userDataroom = new UserDataroom;
									$userDataroom->user_id = $varDataRoomUser;
									$userDataroom->data_room_id = $varDataRoomId;
									$userDataroom->role = $varDataRoomRole;
									$userDataroom->created_at = date('Y-m-d');
									$userDataroom->updated_at = date('Y-m-d');
									$userDataroom->save();
									DB::commit();
									Toastr::success(Lang::get('messages.dataroom_add_msg'));
									return Redirect::to('/dataroom/view-dataroom');
								} catch (\Exception $e) {
									DB::rollback();
									Toastr::error(Lang::get('messages.something_gone_wrong_msg'));
									return Redirect::to('/dataroom/view-dataroom');
								}
							}
							else{
								Toastr::error(Lang::get('messages.msg_dataroom_is_already_shared_for_user'));
								return Redirect::to('/dataroom/view-dataroom');
							}
					}
					else{
						Toastr::error(Lang::get('messages.msg_no_room_selected_plz_select_role'));
						return Redirect::to('/dataroom/view-dataroom');
					}
				}
				else{
						Toastr::error(Lang::get('messages.msg_no_user_selected_plz_first_name'));
					return Redirect::to('/dataroom/view-dataroom');
				}
			}
			else{
					Toastr::error(Lang::get('messages.msg_dataroom_not_selected'));
					return Redirect::to('/dataroom/view-dataroom');
			}
				
	}	
	
	public function RemoveUserfromDataRoom(){
		$varId = Input::get('varDataRoomId');
		$varUserId = Input::get('varUserId');
		if($varId && $varUserId){
			DB::beginTransaction();
			try {
				UserDataroom::where('data_room_id', $varId)->where('user_id', $varUserId)->delete();
				DB::commit();
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
	
	
	public function inviteUserforDataRoom(){
		$varDRId = Input::get('varDataRoomId');
		$varDataRoomName = Input::get('varDataRoomName');
		if($varDRId && $varDRId > 0){
			$arr = array('varDRId'=>$varDRId,'roomName'=>$varDataRoomName);	
			return View::make('dataroom.invite-user')->with('data', $arr);
		}
		else {
			Toastr::error(Lang::get('messages.msg_plz_select_dataroom'));	
			return Redirect::to('/dataroom/view-dataroom');
		}
		
	}
	
	public function inviteUserSave(){ 
		$varAddDataRoom = Input::get('addDataRoom');
		$varAddDataRoomID = Input::get('addDataRoomID');
		$varUserFirstName = Input::get('userFirstName');
		$varUserLastName = Input::get('userLastName');
		$varUserEmail = Input::get('userEmail');
		$varDataRoomRole = Input::get('dataRoomRole');
		if($varAddDataRoom =='add'){
			if($varAddDataRoomID > 0){
				if($varDataRoomRole){
					if($varUserFirstName !='' && $varUserLastName !=''){
						if($varUserEmail!=''){
							$checkUser = User::where('email', $varUserEmail)->first();
							if(count($checkUser) == 0){
								//transaction started
								DB::beginTransaction();							
								try {
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
									
									$userDataRoom = new UserDataroom;
									$userDataRoom->user_id = $varLastInsertId;
									$userDataRoom->data_room_id = $varAddDataRoomID;
									$userDataRoom->role = $varDataRoomRole;
									$userDataRoom->created_at = date('Y-m-d H:i:s');
									$userDataRoom->updated_at = date('Y-m-d H:i:s');
									$userDataRoom->save();
									DB::commit();								
									$decodeUser = base64_encode($varLastInsertId);
									$DataRoomId = base64_encode($varAddDataRoomID);
									
									$url = URL::to('http://dataroom.socialsofttest.com/auth/user-invite'. '/'.$decodeUser);
									$data = array('url' => $url);
									$email_data = array(
											'username' => $varUserEmail,
											'userpassword' => $varAutoGeneratePassword,
											'email_action_url' => $url,
											'email_action_text' => 'Click for signup', 
									);
									Mail::send('dataroom.invite', $email_data, function($message) use($user) {
										$message->to(Input::get('userEmail'), 'Name')->subject(Lang::get('messages.msg_invite_dataroom'));
									});
									
								} catch (\Exception $e) {
								//echo $e;
									DB::rollback();
									Toastr::success(Lang::get('messages.msg_email_password_email_sent'));
									return Redirect::to('/dataroom/view-dataroom'); 
								}
									
							}
							else {
								Toastr::error(Lang::get('messages.msg_email_already_exist'));	
								return Redirect::to('/dataroom/view-dataroom');
							}
						}
						else {
							Toastr::error(Lang::get('messages.valid_email_msg'));	
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
				Toastr::error(Lang::get('messages.msg_unauthorished_access'));	
				return Redirect::to('/dataroom/view-dataroom');	
			}
			
		}
		else {
			Toastr::error(Lang::get('messages.msg_unauthorished_access'));	
			return Redirect::to('/dataroom/view-dataroom');
		}
	}
	
	public function getUsernames(){ 
	
	$profiles = DB::table('users')
		  //->join('profiles', 'profiles.user_id', '=', 'users.id' )
		  ->where('email', 'Like', '%'.Input::get('term').'%')->where('users.id','<>' , $this->user->id )
		  ->get();
		
		 
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
	
	public function UpdateUsernames()
	{ 
	
	$profiles = DB::table('users')
		  ->join('profiles', 'profiles.user_id', '=', 'users.id' )
		  ->where('email', 'Like', '%'.Input::get('term').'%')->where('users.id','<>' , $this->user->id )
		  ->get();
		
		 
		 $json =array(); 
		 if($profiles && count($profiles)>0) {
			 $json['incomplete_results']= false; 
			 $json['total_count']= count($profiles);
			 $i=0;
			 foreach($profiles as $prof){
				$json['items'][$i]['email']= $prof->email;
				$json['items'][$i]['id']= $prof->id;
				$json['items'][$i]['firstname']= $prof->firstname;
				$json['items'][$i++]['photo']= ( $prof->photo)? URL::to('/') . '/public/uploads/'.  $prof->photo : URL::to('/') . '/assets/images/small-profile-icon.png';
			 }
		 }
		 echo json_encode($json); die;
					
	}
		
 public function postPhoto() {
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
            $response['result'] = array('image_name' => $new_name,'image_url' => URL::asset('/public/uploads/'.$new_name));
        } else {
            $response['status'] = 'error';
            $response['result'] = 'No photo uploaded.';
        }
        //print_r($response);
		//die;
		return Response::json($response);
    }

	public function inviteInernalUserDataroom($varDataRoomId,$users,$edit=0){
		foreach($users AS $User){			
			$email = $User['email'];
			$varInviteUserId = $User['id'];
			$varInviteUserRole = $User['role'];
			//$checkDataRoom = Userexternal::where('email', $email)->first();	
			//if($checkDataRoom == null){
 

				// Add Relation
				$dataRoomRelation = new UserDataroom;
				$dataRoomRelation->user_id = $varInviteUserId;
				$dataRoomRelation->data_room_id = $varDataRoomId;
				$dataRoomRelation->role = $varInviteUserRole;
				$dataRoomRelation->save();
				
				/*if($edit==1){
				
					$usrrole=($varInviteUserRole=='admin')? $varInviteUserRole : 'user';
					DB::table('users')
						->where('id', $varInviteUserId)
							->update(['usertype' => $usrrole]);
				}*/
				$checkIE = User::where('id',$varInviteUserId)->first(array('activated as act','source','activation_code'));
				if($checkIE){
					if($checkIE->source == "external" && $checkIE->act == "0"){
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
				'email_action_url' => $url ,
				'email_action_text' => Lang::get('messages.msg_invite_dataroom'),
				);

				Mail::send('emails.invite', $email_data, function($messag)use($data) { 
				$messag->to($data['user_email'], 'Name')->subject(Lang::get('messages.msg_invite_for_dataroom'));
				});			
			//}
		}		 
			 
		
	}
	
	function CopyDataRoom() { 
		$did		          =	Input::get('did');
		$dName			   =	Input::get('dName');	
		$CopyWithfiles		=	(Input::get('CopyWithfiles'))?true:false;
		
		if($did && $dName) {
		  $Dataroom 	= Dataroom::where('id',$did)->first();
		  $NameCheck    = Dataroom::where('name',$dName)->get();
		  if(sizeof($Dataroom)>0) {
			  if(sizeof($NameCheck)<=0) {
				  DB::beginTransaction();
					try { 
				    /* create new data room with new name and other remaing information from old one */
						$NewDataroom 				 = new Dataroom();					
						$NewDataroom->name 			= $dName;
						$NewDataroom->company 		  = $Dataroom->company;
						$NewDataroom->photo 		    = $Dataroom->photo;
						$NewDataroom->description 	   = $Dataroom->description;
						$NewDataroom->domain_restrict    = $Dataroom->domain_restrict;
						$NewDataroom->internal_user 	 = $Dataroom->internal_user;
						$NewDataroom->view_only 		= $Dataroom->view_only;
						$NewDataroom->created_by 	    = $this->user->id;
						$NewDataroom->status 		   = $Dataroom->status;
						$NewDataroom->created_at 	    = date('Y-m-d H:i:s');
						$NewDataroom->updated_at 	    = date('Y-m-d H:i:s');
						$NewDataroom->save();
						$varLastInsertId 			  = $NewDataroom->id;
						//save user log// 	
						checkLocations::getUserlog('copy','dataroom',$varLastInsertId);
						/*copy user from old data room to new one */
						$UserDataroom = UserDataroom::where('data_room_id', $did)->get();
						 
						foreach($UserDataroom as $oldusers) {
							$NewUserDataroom = new UserDataroom(); 								
							$NewUserDataroom->data_room_id    = $varLastInsertId;
							$NewUserDataroom->role 		  = $oldusers->role;
							$NewUserDataroom->user_id 	    = $oldusers->user_id;					
							$NewUserDataroom->created_at 	 = date('Y-m-d H:i:s');
							$NewUserDataroom->updated_at 	 = date('Y-m-d H:i:s');
							$NewUserDataroom->save();
						}
						
						/*copy projects from old data room to new one */
						$Projects = Project::where('data_room_id', $did)->get();
						foreach($Projects as $key => $Project) {
							$ObjProject = new Project(); 
							$ObjProject->data_room_id = $varLastInsertId;
							$ObjProject->name = $Project->name;
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
								$NewUserProject->dataroom_id    = $varLastInsertId;
								$NewUserProject->project_id      = $LastestProjectId;
								$NewUserProject->role 		  = $UserProject->role;
								$NewUserProject->user_id 	    = $UserProject->user_id;					
								$NewUserProject->created_at 	 = date('Y-m-d H:i:s');
								$NewUserProject->updated_at 	 = date('Y-m-d H:i:s');
								$NewUserProject->save();
							}
							/*copy folders from old project to new one */
							$path = base_path().'/public/folders'; 
							DataroomController::CreateFolders($path,$Project->id,$LastestProjectId,0,0,$CopyWithfiles);
						}
						DB::commit();
						echo json_encode(array('flag'=>'success','msg'=>Lang::get('messages.dataroom_copied_successfully')));
					} catch (\Exception $e) {
						DB::rollback();											
						echo  json_encode(array('flag'=>'error','msg'=>Lang::get('messages.something_gone_wrong_msg'))); exit; 
					}
		   	}
				else { 
					echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_same_name_already_exist')));
				}
		   } 
			 else { 
		   		echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.something_gone_wrong_msg')));				
		   }
	   } 
	  else {
		  echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.something_gone_wrong_msg')));
	  }
	  exit;
	}

	public function getViewDataRoom() {
		//save user log// 	
		checkLocations::getUserlog('view','dataroom');
		return View::make('dataroom.view-dataroom')->with('UserRole', $this->user->usertype);

	} // End getViewDataRoom function	
	
	
	public function SaveDataRoomLog($logid,$did) {
		$old = Dataroom::where('id',$did)->first();
				
		if(sizeof($old)>0) {	
			$DataRoomLog 		   		= new DataRoomLog(); 
			$DataRoomLog->logid      	   = $logid;
			$DataRoomLog->data_room_id      = $old->id;
			$DataRoomLog->name  	         = $old->name;											
			$DataRoomLog->company           = $old->company;			
			$DataRoomLog->photo  	        = $old->photo;
			$DataRoomLog->description       = $old->description;									
			$DataRoomLog->internal_user     = $old->internal_user;
			$DataRoomLog->domain_restrict   = $old->domain_restrict;
			$DataRoomLog->view_only         = $old->view_only;
			$DataRoomLog->status            = $old->status;														
			$DataRoomLog->created_at 	   = $old->created_at;
			$DataRoomLog->updated_at        = $old->updated_at;
			$DataRoomLog->save();
		}
		
	}
	function SaveLogUserAsocaitedwithDataRoom($logid,$did,$previousUser,$flag = false) {
		if(!$flag) {
			$PreUsr = array();
			$PreUsrDetails = array();
			
			foreach($previousUser as $usr) {
				$PreUsr[] = $usr->user_id;
				$PreUsrDetails[$usr->user_id]['role'] = $usr->role;
			}
			
			$NewUserDatarooms = UserDataroom::where('data_room_id',$did)->get();
			
			$NewUsr = array();
			
			foreach($NewUserDatarooms as $usr) {
				$NewUsr[] = $usr->user_id;			
			}
			
				
			/* code to added and role updtaed Users from dataroom */	
			foreach($NewUserDatarooms as $key => $NewUserDataroom) {
				
				
				if(!in_array($NewUserDataroom->user_id,$PreUsr)) {
					$UserDataRoomLog 		   	    = new UserDataRoomLog(); 			
					$UserDataRoomLog->logid     	  = $logid;
					$UserDataRoomLog->data_room_id  	= $did;
					$UserDataRoomLog->user_id          = $NewUserDataroom->user_id;																								
					$UserDataRoomLog->created_at       = date('Y-m-d H:i:s');
					$UserDataRoomLog->updated_at       = date('Y-m-d H:i:s');	
					$UserDataRoomLog->action           = 'Added';
					$UserDataRoomLog->role             = $NewUserDataroom->role;
					$UserDataRoomLog->save();
				} else if(in_array($NewUserDataroom->user_id,$PreUsr)) { 
						if($NewUserDataroom->role!=$PreUsrDetails[$NewUserDataroom->user_id]['role']) { 
							$UserDataRoomLog 		   	    = new UserDataRoomLog(); 			
							$UserDataRoomLog->logid     	  = $logid;
							$UserDataRoomLog->data_room_id  	= $did;
							$UserDataRoomLog->user_id          = $NewUserDataroom->user_id;																								
							$UserDataRoomLog->created_at       = date('Y-m-d H:i:s');
							$UserDataRoomLog->updated_at       = date('Y-m-d H:i:s');	
							$UserDataRoomLog->action           = 'Role Updated';
							$UserDataRoomLog->role             = $PreUsrDetails[$NewUserDataroom->user_id]['role'];
							$UserDataRoomLog->save();
						}
				}
			}
			
			/* code code to Deleted Users from dataroom */
			
			$DeletedUsers = array_diff($PreUsr, $NewUsr);
			
			foreach($DeletedUsers as $key => $Deleted) {
				$UserDataRoomLog 		   	    = new UserDataRoomLog(); 
				$UserDataRoomLog->logid     	  = $logid;
				$UserDataRoomLog->data_room_id  	= $did;
				$UserDataRoomLog->user_id          = $Deleted;																								
				$UserDataRoomLog->created_at       = date('Y-m-d H:i:s');
				$UserDataRoomLog->updated_at       = date('Y-m-d H:i:s');							
				$UserDataRoomLog->action           = 'Deleted';
				$UserDataRoomLog->role             = $PreUsrDetails[$Deleted]['role'];
				$UserDataRoomLog->save();			
				
			}
			
			/* end code to Deleted Users from dataroom */
		} else {
			/* executed code when a data room deleted */ 
			
			$allUserDatarooms = UserDataroom::where('data_room_id',$did)->get();
			
			foreach($allUserDatarooms as $key => $allUserDataroom) {
					$UserDataRoomLog 		   	    = new UserDataRoomLog(); 			
					$UserDataRoomLog->logid     	  = $logid;
					$UserDataRoomLog->data_room_id  	= $did;
					$UserDataRoomLog->user_id          = $allUserDataroom->user_id;																								
					$UserDataRoomLog->created_at       = date('Y-m-d H:i:s');
					$UserDataRoomLog->updated_at       = date('Y-m-d H:i:s');	
					$UserDataRoomLog->action           = 'Deleted';
					$UserDataRoomLog->role             = $allUserDataroom->role;
					$UserDataRoomLog->save();
			}
		}
		
	}
	
	public function copyFolderRecursive($source, $dest){
			if(is_dir($source)) {
				$dir_handle=opendir($source);
				while($file=readdir($dir_handle)){
					if($file!="." && $file!=".."){
						if(is_dir($source."/".$file)){
							if(!is_dir($dest."/".$file)){
								mkdir($dest."/".$file);
							}
							DataroomController::copyFolderRecursive($source."/".$file, $dest."/".$file);
						} else {
							copy($source."/".$file, $dest."/".$file);
						}
					}
				}
				closedir($dir_handle);
			} else {
				copy($source, $dest);
			}
	}
	public function CreateFolders($FolderPath,$Copyfromprojectid,$copytoProjectid,$parentfolder=0,$newfolderid=0,$CopyWithfiles=false,$projName=''){
		
		$ProjectFolders = ProjectFolder::where('project_id', $Copyfromprojectid)->where('parent_id',$parentfolder)->get();
		
		if(sizeof($ProjectFolders)>0){
			  foreach($ProjectFolders as $folder) {	
			  		  	
				 		$Fname = trim($folder->folder_name);
						
						$NewProjectFolder = new ProjectFolder(); 
						
						$NewProjectFolder->folder_name = $Fname;
						$NewProjectFolder->alias 	  = $Fname;
						
						
						$NewProjectFolder->parent_id   = $newfolderid;
						$NewProjectFolder->project_id  = $copytoProjectid;							
						$NewProjectFolder->created_at  = date('Y-m-d H:i:s');
						$NewProjectFolder->updated_at  = date('Y-m-d H:i:s');
																								
					 
						if($NewProjectFolder->save()){										
							$old = umask(0);
							mkdir($FolderPath ."/".$NewProjectFolder->id, 0775);						
							umask($old);
						}
						
						$LastestFolderId = $NewProjectFolder->id;							
						
						//save user log//	
						checkLocations::getUserlog('copy','folder',$LastestFolderId);
							
						if($CopyWithfiles) {  	
							/*copy files from old old folder to new one */
							//echo $ProjectFolders->id;
							$Files = Files::where('folder_id', $folder->id)->get();
							
							
							$CopyFilesFromFolder = base_path().'/public/folders/'.DataroomController::GetFolderPath($folder->id);
							$CopyFilesToFolder = base_path().'/public/folders/'.DataroomController::GetFolderPath($LastestFolderId);		
							
							if(sizeof($Files)>0){
								foreach($Files as $Fil) {
																
								$NewFile = new Files();								
								$fileName =  trim($Fil->file_name);								
								
								$NewFile->file_name  = $fileName;
								$NewFile->folder_id  = $LastestFolderId;
								$NewFile->size       = $Fil->size;									
								$NewFile->ext        = $Fil->ext;
								$NewFile->mime       = $Fil->mime;
								$NewFile->created_by = $this->user->id;
								$NewFile->alias      = $fileName;																
								$NewFile->created_at = date('Y-m-d H:i:s');
								$NewFile->updated_at = date('Y-m-d H:i:s');
								if($NewFile->save() && $fileName) {
									$ext = explode(".",$fileName);
									
									$physicalFileName= $Fil->id.".".$ext[1]; 
																	
									if (file_exists($CopyFilesFromFolder."/".$physicalFileName)) {
										$old = umask(0);										
										chmod($CopyFilesFromFolder, 0775);
										chmod($CopyFilesToFolder, 0775);
										chmod($CopyFilesFromFolder."/".$physicalFileName, 0775);
										copy ($CopyFilesFromFolder."/".$physicalFileName ,$CopyFilesToFolder."/".$physicalFileName);									
										umask($old);	
									} 
									$LastestFileId  = $NewFile->id;																	
									//save user log// 	
									checkLocations::getUserlog('copy','file',$LastestFolderId);
									}																						
								}
							}
						}
					$npath = $FolderPath."/".$LastestFolderId;						
					DataroomController::CreateFolders($npath,$Copyfromprojectid,$copytoProjectid,$folder->id,$LastestFolderId,$CopyWithfiles);
			  }
			  
			 
		} 
		
	}
	
	function GetFolderPath($folderid){
		$path = '';
		$ProjectFolder = ProjectFolder::where('id', $folderid)->first();
		if(sizeof($ProjectFolder)>0) {
			if($ProjectFolder->parent_id)
				return DataroomController::GetFolderPath($ProjectFolder->parent_id)."/".$folderid;
		}
		return $folderid;	
		
	}
	 
}
