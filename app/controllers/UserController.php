<?php

class UserController extends BaseController {

    public $user = null;

    public function __construct() {
        $this->beforeFilter('auth');
        parent::__construct(); 
        if (Sentry::check()) {
            $this->user = Sentry::getUser();
        }
    }

    public function getGeneralSetting() {
        $timezone_details = Profile::getUserTimeZonelist();
	   
	  $profiles =  Profile::getUserDetail($this->user->id);
	 
		
        return View::make('setting/user-setting')->with(array('user' => $this->user,'profiles' => $profiles[0],'timezone_details'=>$timezone_details));
    }

    public function postUpdateUserProfile() {
        $user_profile = Input::all();
		$Profile = Profile::where("user_id",$this->user->id)->first();
        $Profile->photo = Input::get('userprofilepicture');
        $Profile->firstname = Input::get('firstname');
        $Profile->lastname = Input::get('lastname');
		 $Profile->timezone = Input::get('user_tz');
		$Profile->save();
      
      	
        Session::forget('user_timezone');
        if ($Profile->timezone == '') {
            $tz = Config::get('app.timezone');
        } else {
            $tz = $Profile->timezone;
        }
        Session::put("user_timezone", $tz);
        if (Input::has('password')) {
            $this->user->password = Input::get('password');
            $this->user->save();     
        }
        Toastr::success(Lang::get('success.profile', ['name' => $Profile->firstname]), $title = null, $options = []);
        return Redirect::to('general-settings');
    }

    public function postProfilePhoto() {
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
        return Response::json($response);
    }
    
	 public function getChangePassword() {
        return View::make('setting/change-password');
    }
    
	public function postChangePassword() {
			$oldpassword   = Input::get('oldpassword');
			$password 		 = Input::get('password');
			$resetpassword = Input::get('re-password');
		
			$passes = array(
										'oldpassword'  => $oldpassword,
										'password' => $password,
										'resetpassword' => $resetpassword
									);
		
			$rules = array(
									'oldpassword' => 'required|numbers|letters|symbols|between:8,16',
									'newpassword' => 'required|numbers|letters|symbols|between:8,16|confirmed|different:oldpassword'
									);
    
		  $user = Sentry::findUserById($this->user->id);
			
		  if($user->checkPassword($oldpassword)){
				if($resetpassword==$password){
				  if ($password!='') {
					  $this->user->password = $password;
					  $this->user->save();  
					  Toastr::success(Lang::get('messages.password_change_msg'));
					  return Redirect::to('change-password');   
				  }
				}
			  else{
				  Toastr::error(Lang::get('messages.msg_password_confirm_password_not_match'));
				  return Redirect::to('change-password'); 
			  }
		  }
		  else {
			  Toastr::error(Lang::get('messages.msg_old_password_not_match'));
			  return Redirect::to('change-password'); 
		  } 
    }
		
    public function getUserList() {
        $userName = array();
        $term = Input::get('term', '');
        foreach ($userDetails as $userDetail) {
            $userName[] = ['label' => $userDetail['display_name'], 'value' => $userDetail['display_name'], 'name' => $userDetail['email']];
        }
        return Response::json($userName);
    }
	public function Dashboard(){
	
	return View::make('dataroom/dashboard');
	}
	
	  public function listUsers() {
		  if(Input::get('order'))
				$ascdsc = Input::get('order');
			else
				$ascdsc = 'asc';
			
			if(Input::get('sortby')=='last')
				$sortby = 'users.updated_at';	
			else	
				$sortby = 'profiles.firstname';
			
			$dataarr=base64_decode(Input::get('did'));
			
			$projarr=base64_decode(Input::get('pid'));
			
			if($this->user->usertype=='admin'){
			if($dataarr){
				$Users= DB::table('users')
					->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
					->leftJoin('user_dataroom', 'user_dataroom.user_id', '=', 'users.id')			
					->select('users.id as userid','users.email','users.usertype','users.source','profiles.firstname','profiles.lastname','users.updated_at','profiles.photo','user_dataroom.data_room_id','user_dataroom.role')	
                   ->where('user_dataroom.data_room_id','=',$dataarr)	
					->groupBy('users.id')
					->orderBy($sortby, $ascdsc)	
					->get();
					}elseif($projarr)
					{
					$Users= DB::table('users')
					->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
					->leftJoin('user_project', 'user_project.user_id', '=', 'users.id')			
					->select('users.id as userid','users.email','users.usertype','users.source','profiles.firstname','users.updated_at','profiles.lastname','profiles.photo','user_project.dataroom_id','user_project.role')	
                   ->where('user_project.project_id','=',$projarr)	
					->groupBy('users.id')
					->orderBy($sortby, $ascdsc)	
					->get();
					}
					else{
					$Users= DB::table('users')
					->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
					->leftJoin('user_dataroom', 'user_dataroom.user_id', '=', 'users.id')			
					->select('users.id as userid','users.email','users.usertype','users.source','profiles.firstname','users.updated_at','profiles.lastname','profiles.photo','user_dataroom.data_room_id','user_dataroom.role')                   	
					->groupBy('users.id')
					->orderBy($sortby, $ascdsc)	
					->get();
					}
							
				//echo '<pre>';
				//dd(DB::getQueryLog());
				//die;
				$currentUser = array("role"=>$this->user->usertype,"id"=>$this->user->id);
				return View::make('setting/users')->with('Users', $Users)->with('currentUser',$currentUser)->with('ascdsc',$ascdsc)->with('sortby',$sortby);
			} else {
				$UserDatarooms =  Dataroom::getDataRoomByUserId($this->user->id);
				
				if(sizeof($UserDatarooms)>0){
					$Users= DB::table('users')
						->join('profiles', 'profiles.user_id', '=', 'users.id')
						->leftJoin('user_dataroom', 'user_dataroom.user_id', '=', 'users.id')			
						->select('users.id as userid','users.email','users.usertype','users.source','profiles.firstname','profiles.lastname','profiles.photo','user_dataroom.data_room_id','user_dataroom.role')
						->where('users.id','=' ,$this->user->id)
						->where('users.activated',1)	
						->groupBy('users.id')	
						->orderBy('profiles.firstname', 'asc')	
						->get();
				} else {
					$Users= DB::table('users')
						->join('profiles', 'profiles.user_id', '=', 'users.id')
						->select('users.id as userid','users.email','users.usertype','users.source','profiles.firstname','profiles.lastname','profiles.photo')
						->where('users.id','=' ,$this->user->id)
						->where('users.activated',1)	
						->groupBy('users.id')	
						->orderBy('profiles.firstname', 'asc')	
						->get();		
				}
				
				$currentUser = array("role"=>$this->user->usertype,"id"=>$this->user->id);
				return View::make('setting/users')->with('Users', $Users)->with('currentUser',$currentUser)->with('ascdsc',$ascdsc)->with('sortby',$sortby);
				
			}
		  }
	
	 public function listDiscUsers() {
	  if($this->user->usertype=='admin'){
				$Users= DB::table('users')
				->join('profiles', 'profiles.user_id', '=', 'users.id')
				->leftJoin('user_dataroom', 'user_dataroom.user_id', '=', 'users.id')			
					->select('users.id as userid','users.email','users.usertype','users.source','profiles.firstname','profiles.lastname','profiles.photo','user_dataroom.data_room_id','user_dataroom.role')
				->where('users.id','<>' ,$this->user->id)
				->where('users.activated',1)	
				->groupBy('users.id')	
			   ->orderBy('profiles.firstname', 'desc')	
				->get();
		
	 	$currentUser = array("role"=>$this->user->usertype,"id"=>$this->user->id);
		
				
        return View::make('setting/users')->with('Users', $Users)->with('currentUser',$currentUser);
		}
		else
		{
		return Redirect::to('/error');
		}
    }
	
	 public function UsersDetails() {
	  $currentUser = array("role"=>$this->user->usertype,"id"=>$this->user->id);
		$id	=	Input::get('id');
		$Users	= DB::table('users')
			->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
			->select('users.id as userid','users.email','users.usertype','users.source','profiles.firstname','profiles.lastname','profiles.photo')
			->where('users.id','=' ,$id)			
			//->where('users.activated',1)				
			->first();
			//echo'<pre>';
			//print_r($Users);
			//die;
		
		$Usersphoto = 	($Users->photo != '') ? URL::asset('public/uploads/'.$Users->photo) : URL::asset('assets/images/60.png');		
		
		$html='';
       $datarooms=Dataroom::getDataRoomByUserId($id);
	   
	 if (sizeof($datarooms)>0){
     $html .='<ul>';
       foreach ($datarooms as $dr) { 		
         $html .='<li class="expand">';
		 
			$class = "dataroom-unit clearfix";
			if(Dataroom::getDataRoomOverRide($dr->roomid))	
			$class = "dataroom-unit active clearfix";
				
				
           $html .='<div class="'.$class.'">
            <div class="info"><strong>'.ucfirst($dr->name).'</strong></div>
            <div class="update-date">'.date('m/d/Y | H:i A',strtotime($dr->updated_at)).$currentUser['id'].'</div>';
				if($currentUser['role']=="admin" ){ 
            $html .= '<div class="roleEdit" onclick="EditRoom(this)">'.Lang::get('messages.label_edit').'</div>
            <div class="expand-wrapper"><a href="javascript:void(0);"></a></div>';
			} 
           $html .='</div>';
		   
        $projectrooms=Project::getProjectByUserDataRoomId($dr->roomid,$id); 
		 
		 if (sizeof($projectrooms)>0){
          $html .='<ul>';
            foreach ($projectrooms as $pr) {			
			
			$pid=base64_encode($pr->projid);
			$url=URL::to('/').'/project/edit?p='.$pid;
			$pclass = "project-unit clearfix";
			if(Project::getProjectRoomOverRide($pr->projid))	
				$pclass = "project-unit clearfix active";
				
				
             $html .='<li>
              <div class="'.$pclass.'">
                <div class="info"><strong>'.ucfirst($pr->name).'</strong></div>';
                	if($currentUser['role']=="admin"){ 
				 $html .='<span class="roleEditsmall"><a href="'.$url.'">'.Lang::get('messages.label_edit').'</a></span>';
				 } 
				  $html .='</div>';
             $html .='</li>';
            } 
           $html .='</ul>';
		  } 
           $html .='<div style="display:none" class="editdataroom">
            <div class="DataRoomId" val="'.$dr->roomid.'"></div>
            <div class="DataRoomUserId" val="'.$dr->role.'"></div>
            <div class="DataRoomRole" val="'.$dr->user_id.'"></div>
          </div>
        </li>';
        } 
       $html .='</ul>';
	   
	
	   } 
	   
	 $html .='<script>function EditRoom(div){var varDataRoomId = $(div).parents(".expand").find(".editdataroom").find(".DataRoomId").attr("val");$("#varDataRoomId").val(varDataRoomId); var varDataRoomUserId = $(div).parents(".expand").find(".editdataroom").find(".DataRoomUserId").attr("val");$("#varDataRoomUserId").val(varDataRoomUserId);var varDataRoomRole = $(div).parents(".expand").find(".editdataroom").find(".DataRoomRole").attr("val");$("#varDataRoomRole").val(varDataRoomRole);$("#dataroomupdate").submit(); } $(".usercard-dataroom-wrapper a").click(function(){var parent = $(this).parent().parent().parent();parent.toggleClass("expand");});</script>';
	 
	 
	$userinfo = ''.$Users->userid;
	$userinfo .= '--ppp--'.ucfirst($Users->usertype);
	$userinfo .= '--ppp--'.ucfirst($Users->source);
	$userinfo .= '--ppp--'.$Users->email;
	
	$userinfo .= '--ppp--'.ucfirst(strtolower($Users->firstname))." ".ucfirst(strtolower($Users->lastname));
	 
	  $userinfo .= '--ppp--'. (($Users->userid!=$this->user->id)?1 :0);
	 
	   	   $output = $userinfo.'--predeep--'.$Usersphoto.'--predeep--'.$html;	
		  
	echo json_encode(array('flag'=>'success','msg'=>$output));	
   	exit;
    }
	
	 public function UsersSaves() {	 
		$id		=	Input::get('id');
		$role	=	Input::get('role');
		//$utype	=	Input::get('utype');
		if($role && $id) {
		   $User = User::find($id);
		  
		   if(sizeof($User)>0) {
			   			
			$User = DB::table('users')
				->where('id', $id)
				->update(array('usertype' => $role));
			$User = DB::table('user_dataroom')
				->where('user_id', $id)
				->update(array('role' => $role));
			
			 echo json_encode(array('flag'=>'success','msg'=>Lang::get('messages.msg_user_role_updated_successfully')));
			   			  
		   } else { 
		   		echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_warning_user')));				
		   }
	   } else {
	   
			echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.something_gone_wrong_msg')));
			
	   }
	  
	    exit;
	 }
	 
	  public function deleteUser() {	 
		$id		=	Input::get('id');		
		if($id) {
		   $User = User::find($id);
		   if(sizeof($User)>0) {
		       $FolderRelation = FolderRelation::where('user_id', $id)->delete();	   
				$UserProjects = UserProject::where('user_id', $id)->delete();			 
				$delete = UserDataroom::where('user_id', $id)->delete(); 
				$delete = Profile::where('user_id', $id	)->delete();
				$delete = User::where('id', $id	)->delete();
			   echo json_encode(array('flag'=>'success','msg'=>Lang::get('messages.msg_user_deleted_successfully')));			  
		   } else { 
		   		echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_warning_user')));				
		   }
	   } else {
			echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.something_gone_wrong_msg')));
			
	   }
	    exit;
	 }
	 
	 // user detail
	 	public function UserInfo() {
	 
		$UserDatarooms =  Dataroom::getDataRoomByUserId($this->user->id);
		
		if(sizeof($UserDatarooms)>0){
				$Users= DB::table('users')
				->join('profiles', 'profiles.user_id', '=', 'users.id')
				->leftJoin('user_dataroom', 'user_dataroom.user_id', '=', 'users.id')			
					->select('users.id as userid','users.email','users.usertype','users.source','profiles.firstname','profiles.lastname','profiles.photo','user_dataroom.data_room_id','user_dataroom.role')
				->where('users.id','=' ,$this->user->id)
				->where('users.activated',1)	
				->groupBy('users.id')	
			   ->orderBy('profiles.firstname', 'asc')	
				->get();
		} else {
			$Users= DB::table('users')
				->join('profiles', 'profiles.user_id', '=', 'users.id')
				->select('users.id as userid','users.email','users.usertype','users.source','profiles.firstname','profiles.lastname','profiles.photo')
				->where('users.id','=' ,$this->user->id)
				->where('users.activated',1)	
				->groupBy('users.id')	
			   ->orderBy('profiles.firstname', 'asc')	
				->get();
				
		}
	
	 	$currentUser = array("role"=>$this->user->usertype,"id"=>$this->user->id);
		
        return View::make('setting/userdetail')->with('Users', $Users)->with('currentUser',$currentUser);
		
    }
	 
	 // leave data room
	 
	   public function leaveDataroom() {	 
		$did		=	Input::get('did');	
		
		if($did ) {		
			UserProject::where('dataroom_id', $did)->where('user_id',$this->user->id)->delete();
			UserDataroom::where('data_room_id', $did)->where('user_id',$this->user->id)->delete();
			return json_encode(array('flag'=>'success','msg'=>Lang::get('messages.msg_leave_dataroom_successfully')));		
		} else {
		echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.something_gone_wrong_msg')));		
		}
		exit;
	 }

	 
	  // leave project room
	  public function leaveProject() {	 
		 $did		=	Input::get('did');	
		 $pid		=	Input::get('pid');
		
		if($pid && $did) {		  
		   $UserProjects = UserProject::where('dataroom_id', $did)->where('project_id', $pid)->where('user_id',$this->user->id)->delete();	
		   return json_encode(array('flag'=>'success','msg'=>Lang::get('messages.msg_leave_project_successfully')));					  
	   } else {
			echo json_encode(array('flag'=>'error','msg'=>Lang::get('messages.something_gone_wrong_msg')));			
	   }
	    exit;
	 }
	
	/*
	*For resend mail to not activated user.
	*28//04/16
	*@krrish
	*/
	public function revokeUser(){
		//var_dump(Input::all());exit;
		$params = Input::all();
		$userInfo = User::where('id',$params['userId'])->where('activated',0)->first();
		$userDroom = UserDataroom::where('user_id',$params['userId'])->first();
		if($userInfo && $userDroom){
			$url = URL::to('/sign-up').'?token='.$userInfo->activation_code.'&p='.base64_encode($userDroom->data_room_id).'&u='.base64_encode($params['userId']);
												
			$abemail = $userInfo->email;	
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
			echo  json_encode(array('flag'=>'success','msg'=>Lang::get('messages.msg_Invitation_sent_successfully'))); exit;
		}
		else{
			echo  json_encode(array('flag'=>'error','msg'=>Lang::get('messages.msg_unauthorished_access'))); exit;
		}		
	}
	
}


