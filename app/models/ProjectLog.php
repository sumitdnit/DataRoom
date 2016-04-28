<?php

class ProjectLog extends Eloquent {

    protected $table = 'project_log';   
    protected $fillable = array('id', 'logid','project_id','data_room_id','name','company','photo','description','internal_user','domain_restrict','view_only', 'status','created_by', 'created_at', 'updated_at');
}
