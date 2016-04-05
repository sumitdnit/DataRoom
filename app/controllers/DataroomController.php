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

	public function deleteDataroom(){
		$varId = Input::get('varDataRoomId');
		if($varId > 0){
					$delete = Dataroom::where('id', $varId)->delete();
					Toastr::success('Dataroom deleted successfully !!');	
					return Redirect::to('/dataroom/view');
		}
		else {
					Toastr::error('There is some problem to delete it.!!');	
					return Redirect::to('/dataroom/view');
			}
	}
				
	public function updateDataroom(){
	       
			$roomId = Input::get('varDataRoomId');
			$varDataRoomUserId = Input::get('varDataRoomUserId');
			if($this->user->usertype=="admin") {
				$user_id = $varDataRoomUserId;
			} else {
				$user_id = $this->user->id;
			}
			
			$DataRoominfo = Dataroom::where('id', $roomId)->first();
			$DataRoomdomain = DomainDataroom::where('dataroom_id', $roomId)->first();
			
			$varDataRoomRole = Input::get('varDataRoomRole');
			$varDataRoomStatus = $DataRoominfo['status'];
			$varDataRoomName = $DataRoominfo['name'];
			$varDataRoomcomp = $DataRoominfo['company'];
			$varDataRoomdisc = $DataRoominfo['description'];
			$varDataRoomdomain = $DataRoomdomain['domain'];
			
			$photo = $DataRoominfo['photo'];
			$data = array('id'=>$roomId,'name'=>$varDataRoomName,'user_id'=>$user_id, 'role'=>$varDataRoomRole,'status'=>$varDataRoomStatus,'company'=>$varDataRoomcomp,'description'=>$varDataRoomdisc,'domain'=>$varDataRoomdomain,'photo'=>$photo);	
			return View::make('dataroom.update-dataroom')->with('data', $data);
	}
				
				
	public function saveupdateDataroom(){
	
	if(sizeof(Input::get('emails'))>0) {
					$i = 0;
					$userId = array();
					foreach (Input::get('emails') as $key => $val) {
						$useremail		= Input::get("emails.$key");
						$users = DB::table('users')
							->select('id')
							->where('users.email' , $useremail)						    
							->first();
						$userId[$useremail] = $users->id;
					}							
	}
		
		$varDataRoomAction = Input::get('Action');
		$varDataRoomName = Input::get('dataRoom');
		$varDataRoomId = Input::get('dataRoomId');
		$varDataRoomcompany = Input::get('company');
		$varDataRoomdescription = Input::get('description');
		$varUpdated = date('Y-m-d h:i:s');
		$dataimg =Input::get('userprofile_picture');
		
		if($this->user->usertype!="admin") {
			if($varDataRoomAction == 'update'){ 
			
				if($varDataRoomName != null || $varDataRoomName != ''){
						 $update = Dataroom::where('id', $varDataRoomId)->update(array('name' => $varDataRoomName, 'company' => $varDataRoomcompany, 'description' => $varDataRoomdescription, 'updated_at' =>$varUpdated, 'photo'=>$dataimg));
							
							
							$userDataroom = new UserDataroom;
							$userDataroom->user_id = $this->user->id;
							$userDataroom->data_room_id = $varDataRoomId;
							$userDataroom->role = 'admin';
							$userDataroom->updated_at = date('Y-m-d H:i:s');
							$userDataroom->save();
							
							if(sizeof(Input::get('emails'))>0) {
							foreach (Input::get('emails') as $key => $val) {
								$useremail	= Input::get("emails.$key");							
								$userDataroom = new UserDataroom;
								$userDataroom->user_id = $userId[$useremail];
								$userDataroom->data_room_id = $varDataRoomId;
								$userDataroom->role = 'view';
								$userDataroom->updated_at = date('Y-m-d H:i:s');
								$userDataroom->save();
							}
							}
							Toastr::success('DataRoom updated successfully !!');	
							return Redirect::to('/dataroom/view');
				}
				else{
					Toastr::error('Dataroom cat not be blank !!');
					return Redirect::to('/dataroom/view');
				}
			}
			else{
				Toastr::error('Dataroom wrong access !!');
				return Redirect::to('/dataroom/view');
			}
		} else { 
		if($varDataRoomAction == 'update'){ 
				if($varDataRoomName != null || $varDataRoomName != ''){
						 $update = Dataroom::where('id', $varDataRoomId)->update(array('name' => $varDataRoomName, 'company' => $varDataRoomcompany, 'description' => $varDataRoomdescription, 'updated_at' =>$varUpdated, 'photo'=>$dataimg));
							Toastr::success('DataRoom updated successfully !!');	
							return Redirect::to('/dataroom/view');
				}
				else{
					Toastr::error('Dataroom cat not be blank !!');
					return Redirect::to('/dataroom/view');
				}
			}
		}
		
	
	}
				
	public function addDataroom(){
		if($this->user->usertype=="admin") { 
			return View::make('dataroom.add-dataroom');
		} else {
		return Redirect::to('/error');
		}
	}
						
	public function saveDataroom(){	
	$arrInviteExternalUserEmail = array();
	$arrInviteInternalUserEmail = array();	
	  if(sizeof(Input::get('userEmail'))>0) {
		  $i = 0;			
			foreach (Input::get('userEmail') as $key => $val) {
				$UserType		= Input::get("source.$key");						
				if($UserType=="internal") {								
					$arrInviteInternalUserEmail[$key]['email'] = Input::get("userEmail.$key");
					$arrInviteInternalUserEmail[$key]['id'] = Input::get("userId.$key");
					if(Input::get("userRole.$key")!="user")
						$arrInviteInternalUserEmail[$key]['role'] = Input::get("userRole.$key");
					else 
						$arrInviteInternalUserEmail[$key]['role'] ='view';						
					
				} else { 							
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
							
							if($internel_user==0) {
								if(sizeof($arrInviteExternalUserEmail)>0) {
									DataroomController::inviteExternalUserDataroom($varLastInsertId,$arrInviteExternalUserEmail);
								}
							}
							
							Toastr::success('DataRoom Succesfully Added!!');
							return Redirect::to('/dataroom/view');
						}
						else{
							Toastr::error('That dataRoom is already in used !!');
							return Redirect::to('/dataroom/view');
						}
				}
				else{
					Toastr::error('Dataroom cat not be blank !!');
				return Redirect::to('/dataroom/view');
				}
			
		}
		else{
				Toastr::error('Dataroom wrong access !!');
				return Redirect::to('/dataroom/view');
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
									'email_action_text' => Lang::get('emails.invite_email_action_text')
									);
								
								Mail::send('emails.invite', $email_data, function($messag)use($data) { 
									$messag->to($data['user_email'], 'Name')->subject('invite you to join the dataroom !');
								});
							}
					}
				}
			}
		}

		
	public function getroomlist(){
	
	 
		$arrReturn = array();
		
		
		if($this->user->usertype=="admin")
		$arrDataRoom = Dataroom::getDataRoomForSupoerADmin();
		else 
		$arrDataRoom = Dataroom::getDataRoomByUserId($this->user->id);
		
		
		foreach($arrDataRoom AS $key => $val){
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
			
			
			
		}
		
		//echo "<pre>";print_r($arrReturn);die;
		return Response::json(array('data'=>$arrReturn));
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
				Toastr::error('you are not authrise for this dataRoom.');
				return Redirect::to('/dataroom/view');	
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
								$userDataroom = new UserDataroom;
								$userDataroom->user_id = $varDataRoomUser;
								$userDataroom->data_room_id = $varDataRoomId;
								$userDataroom->role = $varDataRoomRole;
								$userDataroom->created_at = date('Y-m-d');
								$userDataroom->updated_at = date('Y-m-d');
								$userDataroom->save();
								Toastr::success('DataRoom Succesfully Added!!');
								return Redirect::to('/dataroom/view');
							}
							else{
								Toastr::error('DataRoom is already shared with this user!!');
								return Redirect::to('/dataroom/view');
							}
					}
					else{
						Toastr::error('No role selected for dataRoom. Please select user role!!');
						return Redirect::to('/dataroom/view');
					}
				}
				else{
						Toastr::error('No user selected for dataRoom. Please select user first!!');
					return Redirect::to('/dataroom/view');
				}
			}
			else{
					Toastr::error('No Dataroom Selected. Please select first dataroom!!');
					return Redirect::to('/dataroom/view');
			}
				
	}	
	
	public function RemoveUserfromDataRoom(){
		$varId = Input::get('varDataRoomId');
		$varUserId = Input::get('varUserId');
		if($varId && $varUserId){
					UserDataroom::where('data_room_id', $varId)->where('user_id', $varUserId)->delete();
					Toastr::success('User Removed successfully !!');	
					return Redirect::to('/dataroom/view');
		}
		else {
					Toastr::error('There is some problem to remove this user!!');	
					return Redirect::to('/dataroom/view');
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
			Toastr::error('Please first select any dataRoom!!');	
			return Redirect::to('/dataroom/view');
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
									$message->to(Input::get('userEmail'), 'Name')->subject('Invite for dataroom');
								});
								
								Toastr::success('An email containing user name and Password has been sent to you');
								return Redirect::to('/dataroom/view');
							}
							else {
								Toastr::error('User email is already in use!!');	
								return Redirect::to('/dataroom/view');
							}
						}
						else {
							Toastr::error('Please enter user email!!');	
							return Redirect::to('/dataroom/view');	
						}
					}
					else{
						Toastr::error('Please enter first name and lastname!!');	
						return Redirect::to('/dataroom/view');	
					}
				}
				else {
					Toastr::error('Please select data room role for user!!');	
					return Redirect::to('/dataroom/view');	
				}
			}
			else {
				Toastr::error('Unbauthorished access!!');	
				return Redirect::to('/dataroom/view');	
			}
			
		}
		else {
			Toastr::error('Unbauthorished access!!');	
			return Redirect::to('/dataroom/view');
		}
	}
	
	public function getUsernames(){ 
	
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
	
	public function UpdateUsernames()
	{
	
		return $user_details= User::where('email', 'LIKE', '%' . Input::get('term') . '%')
					->where('id', '!=', $this->user->id)
					->lists('email');
					
					
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

	public function inviteInernalUserDataroom($varDataRoomId,$users){
		foreach($users AS $User){			
			$email = $User['email'];
			$varInviteUserId = $User['id'];
			$varInviteUserRole = $User['role'];
			// Add Relation
			$dataRoomRelation = new UserDataroom;
			$dataRoomRelation->user_id = $varInviteUserId;
			$dataRoomRelation->data_room_id = $varDataRoomId;
			$dataRoomRelation->role = $varInviteUserRole;
			$dataRoomRelation->save();
			$url = URL::to('/dataroom/view');

			$data = array(
				'url' => $url,
				'user_email' => $email, 
			);
			
			$email_data = array(
				'email_message' => Lang::get('invite', $data),
				'email_action_url' => $data['url'],
				'email_action_text' => 'You are invite for new data room.'
			);
			
			Mail::send('emails.invite', $email_data, function($messag)use($data) { 
				$messag->to($data['user_email'], 'Name')->subject('invite you to join the dataroom !');
			});

		}		 
		
	}
				
}
