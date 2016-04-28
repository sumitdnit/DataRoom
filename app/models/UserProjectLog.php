<?php

class UserProjectLog extends Eloquent {

    protected $table = 'user_project_log';
    protected $fillable = array('id', 'logid','user_id','project_id','action' ,'data_room_id','role', 'created_at', 'updated_at');
}
