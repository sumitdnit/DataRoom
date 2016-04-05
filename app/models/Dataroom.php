<?php

class Dataroom extends Eloquent {

	protected $table = 'data_room';
	protected $fillable = array('id', 'name', 'user_id','company','photo','description','internal_user','domain_restrict','view_only', 'role', 'status','created_by', 'created_at', 'updated_at');
	
		public static function getAllDataRoom($user_id,$roles){
		
		if($roles=='admin'){

			return DB::table('data_room')
				->select('data_room.id as roomid', 'data_room.name')
				
				 ->orderBy('name', 'asc')
				->get();
		
		}else{
			return  DB::table('data_room')
				->join('user_dataroom', 'data_room.id', '=', 'user_dataroom.data_room_id')
				->select('data_room.id as roomid', 'data_room.name')
				->where('user_dataroom.user_id', $user_id)
				 ->orderBy('data_room.name', 'asc')
				->get();	
		}	
	}
	
	public static function getDataRoomByUserId($user_id){
		return  DB::table('data_room')
			->join('user_dataroom', 'data_room.id', '=', 'user_dataroom.data_room_id')
			->select('data_room.id as roomid', 'data_room.name', 'user_dataroom.updated_at', 'data_room.status as roomstatus','user_dataroom.role','user_dataroom.user_id','data_room.created_at as drcreatetime','data_room.updated_at as drupdatetime')
			->where('user_dataroom.user_id', $user_id)
			 ->orderBy('user_dataroom.updated_at', 'desc')
			->get();	
	}

	public static function getDataRoomForSupoerADmin(){	
		return  DB::table('data_room')
			->join('user_dataroom', 'data_room.id', '=', 'user_dataroom.data_room_id')
			->select('data_room.id as roomid', 'data_room.name', 'user_dataroom.updated_at', 'data_room.status as roomstatus','user_dataroom.role','user_dataroom.user_id')
			->where('user_dataroom.role', 'admin')
			->groupBy('data_room.id')
			->orderBy('user_dataroom.updated_at', 'desc')
			->get(); 
	}


	
public static function getDataRoomName($id){
		$tmp =   DB::table('data_room')
			->select('data_room.name')
			->where('data_room.id', $id)
			->first();
			
			if(sizeof($tmp)>0)
			 return $tmp->name;
			 else
			 return NULL;
	
	
	}	
	
	// Function for generating random token number for external user invitation
	public static function generateRandomString($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}
	
}

