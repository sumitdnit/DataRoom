<?php 

class ProjectFolder extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_folder';
    protected $fillable = array('id','folder_name','parent_id','created_at','updated_at');
    public $deletedID=array(); //store id to delete file
    public $folderPath=''; // recursive path
    
	/**
	* Check folder exists or not
	* @author  Pankaj	*
	* @var $varFolderID folderid
	* @return boolean
	*/	
	public static function checkFolder($varFolderID){
		try{
			$arrProjectList = ProjectFolder::where('id', $varFolderID)->first();
				if(count($arrProjectList)  >0)
					return true;
				else
					return false;
		}catch(Exception $e){
				return false;
			
		}
	}
    
	/**
	* Return all files on basis of folder id
	* @author  Pankaj	*
	* @var $varFolderID folderid
	* @return array of files
	*/	
	public function getFiles($varFolderID,$roleObj,$user){
		$filesarr=array();
		try{
			
			$files = DB::table('files')
            ->leftJoin('profiles', 'files.created_by', '=', 'profiles.user_id')            
            ->select('files.*', 'firstname', 'lastname')->where('folder_id',$varFolderID)
            ->orderBy('files.updated_at', 'DESC')->get();
						
			if($files && count($files)>0){
				$i=0;
				foreach($files as $fls){
						
						if($roleObj=='upload'){
								
								if($fls->created_by==$user->id){
									$access=1;	
								}
						}
						
						$filesarr[$i]['id']=base64_encode($fls->id);
						$filesarr[$i]['coded']=md5($fls->id);
						$filesarr[$i]['roleaccess']="$access";
						$filesarr[$i]['namewext']=substr($fls->alias,0,(strlen($fls->ext)+1)*-1);
						$filesarr[$i]['code']=($fls->id);
						$filesarr[$i]['ext']=($fls->ext);
						$filesarr[$i]['extcss']=($fls->ext=='3gp') ? 'a3gp': $fls->ext;
						
						$filesarr[$i]['user']=$fls->firstname . ' ' . $fls->lastname ;
						$filesarr[$i]['name']=$fls->alias;
						$filesarr[$i]['dated']= date('m/d/Y | h:i A',strtotime($fls->updated_at));
						$filesarr[$i++]['role']=$roleObj;
				}
			}
			return $filesarr;
		}catch(Exception $e){
				return $filesarr;
			
		}
	}
		
	/**
	* Recursive function to fetch array for folder
	* @author  Pankaj	
	* @var $parent_id parent, $roleObj role
	* @return array of all folder
	*/			
	public function getCategoryTreeForParentId($parent_id = 0,$roleObj) {
		$categories = array();
		try{		  
		  $result=ProjectFolder::where('parent_id',$parent_id)->get();
		  
		  foreach ($result as $mainCategory) {
				$category = array();
				$category['text'] = $mainCategory->alias;
				$category['id']=base64_encode($mainCategory->id);			
				$access=0;
				if($roleObj=='upload'){
					if($mainCategory->created_by==$this->user->id){
						$access=2;	
					}else{
							$access=1;	
					}
				}elseif($roleObj=='admin'){
				  $access=2;	
				}					
				$category['access']=$access;
				$returnrs = $this->getCategoryTreeForParentId($mainCategory->id,$roleObj);
				if($returnrs && count($returnrs)>0){
					$category['nodes']=$returnrs;
				}
				$categories[$mainCategory->id] = $category;
		  }
		  return $categories;
		}catch(Exception $e)	{
			return $categories;
		} 
	}
	
	
	/**
	* Recursive function to get folder path
	* @author  Pankaj	
	* @var $folder
	* @return return path in variable global folderPath
	*/		
	public function getPath($folder){
		try{
			if($folder==0){ 
				$this->folderPath .='';
			}else{
					$folderObj=ProjectFolder::where('id',$folder)->first();
					if($folderObj && count($folderObj)>0){
						$this->folderPath .=$folderObj->id .'/';
						if($folderObj->parent_id>0){
							 //$this->folderPath .=$folderObj->folder_name .'/';
							$this->getPath($folderObj->parent_id);
						}
					}
			}
		 }catch(Exception $e){
			 
		 }
			
	}

	
	/**
	* Recursive function to remove folder structure
	* @author  Pankaj	
	* @var $path
	* @return true on removal of directory or file
	*/	
	public function removeDirectory($path) {
		try{
			$files = glob($path . '/*');
			foreach ($files as $file) {
				is_dir($file) ? $this->removeDirectory($file) : unlink($file);
			}
			if($path!= public_path().'/public/folders'){
				rmdir($path);
			}
			return true;
		}catch(Exception $e)	{
				return false;
		}
	}
	
	/**
	* Function to check access for file
	* @author  Pankaj	
	* @var $varFolderID
	* @return boolean
	*/		
	public function checkValidFiles($fid){
		try{
			$files=Files::where('id',$fid)->first();
			return (!$files || count($files)==0)? false:$files;
			
		}catch(Exception $e)	{
				return false;
		}	
	}	
	
	/**
	* Function to check access foe folder
	* @author  Pankaj	
	* @var $varFolderID
	* @return boolean
	*/		
	public function checkValidFolder($varFolderID){
		try{
			$folders= ProjectFolder::where('id',$varFolderID)->first();
			return (!$folders || count($folders)==0)? false: $folders;				
			
		}catch(Exception $e)	{
				return false;
		}	
	}	
	
	/**
	* Get folder exact path for project
	* @author  Pankaj	
	* @var $varFolderID
	* @return boolean
	*/		
	public function getFolderStructure($varFolderID){
		
		$revpath='';
		$folderstructure=array();
		try{
			$this->folderPath='';
			$this->getPath($varFolderID);
			$paths=explode('/',$this->folderPath);
			
			if($paths && count($paths)>0){
				for($i=count($paths)-1 ; $i>=0;$i--){
					  if($paths[$i]){
						   $revpath .=$paths[$i].'/';
						   $folderstructure[]=$paths[$i];
					  }	   
				}
			}
			return array($revpath,$folderstructure);
		
			
		}catch(Exception $e)	{
				return array($revpath,$folderstructure);
		}	
	}	
	
	/**
	* Function to check access
	* @author  Pankaj	
	* @var $projectID
	* @return boolean
	*/		
	public function checkValidProject($projectID,$user){
	 try{	
		$project= Project::where('id',$projectID)->first();
		if(!$project || count($project)==0){
			return false;
		}
		if($user->usertype!='admin'){
			$usrProject=UserProject::where('project_id',$projectID)->where('user_id',$user->id)->first();			
			if(!$usrProject || count($usrProject)==0) return false;
			
		}
		return $project;
	  }catch(Exception $e){
		  return false;  
	  }
	}	
	
	/**
	* Recursive function to remove folder from DB
	* @author  Pankaj	
	* @var $id as folder id
	* @return true on removal of directory or file from DB
	*/		
	public function deleteRecursive($id){
		try{
			$par=ProjectFolder::where('parent_id',$id)->get();
			if($par && count($par)>0){
				foreach($par as $pr){
					$this->deletedID[]=$pr->id;
					$this->deleteRecursive($pr->id);
				}
			}
		}catch(Exception $e)	{
				return false;
		}
		
	}
	
	/**
	* Return role to for project on basis of override
	* @author  Pankaj	
	* @var $roleView as project object, $user=current user obj
	* @return true on removal of directory or file from DB
	*/		
	public function getRoles($roleView,$user){		
	 try{
		 if($user->usertype=="admin") {
				
				$roleObj='admin';
				$visible=1;
				
			}else{
				
						$dataRoomID=$roleView->data_room_id;
						$datObj=Dataroom::where('id',$dataRoomID);
						if($datObj->view_only==1){
							$roleObj='view';
							$visible=0;
						}else{
							
							if($roleView->view_only == 1){
								$roleObj="view";
								$visible=0;
							}else{
								 
								$role=UserProject::where('project_id',$roleView->id)->where('user_id',$user->id)->first();	
								 
								if($role && count($role)>0){
								
											if($role->role=='admin'){
												$roleObj=$role->role;
												$visible=1;
											}else if($userrole=='download'){
												$roleObj=$role->role;
												$visible=2;
											}else if($userrole=='upload'){
												$roleObj=$role->role;
												$visible=3;
											}else{
												$roleObj=$role->role;
												$visible=0;
											}
									}
							}						
						}
				}
				
				return array($roleObj,$visible);
		}catch(Exception $e){
			return array('view','0');
		}
	}
	
	
	
}
