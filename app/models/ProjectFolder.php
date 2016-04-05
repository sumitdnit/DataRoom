<?php 

class ProjectFolder extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_folder';
    protected $fillable = array('id','folder_name','parent_id','created_at','updated_at');
		
		public static function checkFolder($varFolderID){
			$arrProjectList = ProjectFolder::where('id', $varFolderID)->first();
				if(count($arrProjectList)  >0)
					return true;
				else
					return false;
		}
	
	
}