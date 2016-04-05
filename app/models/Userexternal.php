<?php

class Userexternal extends Eloquent {

	protected $table = 'users';
	protected $fillable = array('id', 'email', 'password', 'permissions', 'activated', 'activation_code', 'activated_at', 'source', 'bring_by', 'photo', 'last_login', 'persist_code', 'reset_password_code', 'first_name', 'last_name', 'login_time', 'last_known_location', 'usertype', 'created_at', 'updated_at');

	public static function getUserByUserId($user_id){
      $profile_details = '';
      $profile_details = Userexternal::where('id', $user_id)->first();
        if($profile_details){
          return $profile_details;
        }
        return $profile_details;
    }
	
}
