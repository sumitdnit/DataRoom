<?php 

class FolderRelation extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'folder_relation';
    protected $fillable = array('id','folder_id','user_id', 'role','dataroom_id','project_id','created_at','updated_at');
	
		public static function getFolders($varRoomID,$projectId,$userid){
			return DB::table('folder_relation')
				->join('project_folder', 'project_folder.id', '=', 'folder_relation.folder_id')
				->select('folder_relation.*', 'project_folder.*', 'project_folder.id as folderid','project_folder.created_at as foldercreated','project_folder.updated_at as folderupdated')
				->where('folder_relation.dataroom_id', $varRoomID)
				->where('folder_relation.project_id', $projectId)
				->where('folder_relation.user_id', $userid)
				->get();
		}
		
		public static function getFolderDetail($varFolderID){
			return DB::table('folder_relation')
				->join('project_folder', 'project_folder.id', '=', 'folder_relation.folder_id')
				->select('folder_relation.*', 'project_folder.*', 'project_folder.id as folderid','project_folder.created_at as foldercreated','project_folder.updated_at as folderupdated')
				->where('folder_relation.folder_id', $varFolderID)
				->first();
		}
	
}