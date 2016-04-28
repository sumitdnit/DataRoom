<?php

class UserLog extends Eloquent {

	protected $table = 'user_logs';
	protected $fillable = array('id', 'user_id', 'action', 'url','entity' ,'entity_id','created_at', 'updated_at');

}
