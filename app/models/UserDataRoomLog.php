<?php

class UserDataRoomLog extends Eloquent {

    protected $table = 'user_dataroom_log';
    protected $fillable = array('id', 'user_id','action' ,'data_room_id','role', 'created_at', 'updated_at');
}
