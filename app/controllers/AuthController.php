<?php

class AuthController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->afterFilter("no-cache", ["only"=>"getIndex"]);
        $this->beforeFilter('auth', array('except' => array('getLoginPage','getSuccess', 'getSignUp', 'postCreateUser', 'postLogin', 'getVerify', 'getForgotPassword', 'postForgotPassword', 'getResetPassword', 'postResetPassword','sendInvite' )));
    }

    public function getLoginPage() {
        if (!Sentry::check()) {
            $cookie_email = Cookie::get('remember_email');
            $image = '';
            $cookie = array('email' => '');
            if ($cookie_email) {
                try{
                    $user = Sentry::findUserByLogin($cookie_email);
                    $image = ($user->profile->photo) ? URL::asset('public/uploads/' . $user->profile->photo) : '';
                    $cookie = array('email' => $cookie_email, 'image' => $image);
                }catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                  Cookie::make('remember_email', '', -5);
                }
            }
            
            return View::make('auth.login')->with(array('cookie' => $cookie));
        } else {
                  return Redirect::to('dataroom/view/');
        }
    }

    public function postLogin() {
        try {
            $credentials = array(
                'email' => Input::get('email'),
                'password' => Input::get('password'),
            );
            $remember = (Input::has('remember')) ? true : false;
            $user = Sentry::authenticate($credentials, $remember);
			
		
									
            if (Input::has('remember')) {
                $cookie = Cookie::forever('remember_email', Input::get('email'));
				 $cookie = Cookie::forever('user_type',$user->usertype);
				
            } else {
                $cookie = Cookie::forever('remember_email', '');
				$cookie = Cookie::forever('user_type', '');
            }
            $response = array(
                'status' => 'success',
                'flash' => 'You are logged in'
            );
        } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
            $response = array(
                'password' => 'password',
                'status' => 'error',
                'flash' => 'Wrong password, try again', 412);
        }
        // The following is only required if the UserNotFoundException
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $response = array(
                'status' => 'error',
                'flash' => 'User was not found', 412);
        }
        // The following is only required if the UserNotActivatedException
        
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $response = array(
                'status' => 'error',
                'flash' => 'User is not activated', 412);
        }

    // The following is only required if the throttling is enabled

        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            $response = array(
                'status' => 'error',
                'flash' => 'User is suspended', 500);
        } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
            $response = array('status' => 'error',
                'flash' => 'User is banned', 500);
        }catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $response = array('status' => 'error',
                'flash' => 'Password field is required', 412);
        }catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $response = array('status' => 'error',
                'flash' => 'Email field is required', 412);
        }

        if ($response['status'] == 'success') {
            $profile = $user->profile;
            if ($profile) {
                if ($profile->timezone == '') {
                    $tz = Config::get('app.timezone');
                } else {
                    $tz = $profile->timezone;
                }
                Session::put("user_timezone", $tz);
            }
            Toastr::success($response['flash'], $title = null, $options = []);
						
            return Redirect::to('dataroom/view/')->withCookie($cookie);
            
        } else {
            Toastr::error($response['flash']);
            return Redirect::to('/');
        }
    }

    public function getSignUp() {
       $varToken = Input::get('token');
			$varDataRoomID = base64_decode(Input::get('p'));
			$varUserID = base64_decode(Input::get('u'));
			
			if($varUserID!='' && $varUserID > 0){
				if($varDataRoomID!='' && $varDataRoomID > 0){
					if($varToken!=''){
						$varCheckToken = Userexternal::where('id', $varUserID)->select('activation_code','email','activated')->first();	
						$varUserToken  = $varCheckToken->activation_code;
						$varUserEmail  = $varCheckToken->email;
						$varActivated  = $varCheckToken->activated;
						//if($varActivated == 0){
							if($varUserToken == $varToken){								
							$update = Userexternal::where('id', $varUserID)->update(array('activated' => '1', 'updated_at' =>date('Y-m-d H:i:s')));
								//Toastr::success('User Activated successfully for using Dataroom, Please fill user information!!');
								$data = array('userid'=>$varUserID,'email'=>$varUserEmail,'token'=>$varToken);							
								return View::make('auth.sign-up')->with('data', $data);
							}
							else{
								Toastr::error('Unauthorished access for that URL!!');	
								return Redirect::to('/');
							}
						//}
						//else {
						//	Toastr::error('User is already activated.Please login!!');	
						//	return Redirect::to('/');
						//}
					}
					else{
						Toastr::error('Unauthorished access for that URL!!');	
						return Redirect::to('/');
					}
				}
				else{
					Toastr::error('Unauthorished access for that URL!!');	
				 return Redirect::to('/');
				}
			}
			else {
				 Toastr::error('Unauthorished access for that URL!!');	
				 return Redirect::to('/');
			}
    }
    public function getSuccess($user_id) {
        $email = Profile::getUserEmailByUserId($user_id);
        return View::make('auth.succesfull')->with(array('email' => $email));
    }
    public function postCreateUser() { 
		
			if (Input::get('password')) {
				if(Input::get('firstname')){
					if(Input::get('lastname')){
						if(Input::get('email')){
							Session::forget('success_login');
							Sentry::logout();
							$varOrganization = Input::get('organization');
							$varPhoneNumber = Input::get('phonenumber');
							$varStdCode = Input::get('stdcode');
							$varUserId = Input::get('user_id');
							$varToken = Input::get('token');
							if($varUserId > 0 && $varUserId!=''){
								
								$update = Userexternal::where('id', $varUserId)->update(array('password' => Hash::make(Input::get('password')), 'updated_at' =>date('Y-m-d H:i:s')));
								
								$profile = new Profile();
                $profile->user_id      = $varUserId;
                $profile->firstname    = Input::get('firstname');
                $profile->lastname     = Input::get('lastname');
								$profile->organization = $varOrganization;
								$profile->phone_code   = $varStdCode;
								$profile->phone_number = $varPhoneNumber;
                $profile->timezone = Input::get('user_tz');
                $profile->save();

								Toastr::success('Your information is saved successfully. Please login.');
								return Redirect::to('/'); 
							}
							else{
								$response = array('message' => 'Unauthorished access!',);
							}
						}
						else{
							$response = array('message' => 'Please enter your email!',);
						}
					}
					else{
						$response = array('message' => 'Please enter your last name!',);
					}
				}
				else{
					$response = array('message' => 'Please enter your first name!',);
				}
			}
			else{
				$response = array('message' => 'Password field does not match',);
			}
			 Toastr::error($response['message']);
       return Redirect::to('/');  
    }

    public function getVerify($activationCode) {
        try{
           $user = Sentry::FindUserByActivationCode($activationCode);
            $user->activated = true;
            $user->save();
            Toastr::success('You have successfully verified your account');
            return Redirect::to('/'); 
        }catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            Toastr::error('User Was not Found');
            return Redirect::to('/');        
        }
    }

    public function getForgotPassword() {
        return View::make('auth/forgot-password');
    }

    public function postForgotPassword() {
        try {
            $email = Input::get('email');
            $user = Sentry::findUserByLogin($email);
            $resetCode = $user->getResetPasswordCode();
            $url = URL::to('/reset-password' . '/' . $resetCode . '/' . $user->id);
            $data = array('url' => $url);
            $email_data = array(
                    'email_message' => Lang::get('emails.reset_email_text'),
                    'email_action_url' => $url,
                    'email_action_text' => Lang::get('emails.reset_email_action'), 
            );
            Mail::send('emails.auth.invite', $email_data, function($message) use($user) {
                $message->to(Input::get('email'), 'Name')->subject('Reset RaVaBe Account Password');
            });
            Toastr::success('An email containing Reset Password link has been sent to you');
            return Redirect::to('/');
            // Now you can send this code to your user via email for example.
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $response = array(
                'message' => 'User was not found'
            );
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $response = array(
                'message' => 'Email field is required'
            );
        }
        Toastr::error($response['message']);
        return Redirect::to('/forgot-password');
    }

    public function getResetPassword($resetCode, $user_id) {
        try {
            $user = Sentry::findUserByResetPasswordCode($resetCode);
            if ($user->checkResetPasswordCode($resetCode)) {
                if($user->isActivated() == true){
                  Sentry::login($user, false);
                  return View::make('auth.reset-password')->with(array('reset_code' => $resetCode, 'user_id' => $user_id));
                }else{
                   Toastr::error('Please activate your account by verifying email and try again.');
                    return Redirect::to('/'); 
                }
                
            }
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            Toastr::error('Code not valid');
            return Redirect::to('/');
        } 
    }

    public function postResetPassword() {
        $reset_code = Input::get('reset_code');
        $user_id = Input::get('user_id');
        $password = Input::get('password');
        $resetpassword = Input::get('re-password');
        $user = Sentry::findUserById($user_id);
        try{
            if ($user->checkResetPasswordCode($reset_code)) {
                if($resetpassword===$password){
                    if ($user->attemptResetPassword($reset_code, $password)) {
                        Sentry::logout();
                        $response = array(
                            'message' => 'Password reset successful.'
                            );
                        Toastr::success('Password reset successful');
                        return Redirect::to('/');
                    } else {
                        $response = array(
                            'message' => 'Password reset unsuccessful.'
                            );
                    }
                } else{
                    Toastr::error('Password not matched');
                    return Redirect::to('/reset-password/'.$reset_code.'/'.$user_id); 
                } 
            } else {  
                $response = array(
                    'message' => 'Invalid Reset Password Code.'
                    );
            }  
            Toastr::error($response['message']);
            return Redirect::to('/');
        }catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            Toastr::error('Password field is required.');
            return Redirect::to('/reset-password/'.$reset_code.'/'.$user_id);
        }
    } 
	
	
	 public function sendInvite($user_id) { 
		$varUserID = base64_decode($user_id);
		if($varUserID > 0){
			$user = Userexternal::where('id', $varUserID)->first();
			
			if($user->activated == 0){
				$update = Userexternal::where('id', $varUserID)->update(array('activated' => '1'));
				Toastr::success('User Activated successfully !!');	
				return Redirect::to('/');
			}
			else{
				Toastr::error('User already activated.');
				return Redirect::to('/');
			}
		}
		else {
			Toastr::error('Unauthorished Access!!');
			return Redirect::to('/');  
		}
	}
    
	

    public function getLogout() {
        Session::forget('success_login');
        Sentry::logout();
        return Redirect::to('/');
    }
	
	 public function getGroup() {
        return View::make(auth.group);
    }

    public function getError() {
        return View::make('auth.error');
    }

	
}
