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
            $response['result'] = 'No photo uploaded.';
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
					  Toastr::success('Password has been change successfully!');
					  return Redirect::to('change-password');   
				  }
				}
			  else{
				  Toastr::error('Password and confirm password does not match!!');
				  return Redirect::to('change-password'); 
			  }
		  }
		  else {
			  Toastr::error('Old password does not match!!');
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
}


