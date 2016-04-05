<?php

class UserProject extends Eloquent {

    protected $table = 'user_project';
    protected $fillable = array('id', 'user_id', 'project_id','dataroom_id', 'role', 'created_at', 'updated_at');

				
				public static function getProjectForUser($varProjectID){
					 return $arrProjectList = UserProject::where('project_id', $varProjectID)->where('role','!=','admin')->get()->toArray();
    }
	
	public static function getRoleProjectUser($varRoomID,$varPojectRoomID,$userid){
		$arrProjectList = UserProject::where('project_id', $varPojectRoomID)->where('dataroom_id', $varRoomID)->where('user_id',$userid)->first();
		if(count($arrProjectList)>0)
		return $arrProjectList->role;
		else
		return false;
		
	}
	
		public static function getProjectUser($varRoomID,$userid){
			return $arrProjectList = UserProject::where('dataroom_id', $varRoomID)->where('user_id',$userid)->get()->toArray();
		}
			
			public static function getUsercount($varRoomID){
		$userProjectList = UserProject::where('project_id', $varRoomID)->get();
		return count($userProjectList);
   }	
}
