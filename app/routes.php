<?php
/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */
 
Route::get('/', [
    'as' => 'login',
    'uses' => 'AuthController@getLoginPage'
]);

Route::get('/error', [
    'as' => 'error',
     'uses' => 'UserController@Dashboard'
]);

Route::group(array('before' => 'csrf'), function()
{
    Route::post('login', [
    'as' => 'post-login-credential',
    'uses' => 'AuthController@postLogin'
    ]);
    
    
    Route::post('/create-user', [
    'as' => 'create-user',
    'uses' => 'AuthController@postCreateUser'
    ]);
    
});

Route::get('/sign-up-success/{user_id}', [
    'as' => 'sign-up-success',
    'uses' => 'AuthController@getSuccess'
]);
Route::get('/sign-up', [
    'as' => 'sign-up',
    'uses' => 'AuthController@getSignUp'
]);
Route::get('/general-settings', [
    'as' => 'general-settings',
    'uses' => 'UserController@getGeneralSetting'
]);

Route::post('/update-setting', [
    'as' => 'update-setting',
    'uses' => 'UserController@postUpdateUserProfile'
]);

Route::post('updateprofile-photo', [
    'as' => 'updateprofile-photo',
    'uses' => 'UserController@postProfilePhoto'
]);
Route::get('/verify/{activationcode}', [
    'as' => 'verify',
    'uses' => 'AuthController@getVerify'
]);
Route::get('/forgot-password', [
    'as' => 'forgot-password',
    'uses' => 'AuthController@getForgotPassword'
]);

Route::post('/forgot-password', [
    'as' => 'forgot-password',
    'uses' => 'AuthController@postForgotPassword'
]);
Route::get('/reset-password/{activationcode}/{user_id}', [
    'as' => 'reset-password',
    'uses' => 'AuthController@getResetPassword'
]);
Route::post('reset-password', [
    'as' => 'reset-password',
    'uses' => 'AuthController@postResetPassword'
]);
Route::group(['after'=>'no-cache'], function(){
Route::get('logout', [
    'as' => 'logout-user',
    'uses' => 'AuthController@getLogout'
]);
});


Route::get('/autocomplete', [
    'as' => 'autocomplete',
    'uses' => 'UserController@getUserList'
]);


/*DATAROOM Routes START*/
// For call dataroom view

// route for new view-dataroom page 
Route::get('/dataroom/view-dataroom', [
    'as' => '/dataroom/view-dataroom',
    'uses' => 'DataroomController@getViewDataRoom'
]);

Route::get('/dataroom/view', [
    'as' => 'dataroom',
    'uses' => 'DataroomController@getViewDataRoom'
]);

//use for data room list for users
Route::get('/dataroom/getroomlist', [
    'as' => 'dataroom',
    'uses' => 'DataroomController@getroomlist'
]);

//use for data to open add data room file
Route::get('/dataroom/add', [
    'as' => 'addDataroom',
    'uses' => 'DataroomController@addDataroom'
]);

//Save dataroom info into database
Route::post('/dataroom/save', [
    'as' => 'saveDataroom',
    'uses' => 'DataroomController@saveDataroom'
]);

//Update dataroom to open update form
Route::post('/dataroom/update', [
    'as' => 'saveDataroom',
    'uses' => 'DataroomController@updateDataroom'
]);

//Update dataroom to save update form
Route::post('dataroom/saveupdate', [
    'as' => 'updateDataroom',
    'uses' => 'DataroomController@saveupdateDataroom'
]);

//Update dataroom to delete form
Route::post('dataroom/delete', [
    'as' => 'delete',
    'uses' => 'DataroomController@deleteDataroom'
]);


//Show list for user that share dataroom
Route::post('dataroom/shareto', [
    'as' => 'shareto',
    'uses' => 'DataroomController@shareTo'
]);

//Show list for user that share dataroom
Route::post('dataroom/sharewith', [
    'as' => 'sharewith',
    'uses' => 'DataroomController@shareWith'
]);

//Show list for user that share dataroom
Route::post('dataroom/saveshare', [
    'as' => 'saveshare',
    'uses' => 'DataroomController@saveshare'
]);

//Update dataroom to delete form
Route::post('dataroom/removeUser', [
    'as' => 'removeUser',
    'uses' => 'DataroomController@RemoveUserfromDataRoom'
]);

//Update dataroom to delete form
Route::post('dataroom/invite', [
    'as' => 'inviteUser',
    'uses' => 'DataroomController@inviteUserforDataRoom'
]);

//Update dataroom to delete form
Route::post('dataroom/invitesave', [
    'as' => 'inviteUserSave',
    'uses' => 'DataroomController@inviteUserSave'
]);

Route::get('/auth/user-invite/{user_id}', [
    'as' => 'sign-up-success',
    'uses' => 'AuthController@sendInvite'
]);
/*DATAROOM routes end*/

/*PRJECT Routes START*/
//use for Project room list for users
Route::get('project/usernames/', [
    'as' => 'usernames',
    'uses' => 'ProjectController@getUsernames'
]);
Route::get('/project/getprojectlist', [
    'as' => 'project',
    'uses' => 'ProjectController@getprojectlist'
]);
Route::get('/project/view', [
    'as' => '/project/view',
    'uses' => 'DataroomController@getViewDataRoom'
    //'uses' => 'ProjectController@getProjects'
]);

Route::get('/project/add-project', [
    'as' => '/project/add-project',
    'uses' => 'ProjectController@ProjectCreate'
]);

Route::post('/project/save-project', [
    'as' => '/project/save-project',
    'uses' => 'ProjectController@saveProjects'
]);
Route::post('/project/delete', [
    'as' => '/project/delete',
    'uses' => 'ProjectController@DeleteProject'
]);

Route::get('/project/edit-project', [
    'as' => '/project/edit-project',
    'uses' => 'ProjectController@EditProjectView'
]);
Route::get('/project/edit', [
    'as' => '/project/edit',
    'uses' => 'ProjectController@getEditProjectView'
]);

Route::post('/project/update-project', [
    'as' => '/project/update-project',
    'uses' => 'ProjectController@saveupdateProject'
]);


//Show list for user that share dataroom
Route::post('project/shareto', [
    'as' => 'shareto',
    'uses' => 'ProjectController@shareTo'
]);

//Show list for user that share dataroom
Route::post('project/sharewith', [
    'as' => 'sharewith',
    'uses' => 'ProjectController@shareWith'
]);

//Show list for user that share dataroom
Route::post('project/saveshare', [
    'as' => 'saveshare',
    'uses' => 'ProjectController@saveshare'
]);

/*Project routes end*/

//Update dataroom to delete form
Route::post('project/removeUser', [
    'as' => 'removeUser',
    'uses' => 'ProjectController@RemoveUserfromProjectRoom'
]);

Route::post('project/invite', [
    'as' => 'invite',
    'uses' => 'ProjectController@inviteUserforProject'
]);

Route::post('project/invitesave', [
    'as' => 'invitesave',
    'uses' => 'ProjectController@inviteUserSave'
]);


Route::get('/auth/project-invite/{user_id}', [
    'as' => 'sign-up-success',
    'uses' => 'AuthController@sendInvite'
]);

Route::get('dataroom/usernames/', [
    'as' => 'usernames',
    'uses' => 'DataroomController@getUsernames'
]);

Route::get('dataroom/usernames/{UserListing}', [
    'as' => 'usernames',
    'uses' => 'DataroomController@getUsernames'
]);

Route::post('profile-photo', [
    'as' => 'profile-photo',
    'uses' => 'DataroomController@postPhoto'
]);
/*Project routes end*/


/* Folder controller routes*/

Route::get('users/folder', [
    'as' => 'folder',
    'uses' => 'FolderController@listFolder'
]);
/*
*For resend mail to not activated user.
*28//04/16
*@krrish
*/
Route::post('users/revokeuser', [
    'as' => 'revokeMail',
    'uses' => 'UserController@revokeUser'
]);

Route::post('users/savefolder', [
    'as' => 'savefolder',
    'uses' => 'FolderController@saveFolder'
]);

Route::get('users/getUserProject', [
    'as' => 'getUserProject',
    'uses' => 'FolderController@getUserProject'
]);


Route::post('users/geteditfolder', [
    'as' => 'geteditfolder',
    'uses' => 'FolderController@getEditFolder'
]);

Route::post('users/getupdatefolder', [
    'as' => 'getupdatefolder',
    'uses' => 'FolderController@getupdatefolder'
]);


Route::post('users/deletefolder', [
    'as' => 'deletefolder',
    'uses' => 'FolderController@deleteFolder'
]);

Route::post('project-photo', [
    'as' => 'project-photo',
    'uses' => 'ProjectController@postProjectPhoto'
]);
Route::get('project/useremails/', [
    'as' => 'useremails',
    'uses' => 'ProjectController@getUserEmails'
]);

Route::get('users/getProjectInfo', [
    'as' => 'getProjectInfo',
    'uses' => 'FolderController@getProjectInfo'
]);

Route::get('/user/listfolders', [
    'as' => 'listfolders',
    'uses' => 'FolderController@listfolders'
]);

Route::get('/change-password', [
    'as' => 'change-password',
    'uses' => 'UserController@getChangePassword'
]);

Route::post('/change-password', [
    'as' => 'change-password',
    'uses' => 'UserController@postChangePassword'
]);

Route::get('/showfiles', [
    'as' => 'showfiles',
    'uses' => 'FolderController@showfiles'
]);

Route::post('/renamefiles', [
    'as' => 'renamefiles',
    'uses' => 'FolderController@renamefiles'
]);

Route::get('/download', [
    'as' => 'download',
    'uses' => 'FolderController@download'
]);

Route::post('/deletefiles', [
    'as' => 'deletefiles',
    'uses' => 'FolderController@deletefiles'
]);

Route::post('/upload-file', [
    'as' => 'upload-file',
    'uses' => 'FolderController@uploadFile'
]);
/* End folder controller */

Route::get('/users', [
    'as' => 'users',
    'uses' => 'UserController@listUsers'
]);

Route::get('/usersdesc', [
    'as' => 'usersdesc',
    'uses' => 'UserController@listDiscUsers'
]);

Route::post('/usersdetails', [
    'as' => 'usersdetails',
    'uses' => 'UserController@UsersDetails'
]);


Route::post('/userssave', [
    'as' => 'userssave',
    'uses' => 'UserController@UsersSaves'
]);

//Update dataroom to delete form
Route::post('userdelete', [
    'as' => 'userdelete',
    'uses' => 'UserController@deleteUser'
]);

//leave user detail
Route::get('/userdetail', [
    'as' => 'userdetail',
    'uses' => 'UserController@UserInfo'
]);

//leave user project

Route::post('/leaveproject', [
    'as' => 'leaveproject',
    'uses' => 'UserController@leaveProject'
]);

//leave user data room

Route::post('/leavedataroom', [
    'as' => 'leavedataroom',
    'uses' => 'UserController@leaveDataroom'
]);

//Copy content from dataroom to files and folders
Route::post('copydataroom', [
    'as' => 'copydataroom',
    'uses' => 'DataroomController@CopyDataRoom'
]);

//Copy content from dataroom to files and folders
Route::post('copyproject', [
    'as' => 'copyproject',
    'uses' => 'ProjectController@CopyProject'
]);

// SET language changer action
// Developed by kapil

Route::get('/language', 
		array(
			'as' => 'language', 
			'uses' => 'LanguageController@select'
		)
  );
  
Route::post('copyfile', [
    'as' => 'copyfile',
    'uses' => 'FolderController@copyFile'
]);  
  
Route::post('sharefile', [
     
    'uses' => 'FolderController@shareFile'
]);  
