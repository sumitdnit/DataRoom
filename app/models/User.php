<?php

//use Illuminate\Auth\UserTrait;
//use Illuminate\Auth\UserInterface;
//use Illuminate\Auth\Reminders\RemindableTrait;
//use Illuminate\Auth\Reminders\RemindableInterface;
//
//class User extends Eloquent implements UserInterface, RemindableInterface {
//
//	use UserTrait, RemindableTrait;
//
//	/**
//	 * The database table used by the model.
//	 *
//	 * @var string
//	 */
//	protected $table = 'users';
//
//	/**
//	 * The attributes excluded from the model's JSON form.
//	 *
//	 * @var array
//	 */
//	protected $hidden = array('password', 'remember_token');
//
//}
use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;

class User extends SentryUser {

    // Override the SentryUser getPersistCode method.
    protected $table = 'users';
    protected $hidden = array('password', 'remember_token');
    public function getPersistCode() {
        if (!$this->persist_code) {
            $this->persist_code = $this->getRandomString();

            // Our code got hashed
            $persistCode = $this->persist_code;

            $this->save();

            return $persistCode;
        }
        return $this->persist_code;
    }
    
       public static function getUserInfo($id){ 
					return $user = User::where('id', $id)->select('*')->first();
				}

	 public static function getUserFulName($id){ 
					$Usr = DB::table('profiles')->select('firstname', 'lastname')->where('user_id', $id)->first();
					return ucfirst($Usr->firstname)." ".ucfirst($Usr->lastname);
				}
		
		// Function used to display user first name if avaialbe or not for email invitation
		// Developed by kapil		
		public static function getUserFirstName($id){
			$Usr = DB::table('profiles')->select('firstname')->where('user_id', $id)->first();
			return $varName = (count($Usr) > 0)?ucfirst($Usr->firstname):'';
		}
   
}
