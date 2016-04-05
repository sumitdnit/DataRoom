<?php

class UserDataroom extends Eloquent {

	protected $table = 'user_dataroom';
	protected $fillable = array('id', 'user_id', 'data_room_id', 'role', 'created_at', 'updated_at');
	
	
	public static function getDataRoomForUser($varRoomID){
		return $arrDataRoomList = UserDataroom::where('data_room_id', $varRoomID)->where('role','!=','admin')->get()->toArray();
	}
	
	public static function getRoleDataRoomUser($varRoomID,$userid){
		$arrDataRoomList = UserDataroom::where('data_room_id', $varRoomID)->where('user_id',$userid)->first();
		if(count($arrDataRoomList)>0)
			return $arrDataRoomList->role;
		else
			return false;
		
	}
	public static function getUsercount($varRoomID){
		$userDataRoomList = UserDataroom::where('data_room_id', $varRoomID)->get();
		return count($userDataRoomList);
   }

}
