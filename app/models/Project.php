<?php 

class Project extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';
    protected $fillable = array('id','name','data_room_id','company','photo','description','updateby', 'status','created_at','updated_at');
	
	
		
	public static function getAllProjects($dataroomId,$user,$roles){
		if($roles=='admin'){
			return $sql= DB::table('projects')	
			->select('projects.id as projid', 'projects.name')
			->where('data_room_id', $dataroomId)	
			->where('projects.status', 1)->get();	

		}else{	
			return DB::table('projects')
			->join('user_project', 'projects.id', '=', 'user_project.project_id')
			->select('projects.id as projid', 'projects.name')
			->where('user_project.dataroom_id', $dataroomId)
			->where('user_project.user_id',$user)
			->where('projects.status', 1)	
			->get();
			}	
 } 
	
	
	   public static function getProjectForAdmin($user_id){
			return DB::table('projects')
				->join('user_project', 'projects.id', '=', 'user_project.project_id')
				->select('projects.id as projid', 'projects.name', 'projects.status as projstatus','user_project.updated_at','user_project.role','user_project.user_id','user_project.dataroom_id')
				->where('user_project.user_id', $user_id)
				->get();
												
  }

	
	public static function getProjectByUserDataRoomId($dataroomId,$user){
		return DB::table('projects')
            ->join('user_project', 'projects.id', '=', 'user_project.project_id')
            ->select('projects.id as projid', 'projects.name', 'projects.status as projstatus','user_project.role','user_project.user_id','user_project.dataroom_id')
						->where('user_project.dataroom_id', $dataroomId)
						->where('user_project.user_id',$user)
						->where('projects.status', 1)	
						 ->get();
												
  }

  
    public static function getProjectForUser($user_id, $dataroomId){
			if($dataroomId > 0){
				return DB::table('projects')
					->join('user_project', 'projects.id', '=', 'user_project.project_id')
					->select('projects.id as projid', 'projects.name', 'projects.updated_at', 'projects.status as projstatus','user_project.role','user_project.user_id','user_project.dataroom_id')
					->where('user_project.user_id', $user_id)
					->where('user_project.dataroom_id', $dataroomId)
					->where('projects.status', 1)
					->orderBy('projects.updated_at', 'desc')	
					->get();
			}
			else {
				return DB::table('projects')
					->join('user_project', 'projects.id', '=', 'user_project.project_id')
					->select('projects.id as projid', 'projects.name', 'projects.updated_at', 'projects.status as projstatus','user_project.role','user_project.user_id','user_project.dataroom_id')
					->where('user_project.user_id', $user_id)
					->where('projects.status', 1)
					->orderBy('projects.updated_at', 'desc')	
					->get();
			}
												
  }
  

public static function getProjectForSupoerADmin($dataroomid){
		if($dataroomid > 0){
			return DB::table('projects')->join('user_project', 'projects.id', '=', 'user_project.project_id')
				->select('projects.id as projid', 'projects.name', 'projects.updated_at', 'projects.status as projstatus','user_project.role','user_project.user_id','user_project.dataroom_id')
				->where('user_project.role', 'admin')
				->where('projects.data_room_id', $dataroomid)
				->groupBy('projects.id')
				->orderBy('projects.updated_at', 'desc')
				->get();
		}
		else {
			return DB::table('projects')->join('user_project', 'projects.id', '=', 'user_project.project_id')
				->select('projects.id as projid', 'projects.name', 'projects.updated_at', 'projects.status as projstatus','user_project.role','user_project.user_id','user_project.dataroom_id')
				->where('user_project.role', 'admin')
				->groupBy('projects.id')
				->orderBy('projects.updated_at', 'desc')
				->get();
		
		}
	
	}
	
	public static function getProjectInfoByProjectId($pro_id,$user_id=''){
		$proInfo = array();
		$proAddUser = array();
		$proData= DB::table('projects')->join('user_project', 'projects.id', '=', 'user_project.project_id')
				->join('users', 'user_project.user_id', '=', 'users.id')
				->select('projects.id as projid', 'projects.name', 'projects.company', 'projects.photo', 'projects.description', 'projects.domain_restrict', 'projects.internal_user', 'projects.view_only', 'projects.status as projstatus','user_project.role as addedUserRole','user_project.user_id as addedUser','user_project.id as addedUserId','users.email as addedUserEmail','user_project.dataroom_id')
				//->where('user_project.user_id','<>' ,$user_id)
				->where('projects.id', $pro_id)
				->get();
				
		if($proData){
			foreach($proData as $key=>$pro){
				if($pro->addedUser != $user_id){ 
					$proAddUser[] = array(
						'addemail' => $pro->addedUserEmail,
						'addrole' => $pro->addedUserRole,
						'addtableid' => $pro->addedUserId,
						'addemailid' => $pro->addedUser,
					);
				}
			}
			$proInfo = array(
				'projid'=>$proData[0]->projid,
				'encyptid'=>base64_encode($proData[0]->projid),
				'name'=>$proData[0]->name,
				'company'=>$proData[0]->company,
				'photo'=>$proData[0]->photo,
				'description'=>$proData[0]->description,
				'domain_restrict'=>$proData[0]->domain_restrict,
				'internal_user'=>$proData[0]->internal_user,
				'view_only'=>$proData[0]->view_only,
				'projstatus'=>$proData[0]->projstatus,
				'addedUsersInfo'=>$proAddUser,
				'dataroom_id'=>$proData[0]->dataroom_id,
				'dataroom_id_encypt'=>base64_encode($proData[0]->dataroom_id),
			);
		}	
		return $proInfo;
	}
}
