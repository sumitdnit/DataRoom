<?php

class DomainDataroom extends Eloquent {

	protected $table = 'block_domain_dataroom';
	protected $fillable = array('id', 'domain', 'dataroom_id', 'history', 'created_at', 'updated_at');

	
	
}
