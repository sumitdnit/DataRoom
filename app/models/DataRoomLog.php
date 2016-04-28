<?php

class DataRoomLog extends Eloquent {

    protected $table = 'dataroom_log';   
    protected $fillable = array('id', 'logid','data_room_id','name','company','photo','description','internal_user','domain_restrict','view_only', 'status','created_by', 'created_at', 'updated_at');
}
