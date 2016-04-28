<?php
/* class to get locations list from database of binding of set of functions */ 
class checkLocations {
	
	public $user = null;
	public $UserEmail = null;
	public $UserId = null;
	
	function __construct() {
		
		if (Sentry::check()) {
			$this->user = Sentry::getUser();
		}
		
		$this->UserId = $this->user->id;
		$this->UserEmail =$this->user->email;
	

   }
	
public function  saveinfo() {
	
	 $uid= $this->UserId ;
	 $this->UserEmail;
	$req= $_SERVER['REQUEST_URI'];
	$saveloc= User::where('id', $uid)->update(array('last_known_location' => $req));
	}
	

	public function getUserlog($action,$entity,$entity_id=0) { 

		$userDataroomlog = new UserLog();
		$userDataroomlog->user_id = $this->user->id;
		$userDataroomlog->action = $action;	
		$userDataroomlog->url = $_SERVER['REQUEST_URI'];
		$userDataroomlog->entity = $entity;
		$userDataroomlog->entity_id = $entity_id;
		$userDataroomlog->save();
	
		return $userDataroomlog->id;
	} 
	
public function addclick()  {

 // assume you have a clicks  field in your DB
 $this->clicks = $this->clicks + 1;
 $this->save();

}
	
public function get($tokenKey) {
		
		return Redirect::to(Input::get('referer'));
        if(isset($tokenKey)) {
            return $this->$tokenKey;
        }
        return null;
    }
		
	
}
//checkLocations::getSubModulePermisions('Project');
?>
