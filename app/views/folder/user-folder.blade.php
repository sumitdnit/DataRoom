@extends('layouts.protected')
@section('content')
	
<style>
.showhide{display:none;}
.show{display:block;}

.editUpdatePrj { float:right; display:block !important; margin-left:15px;}
.editUpdatePrj a {font-size:14px; color:#333;}
.editUpdatePrj .fa { margin-left:10px;}
.selectedData {color:#00a6bb; font-weight:bold;}

.file-data.option-list:nth-child(even) a {
     background: none!important;
}

.listview .utility-box{
	width:177px;
	right:0;
	}
	
.file-data .utility-popup {
    right: 0;
}	

#create-folder-file .dashboard-draggable-menu{font-size:14px}

.folderdropdown  p { display:block;font-size:14px;}
	
.grdview .file-data .utility-popup {
    right: -300px;
}	

#create-folder-file .file-upload{border-bottom:0}
.folderdropdown select{width:200px}

.second-header .breadcrumb-header{max-width: 100%; padding:12px 0 10px 0px }
.breadcrumb-header dl:first-child {
    font-weight: 600;
}

.breadcrumb-header dl:first-child:before {
    content: ': :';
    padding-right: 10px;
}
.breadcrumb-header dl:after {
    content: '/';
    padding: 0 3px 0 8px;
}
breadcrumb-header dl:last-child, .breadcrumb-header dl.blue {
    font-weight: 600;
    color: #1179ad;
}
.breadcrumb-header dl {
    display: inline;
}

.breadcrumb-header dl:last-child:after {
    content: '';
}
.second-header {
    width: 100%;
    height: 147px;}
    
#create-folder-file .dashboard-draggable-menu{top:123px}

#create-folders.main-config {
    margin-top: 210px;
}

.caret-post.closed {
	background: url(<?php echo URL::to('/')?>/assets/img/curret-post.jpg) no-repeat;
	display:block!important;
	
}	
.caret-post {
    background: url(<?php echo URL::to('/')?>/assets/img/curret-post-focus.jpg) no-repeat;
    margin-bottom: 0;
    margin-left: 463px;
    width: 32px;
    height: 23px;
    display: block;
    position: absolute;
    bottom: -4px;
}

.second-header .closed{
	display:none;
}

.second-header .open{
	display:block;
}

</style>
<div ng-app="ravabe" ng-controller="folderCtrl" id="crtlid">
 <!-- Second Header -->
    <div class="second-header" >
        <div class="breadcrumb-header">
           
            <dl><a href="<?php echo URL::to('/') ?>/dataroom/view">Dataroom</a></dl>
            <dl><a href="<?php echo URL::to('/') ?>/project/view">Project</a></dl>
            
           
        </div>
        
         <div class="select-dataroomList clearfix" id="collapseOne"  >
						<div class="col-lg-12 col-md-12 col-sm-12">							
								<div class="addDropdown folderdropdown clearfix">
									<section>
								<p>Select Dataroom</p>
								<select id="userOrganization" ng-change="getProject()" ng-model="org.orgId" class="form-control">
										<option value="0" >-Select Dataroom-</option>
										@if($data['dataroom']!=null)
											@foreach($data['dataroom'] as $key=>$alert)
										<option value="{{$alert->roomid}}">{{ $alert->name }}</option>
										  @endforeach
										@endif	
								</select>
								</section>

								<section>
								<p>Select Project</p>
								<select  ng-change="showFolders()"  ng-model="org.project_id" id="userProject" class="form-control" >
										<option value="0">-Select Project-</option>
										@if($data['projects']!=null)
											@foreach($data['projects'] as $key=>$alert)
											<option value="{{$alert->projid}}">{{ $alert->name }}</option>
										  @endforeach
										@endif
								</select>
								</section>
								</div>
							</div>
						</div>
        <a class="caret-post"></a>
        
		<div class="content-header" style="display:none">
          <section>
            <p>A-Z</p>
            <select class="form-control">
              <option value="Select">Select</option>
            </select>
          </section>
            
            <section>
                <p>Last Update</p>
                <select class="form-control">
                    <option value="Select">Select</option>
                </select>
            </section>
            
        </div>

    </div>

    <!-- End of Second Header -->

	  	   
    <div id="create-folders" style="pointer-events:none; opacity:0.5" class="main main-config main-drag">
		<div class="files-edit">
				<div class="col-md-12 col-left uploadonly"  style="pointer-events:none; opacity:0.5">
					<input  type="file" size="30" id="filebtnupload" name="files_multiple[]"  style="position: absolute;top: 29px;left: 100px;opacity: 0;cursor:anchor" />
                    <div onclick="$('#filebtnupload').click()"  id="file-uploader" class="file">

                        <div class="row">


						 <div  class="drag-n-drop-box box-drop-img">
                                    <div class="drag-n-drop">
                                       
                                       <div class="drag-box">
                                        <!-- Generator: Adobe Illustrator 18.0.0, SVG Export Plug-In  -->
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="48.1px" height="42.8px" viewBox="0 0 48.1 42.8" enable-background="new 0 0 48.1 42.8" xml:space="preserve">
                                            <defs>
                                            </defs>
                                            <g>
                                                <polyline fill="none" stroke="#C7C5C6" stroke-miterlimit="10" points="33.5,23.9 5.7,23.9 5.7,0.5 37.3,0.5 37.3,22.2     "></polyline>
                                                <circle fill="none" stroke="#C7C5C6" stroke-miterlimit="10" cx="14" cy="6.9" r="3.2"></circle>
                                                <polyline fill="none" stroke="#C7C5C6" stroke-miterlimit="10" points="5.7,20.8 12.9,13.6 17.3,18 28.5,6.8 37.3,15.6     "></polyline>
                                                <g>
                                                    <g>
                                                        <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="37.3" y1="8.4" x2="39.3" y2="8.4"></line>

                                                        <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" stroke-dasharray="2.1042,2.1042" x1="41.4" y1="8.4" x2="44.5" y2="8.4"></line>
                                                        <polyline fill="none" stroke="#C7C5C6" stroke-miterlimit="10" points="45.6,8.4 47.6,8.4 47.6,10.4           "></polyline>

                                                        <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" stroke-dasharray="4.2768,4.2768" x1="47.6" y1="14.7" x2="47.6" y2="38.2"></line>
                                                        <polyline fill="none" stroke="#C7C5C6" stroke-miterlimit="10" points="47.6,40.3 47.6,42.3 45.6,42.3             "></polyline>

                                                        <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" stroke-dasharray="3.9148,3.9148" x1="41.6" y1="42.3" x2="4.5" y2="42.3"></line>
                                                        <polyline fill="none" stroke="#C7C5C6" stroke-miterlimit="10" points="2.5,42.3 0.5,42.3 0.5,40.3            "></polyline>

                                                        <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" stroke-dasharray="4.2768,4.2768" x1="0.5" y1="36" x2="0.5" y2="12.5"></line>
                                                        <polyline fill="none" stroke="#C7C5C6" stroke-miterlimit="10" points="0.5,10.4 0.5,8.4 2.5,8.4          "></polyline>
                                                        <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="3.6" y1="8.4" x2="5.6" y2="8.4"></line>
                                                    </g>
                                                </g>
                                                <polygon fill="none" stroke="#C7C5C6" stroke-miterlimit="10" points="37.7,27.7 35.8,31.2 32.4,19.5 43.2,25.4 39.5,26.5 
        42.7,29.5 41.3,31.1     "></polygon>
                                                <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="33.4" y1="15.9" x2="33.4" y2="13.9"></line>
                                                <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="37.7" y1="20.4" x2="39.7" y2="20.4"></line>
                                                <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="26.8" y1="20.2" x2="28.8" y2="20.2"></line>
                                                <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="36.5" y1="17.2" x2="37.9" y2="15.8"></line>
                                                <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="28.7" y1="24.8" x2="30.1" y2="23.4"></line>
                                                <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="28.8" y1="15.7" x2="30.2" y2="17.1"></line>
                                                <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="35.1" y1="16.2" x2="35.8" y2="14.4"></line>
                                                <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="30.7" y1="26.2" x2="31.5" y2="24.4"></line>
                                                <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="27.4" y1="17.8" x2="29.2" y2="18.5"></line>
                                                <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="37.4" y1="18.7" x2="39.3" y2="18"></line>
                                                <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="27.3" y1="22.7" x2="29.1" y2="21.9"></line>
                                                <line fill="none" stroke="#C7C5C6" stroke-miterlimit="10" x1="30.9" y1="14.3" x2="31.7" y2="16.2"></line>
                                            </g>
                                        </svg>
                                        <h4>Drag &amp; Drop</h4>
                                        </div>
                                    </div>
                                </div>
                           

                         
							
                        </div>
						<div  class="progress">
							<div class="progress-bar progress-bar-success" style="width: 0%;"></div>
						</div>
                    </div>
                    <div class="row">
				   <div class="col-md-12 list-menu">
						<a class="gridview-btn" href="#"><img src="<?php echo URL::to('/')?>/assets/images/list1-icon.png"></a>
						<a class="listview-btn" href="#"><img src="<?php echo URL::to('/')?>/assets/images/list2-icon.png"></a>
					</div>
					
					<div style=" width: 85%; margin: 0 auto;margin-top: 61px;" ng-show="org.project_id!=0  && org.orgId!=0 && filesdata.length==0" class="alertwarning"><p class="alert alert-danger">No files found!</p></div>
					</div>
               
                </div>
									
		</div>
			
            <div class="files-content">
				<div class="file-data option-list listview"  ng-repeat="values in filesdata">
					<a  href="javascript:void(0)" style="padding-left: 0;">
						<div class="userdatafile"><img src="<?php echo URL::to('/')?>/assets/images/file-data.jpg"></div>
						<span><% values.name %></span>
						
						<span class="status" style="display:block">Best Version</span>
						<span class="update_timeday">Update: <% values.dated %></span>
						<span  style="float: right;padding-right: 7px;display: inline-block;">	
							<i class="fa fa-cog"></i>											
						</span>
					</a>
					<div class="utility-box" >
						<ul>
							<li style="text-align: left;" ng-show="values.role=='admin'" ng-click="deleteFile(values.id)" class="editutility"><a style="text-align: left;" href="javascript:void(0)"> <i class="fa fa-times"></i> Delete</a></li>
							<li style="text-align: left;" ng-show="values.role=='admin'"    class="editutility editbtn"><a style="text-align: left;" href="javascript:void(0)"> <i class="fa fa-pencil-square-o"></i> Edit</a></li>
							<li style="text-align: left;" ng-show="values.role=='admin' || values.role=='download'"      class="editutility"><a style="text-align: left;" href="<?php echo URL::to('/')?>/download?file=<% values.id %>"> <i class="fa fa-download"></i> Download</a></li>
							 
						</ul>
					</div>
					<div class="utility-popup cutility clearfix" >
						<div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>
						<div class="utility-popup-title">Rename File </div>
						<hr>
						<div class="fldr-title">File Name:</div>
						<div class="fldrsubmitTxt">
							<div class="submitnameFolder"><input id="renametxt_<% values.code %>" style="border:0" class="renamedtest" type="text" value="<% values.name %>" /></div>
						</div>						
						<button ng-click="renameFile(values.code,values.id)" class="btn btn-lg btn-primary btn-red pull-right utilitybtn" type="button">Save</button>
				</div>
				</div>
				
				
				
            </div>
    
    
    </div>

    
	<!-- Dashbord Draggable Menu -->
	<div id="create-folder-file">
		<div class="dashboard-draggable-menu dashboard-draggable-menu-open">
			<a href="#" class="draggable-menu-action-dashboard">
				
			</a>
        <a href="#" class="draggable-menu-action-dashboard-mobile">
           
        </a>
        <div class="container-fluid content dashboard-draggable-menu-content dashboard-draggable-content-open">
        
       
            <div class="content-header" style="position:relative;pointer-events:none;opacity:0.5">
                <div class="file-upload">
                    <div class="btn-box">
                        <button ng-click="cleartexts()" type="button" data-toggle="modal" id="OpenmyModal" data-target="#myModal">New Folder</button>
                    </div>
						
          <!-- Modal -->
        <div class="modal "  id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content idea-detail-modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
										<div style="display:none;" class="output alert alert-dismissible">
											
											<div class="message-list"></div>
										</div>
										
                    <div class="idea-detail-header">

                        <div class="left message">
                            <h4 class="headcls" >Create new folder</h4>
                            
                        </div>
						
						<div class="left clear" >
                          							
                          							
								<p style="display:none" class="alert alert-danger error showhide foldererror"></p>								
								<p  ng-show="org.currentrole!='admin'"  class="alert alert-danger">You have not access to create or update folder </p>								
                          							
                        </div>
                        <div class="clear"></div>
                        <div style="font-size: 14px;    margin: 16px 0;"><b>Parent Folder : </b> <span class="parfolder"><% org.parfolder %></span> <small class="descp"><a style="color:#23527c" href="javascript:void(0)" onClick="$('.showchanges').show()">(Change)</a></small></div>
                        <div class=" showchanges alert alert-info " style="display:none">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
							To change parent folder you need to click on folder in left side and then click on 'New Folder' .
						</div>
                        <div class="clear"></div>
                        <input ng-show="org.currentrole=='admin'" ng-model="org.projectfolder"  type="text" name="projectfolder" id ="projectfolder" placeholder="Name Folder" required>
                        
                        <div class="clear"></div>
                        <button  ng-show="org.currentrole=='admin'" ng-click="createFolder()" class="btn create-folder" >Create</button>
                        
                         
                        <div class="createfolderloader" style="display:none;
							    position: relative;    text-align: right;    margin-top: 8px;"><img src="<?php echo URL::to('/')?>/assets/images/loader.gif" style="
							width: 41px;
						"></div>
                    </div>

                </div>
            </div>
        </div>
				
				<!--<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="display: none;">-->
	
				<div  style="display:none" class="search-area" style="pointer-events:none;opacity:0.9">
					<div class="search">
						<input type="text" placeholder="Search">
						<!-- Generator: Adobe Illustrator 18.0.0, SVG Export Plug-In  -->
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="20.2px" height="20.2px" viewBox="0 0 20.2 20.2" enable-background="new 0 0 20.2 20.2" xml:space="preserve">
								<defs>
								</defs>
								<path fill="#C5C3C4" d="M11.7,0C7.1,0,3.3,3.8,3.3,8.4c0,1.8,0.6,3.5,1.6,4.9L0.1,18c-0.2,0.2-0.2,0.4,0,0.6l1.5,1.5
					c0.2,0.2,0.4,0.2,0.6,0l4.8-4.8c1.4,1,3,1.5,4.8,1.5c4.7,0,8.4-3.8,8.4-8.4S16.4,0,11.7,0z M11.7,14.4c-3.3,0-5.9-2.7-5.9-5.9
					s2.7-5.9,5.9-5.9s5.9,2.7,5.9,5.9S15,14.4,11.7,14.4z"></path>
						</svg>


					</div>
				</div>



                </div>
            </div>
						
					
						
            <div class="activity-cards ravabe-skin-sm  strucFolder" style="    height: 380px;   overflow: auto;">
				<div style=" width: 85%; margin: 0 auto" ng-show="org.project_id==0  && org.orgId==0" class="alertwarning"><p class="alert alert-danger">Please select Organization & Project to create or list all folders & file.</p></div>					
				<div style=" width: 85%; margin: 0 auto" ng-show="org.project_id==0  && org.orgId!=0" class="alertwarning"><p class="alert alert-danger">Please select Project to create or list all folders & file.</p></div>					
				
				<ul ng-show="org.project_id!=0 && org.orgId!=0" id="tree2" class="navigatin-folders">
					
				</ul>	
				
            </div>
        </div>
        <!-- End of Dashbord Draggable Menu -->
    </div>
</div>
	
</div>	
	
<script src="<?php echo URL::to('/')?>/assets/js/jquery.fileupload/js/jquery.iframe-transport.js"></script>	
<script src="<?php echo URL::to('/')?>/assets/js/jquery.ui.widget.js"></script>		
<script src="<?php echo URL::to('/')?>/assets/js/jquery.fileupload/js/jquery.fileupload.js"></script>
<script src="<?php echo URL::to('/')?>/assets/js/jquery.fileupload/js/jquery.fileupload-process.js"></script>
<script src="<?php echo URL::to('/')?>/assets/js/jquery.fileupload/js/jquery.fileupload-validate.js"></script>	
<script type="text/javascript">
var URL='<?php echo URL::to('/')?>';			
ravabe.controller("folderCtrl", function($rootScope,$scope, $http,$compile) {
	$scope.org={};
	$scope.filesdata={};
	$scope.org.orgId='<?php echo $data['dataroomid'] ?>';
	$scope.org.project_id='<?php echo $data['projectid'] ?>';	
	
	$scope.org.currentrole='';
	$scope.org.filerole='0';
	$scope.org.fileParent='0';
	$scope.org.parfolder='Root';
	$scope.org.parfolderid='0';
	$scope.org.projectfolder='';
	$scope.org.isupdate='0';
	
		
	$scope.createFolder = function (e){
		$('.showhide').html(''); 
		$('.showhide').hide();
		if($scope.org.currentrole!='admin'){
			$('.showhide').html('You have not access to create folder!!'); 
			$('.showhide').show(); return false;
		}
		if($scope.org.projectfolder==''){
			$('.showhide').html('Please enter folder name!!'); 
			$('.showhide').show(); return false;
		}
		
		$('.create-folder').hide();
		$('.createfolderloader').show();
		$('#crtlid,#projectfolder').css('pointer-events','none');
		
		
		
		if($scope.org.isupdate=='0'){
			
		   var uri= URL+"/users/geteditfolder";
		   var params ={ folderId:$scope.org.parfolderid, foldername:$scope.org.projectfolder, projectID:$scope.org.project_id};
		   
		}else{
			
			var uri= URL+"/users/getupdatefolder";
			var params ={ folderId:$scope.org.isupdate, foldername:$scope.org.projectfolder, projectID:$scope.org.project_id};
			
		}	
		$http({
		  method: 'post',
		  url: uri,
		  data: params
		}).success(function(response, status) {
			
			if(response.flag==0){
				
				$('#crtlid,#projectfolder').css('pointer-events','all');
				
				var uri=URL+"/user/listfolders?projectID="+ $scope.org.project_id + "&role="+$scope.org.currentrole;
			
				$http.get(uri).success(function(data, status) {
						
						//var data=eval('('+ datares +')');
						$scope.org.filerole=data.visiblility;					
						$('#tree2').html($compile(data.folder)($scope));	
						$('#tree2').treed({openedClass:'open-folder-icon', closedClass:'close-folder-icon'});
						 if ($('#tree2').find('p').hasClass('alert-danger')){ 
							 $scope.org.fileParent=0;
							
						}else{
							for(var i in response.folder)
							{
								  $('#tree2 #list_'+ response.folder[i] + ' a').first().click();
							}
							 
						}
						
	
				});	
				toastr.options = {"positionClass": "toast-top-center"};	
				toastr["success"]("Folder has been saved successfully!");
				$('#myModal .close').click();
				
			}else{
				
				$('.create-folder').show();
				$('.createfolderloader').hide();
				$('#crtlid,#projectfolder').css('pointer-events','all');
				$('.showhide').html(response); 
				$('.showhide').show(); return false;
				
			}
			
		  });
		
		
		
	},	
	
	$scope.seteditparent = function (id,name,text){
		 
			$scope.org.parfolder=name;
			$scope.org.parfolderid='';
			$scope.org.projectfolder=text;
			$scope.org.isupdate=id;
			
	},	
	
	$scope.deletedFolder = function (id){
		
		$http({
		  method: 'post',
		  url:  URL+"/users/deletefolder",
		  data: { folderId:id}
		}).success(function(response, status) {
			toastr.options = {"positionClass": "toast-top-center"};	
			if(response.flag==-1){
				toastr["error"]("Folder not found to deleted!");	
			}else if(response.flag==-2){
				toastr["error"]("Unauthorized access!!");
			}else{	
				$scope.filesdata={};
				var uri=URL+"/user/listfolders?projectID="+ $scope.org.project_id + "&role="+$scope.org.currentrole;			
				$http.get(uri).success(function(data, status) {
						
						//var data=eval('('+ datares +')');
						$scope.org.filerole=data.visiblility;					
						$('#tree2').html($compile(data.folder)($scope));	
						$('#tree2').treed({openedClass:'open-folder-icon', closedClass:'close-folder-icon'});
						 if ($('#tree2').find('p').hasClass('alert-danger')){ 
							 $scope.org.fileParent=0;
							
						}else{
							for(var i in response.folder)
							{
								  $('#tree2 #list_'+ response.folder[i] + ' a').first().click();
							}
						}		
				});
				
				toastr["success"]("Folder has been deleted successfully!!");
				
			}
			
				
			
		});	
	 
		
	},	
	$scope.setparent = function (id,name){
		  $('.idea-detail-header message,.headcls').html('Create Folder');
		$('.create-folder').html('Create');
		$('.descp').show();
			$scope.org.parfolder=name;
			$scope.org.parfolderid=id;
			$scope.org.projectfolder='';
			
	},	
	$scope.resetparent = function (e){
		
		$('.idea-detail-header message,.headcls').html('Create Folder');
		$('.create-folder').html('Create');
		$('.descp').show();
		
		$('.showchanges').hide();
		$('.showhide').hide();
		$scope.org.parfolder='Root';
		$scope.org.projectfolder='';
		$scope.org.parfolderid='0';
		$scope.org.isupdate='0';
		$('.create-folder').show();
		$('.createfolderloader').hide();
		$('#crtlid,#projectfolder').css('pointer-events','all');
		//$('.parfolder').html($scope.org.parfolder);
	},	
	$scope.getProject = function (e){
		$scope.filesdata={};
		if($scope.org.orgId==0 ){
			 //$scope.org.project_id=0;
			 $('.content-header,.search-area').css('pointer-events','none');
			 $('.content-header').css('opacity','0.5');
			 $("#userProject").find('option:gt(0)').remove();
			 $scope.org.currentrole='';
			 $('.overview ul').html('');
			 $('.breadcrumb-header').html('<dl><a href="'+ URL +'/dataroom/view">Dataroom</a></dl><dl><a href="'+ URL +'/project/view">Project</a></dl>');
			 return false;
			
		}
		$('.breadcrumb-header').html('<dl><a href="'+ URL +'/dataroom/view">'+ $("#userOrganization option:selected").text()  +'</a></dl>');
		var uri=URL+"/users/getUserProject?drId="+ $scope.org.orgId;
		
		$http.get(uri).success(function(data, status) {
			$scope.org.project_id=0; 
			$("#userProject").find('option:gt(0)').remove();
			$.each(data,function(i,proj){
				$("#userProject").append('<option value="'+proj.projid+'">'+proj.name+'</option>');
			});
			
			
		});
	};
	
	$scope.getFilesParent = function (e){
		
		
		return $scope.org.fileParent;
	},	
	
	$scope.getFilesAccess = function (e){
		if($scope.org.orgId==0 || $scope.org.project_id==0){
		  return -1;	
		}
		
		if($scope.org.fileParent==0){
		  return -2;	
		}
		
		return $scope.org.filerole;
	},	
	$scope.renameFile = function (e,t){
		 
		if($.trim(e)!==''){
			
			var text=$('#renametxt_'+e).val();
			
			if($.trim(text)==""){
				
				
						toastr["error"]("Please enter filename with extension");return false;
				
				
			}else{
			
				var uri=URL+"/renamefiles";	
				$http.post(uri,{files:text, fid:t}).success(function(data, status) {
					 if(data.status=='error')	{
						 toastr[data.status](data.message);
					 }else{
						 toastr["success"]("Files has been renamed successfully");
						 $scope.showFiles($scope.org.fileParent);
					}
				});
				
			}
			
			
			
		}
		
	},	
	$scope.deleteFile = function (e){
		 
		if($.trim(e)!==''){
				var uri=URL+"/deletefiles";	
				$http.post(uri,{fid:e}).success(function(data, status) {
					 if(data.flag=='error')	{
						 toastr[data.status](data.message);
					 }else{
						 toastr["success"]("Files has been deleted successfully");
						 $scope.showFiles($scope.org.fileParent);
					}
				});
				
			}
	
		
	},	

	$scope.cretaeBread =function(e){ 

		$('.breadcrumb-header').html('<dl><a href="'+ URL +'/dataroom/view">'+ $('#userOrganization option:selected').text()  +'</a></dl>');
		$('.breadcrumb-header').append('<dl><a href="'+ URL +'/dataroom/view">'+ $('#userProject option:selected').text()  +'</a></dl>');

		var i=$('.boldtress');
		var bread=[];
		bread[0]=i.html();
		var textObj=0;
		var ctr=1;
		do {			
			i=i.closest('ul');			
			i=i.closest('li');
			textObj=i.find('a').first();
			bread[ctr++]=textObj.html();
			
		}while(textObj.length>0);
		 console.log(bread);
		for(i=bread.length-1;i>=0;i--){
			    if(typeof bread[i] === "undefined"){
				}else{	
					$('.breadcrumb-header').append('<dl><a href="#">'+ bread[i]  +'</a></dl>');
				}
		}
		
			
		
	},
	$scope.cleartexts = function (e){
		$('.headcls').html('Create Folder');
		$('.descp').hide();
		$scope.org.projectfolder='';
		$scope.org.isupdate='0';
	},	
	$scope.showFiles = function (e){
		
		$scope.org.fileParent=e;		
		
		$('#create-folders').css('pointer-events','all');
		$('#create-folders').css('opacity','1');
		if($scope.org.filerole==1 || $scope.org.filerole==3 ){
				$('.uploadonly').css('pointer-events','all');
				$('.uploadonly').css('opacity','1');				
		}else{
				$('.uploadonly').css('pointer-events','none');
				$('.uploadonly').css('opacity','0.5');
		}
		
		$scope.filesdata={};
			var uri=URL+"/showfiles?folder="+ $scope.org.fileParent;			
			$http.get(uri).success(function(data, status) {
				$scope.filesdata=data.result;
				//$scope.$apply();	
			});	
		
	},
	
	$scope.showFolders = function (e){
		$scope.org.currentrole='';
		$scope.org.currentrole=0;
		$scope.filesdata={};
		
		$('.content-header,.search-area,#create-folders').css('pointer-events','none');
		$('.content-header').css('opacity','0.5');
		$('.overview ul').html('');
		$scope.org.currentrole='';
		
		if($scope.org.orgId==0 || $scope.org.project_id==0){
			//$('.breadcrumb-header').html('<dl><a href="'+ URL +'/dataroom/view">Dataroom</a></dl>');
			 return false;
		}
		
		$('.breadcrumb-header').html('<dl><a href="'+ URL +'/dataroom/view">'+ $("#userOrganization option:selected").text()  +'</a></dl>');
		$('.breadcrumb-header').append('<dl><a href="'+ URL +'/dataroom/view">'+ $("#userProject option:selected").text()  +'</a></dl>');
		
		//$('.breadcrumb-header').html('<dl><a href="'+ URL +'/dataroom/view">'+ $("#userOrganization option:selected").text()  +'</a></dl><dl><a href="'+ URL +'/project/view">'+ $("#userProject option:selected").text()+'</a></dl>')
		var uri=URL+"/users/getProjectInfo?drId="+ $scope.org.project_id;
		
		$http.get(uri).success(function(data, status) {
			if(data.role==''){
			 	$('.content-header,.search-area').css('pointer-events','all');
				$('.content-header').css('opacity','1');
			}else if(data.role=='admin'){			
				$scope.org.currentrole=data.role;
				$('.content-header,.search-area').css('pointer-events','all');
				$('.content-header,.search-area').css('opacity','1');
				
			}else{
				$('.content-header').css('pointer-events','none');
				$('.content-header').css('opacity','0.5');
				$('.search-area').css('pointer-events','all');
				$('.search-area').css('opacity','1');
				$scope.org.currentrole=data.role;
			}
			
			var uri=URL+"/user/listfolders?projectID="+ $scope.org.project_id + "&role="+$scope.org.currentrole;
			
				$http.get(uri).success(function(data, status) {
					
						//var data=eval('('+ datares +')');
						$scope.org.filerole=data.visiblility;					
						$('#tree2').html($compile(data.folder)($scope));	
						$('#tree2').treed({openedClass:'open-folder-icon', closedClass:'close-folder-icon'});
						 if ($('#tree2').find('p').hasClass('alert-danger')){ 
							 $scope.org.fileParent=0;
							
						}else{
							$('#tree2 li a').first().css('font-weight','bold');							
							$('#tree2 li a').first().addClass('boldtress');							
							$scope.resetparent();
							$scope.setparent($('#tree2 li a').first().parent().attr('data-fld'),$('#tree2 li a').first().html());
							$scope.showFiles($('#tree2 li a').first().parent().attr('data-fld'));

						}
						//$scope.$apply();		
				});	
			
			});
		
		$('.content-header,.search-area').css('pointer-events','all');
		$('.content-header').css('opacity','1');
		
		
	};	
	 
	$scope.showFolders(); 
	
	 
	 
});
				
			
				
$(document).ready(function() {
    
			$('.name').on('click',function(){
				$("a").removeClass("selectedData");
				$(this).addClass("selectedData");
			});
			
    $('#lightSlider').lightSlider({
    });
    
      jQuery(".tm-input").tagsManager();
      $.fn.extend({
			treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i  class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                //$('.branch a').css('font-weight','normal');
                //console.log(e.target);
               // console.log(e);
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
                
                
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
		  //$('.branch li a ').css('font-weight','normal');
        $(this).on('click', function () {
             $('#tree2 li a ').css('font-weight','normal');
             $('#tree2 li a').removeClass('boldtress');
             $(this).closest('li').click();
            var ancdom=$(this).closest('li').find('a').first();
				 ancdom.css('font-weight','bold');
				 ancdom.addClass('boldtress');
                 var fild=ancdom.parent().attr('data-fld');
                 var fildhtml=ancdom.html();
              
                 angular.element('#crtlid').scope().resetparent();
                 angular.element('#crtlid').scope().setparent(fild,fildhtml);
                 angular.element('#crtlid').scope().showFiles(fild);
                 angular.element('#crtlid').scope().cretaeBread();
				 angular.element('#crtlid').scope().$apply() ; 
                

        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            
            $(this).on('click', function (e) {
                $('#tree2 li a ').css('font-weight','normal');
                $('#tree2 li a').removeClass('boldtress');
                $(this).closest('li').click();
                 $(this).closest('li a').css('font-weight','bold');
                 $(this).closest('li a').addClass('boldtress');
                 var fild=$(this).closest('li a').parent().attr('data-fld');
                 var fildhtml=$(this).closest('li a').html();
				  
                 angular.element('#crtlid').scope().resetparent();
                 angular.element('#crtlid').scope().setparent(fild,fildhtml);
                 angular.element('#crtlid').scope().showFiles(fild);
                 angular.element('#crtlid').scope().cretaeBread();
                 
                 
				// angular.element('#crtlid').scope().$apply() ; 
				// alert(angular.element('#crtlid').scope().org.parfolderid)
                 e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
			//$('.branch li a ').css('font-weight','normal');
            $(this).on('click', function (e) {
                 $('#tree2 li a ').css('font-weight','normal');
                 $('#tree2 li a').removeClass('boldtress');
                 $(this).closest('li').click();
                 $(this).closest('li a').css('font-weight','bold');
                 $(this).closest('li a').addClass('boldtress');
                e.preventDefault();
            });
        });
        
         //tree.find('.branch>a')
        
        
    }
});

     
			

    
 
		
     
    $('#tree2').on('click', '.plus',function() { 
		
		
		angular.element('#crtlid').scope().resetparent();
		$('#OpenmyModal').click();
		angular.element('#crtlid').scope().setparent($(this).attr('data-id'),$(this).attr('foldername'));
		angular.element('#crtlid').scope().$apply() 
		
		
	})	
		
    $('#tree2').on('click', '.pencil',function() { 
		
		$('#OpenmyModal').click();
		angular.element('#crtlid').scope().resetparent();
		 
		angular.element('#crtlid').scope().seteditparent($(this).attr('data-id'),$(this).attr('parentalias'),$(this).attr('foldername'));
		angular.element('#crtlid').scope().$apply();
		
		$('.idea-detail-header message,.headcls').html('Edit');
		$('.create-folder').html('Update');
		$('.descp').hide();
		
		
		
		
	})	
		
    $('#tree2').on('click', '.delete',function() { 
		
		
		var attr = $(this).attr('data-id');
	
		if (typeof attr !== typeof undefined && attr !== false) {
				
				swal({   title: "Are you sure?",   text: "You will not be able to recover this imaginary file or folder!",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: true }, function(){    angular.element('#crtlid').scope().deletedFolder(attr);
						angular.element('#crtlid').scope().$apply();  
						
					});
				 
				
		}
		
		
	});	
		


	$('.gridview-btn').on('click',function(){
		$('.utility-box').hide();$('.utility-box').hide();
		$('.files-content').addClass('grdview')			;
		$('.files-content').removeClass('listview');	
		})

		$('.listview-btn').on('click',function(){	
			$('.utility-box').hide();	$('.utility-box').hide();
		$('.files-content').removeClass('grdview');			
		$('.files-content').addClass('listview');			
		})
		
		
	$('body').on("click",'.editbtn a',function(e){
		$('.utility-popup').hide();		
		$(this).parent().parent().parent().next().show();
		
	});			
	$('body').on("click",'.closeutilityPopup .fa-times',function(e){
		$('.utility-box').hide();$('.utility-popup').hide();
	});			
	$('body').on("click",'.file-data a',function(e){		
		 
		$('.utility-box').hide();
		//$(this).parent('.file-data').find('.utility-box').animate({height:"0"});		
		$(this).parent('.file-data').find('.utility-box').css({display: "block"});		
		$(this).parent('.file-data').find('.utility-box').animate({height: "120px"});		
		e.stopPropagation();		
				
		
		
	});
	
	$('.caret-post').on('click',function(){
		
		
		if($( "#collapseOne" ).hasClass('closed')){
			$( "#collapseOne" ).removeClass('closed');
			$( ".caret-post" ).removeClass('closed');
			$( "#collapseOne" ).addClass('open');
			$('.second-header').css('height','147px');
			$('#create-folders.main-config').css('margin-top','210px');
			$('#create-folder-file .dashboard-draggable-menu').css('top','123px');
		}else{
			$( "#collapseOne" ).addClass('closed');
			$( "#collapseOne" ).removeClass('open');			
			$( ".caret-post" ).addClass('closed');
			$('.second-header').css('height','65px');
			$('#create-folders.main-config').css('margin-top','127px');
			$('#create-folder-file .dashboard-draggable-menu').css('top','39px');
		}
		
	});
		
	$('#filebtnupload').fileupload({
        url: URL + '/upload-file',
        dropZone: $(this),
        dataType: 'json',
        maxFileSize  : 1073741824*2,
        singleFileUploads: false,        
        autoUpload: true,
        add: function (e, data) {
					
					if(data.originalFiles[0]['size'] > 1073741824*2){
                        $('#file-falso-1').val('');
                         $('.vidurl').html('Please upload file size less then 2GB');
                         $('.vidurl').show();
                        return false;
                    }  
					
					var role=angular.element('#crtlid').scope().getFilesAccess();
					var parfolder =angular.element('#crtlid').scope().getFilesParent();					
					angular.element('#crtlid').scope().$apply() ; 
					if(role==1 || role==3){
						 data.formData = {folder: parfolder};
						data.submit();
					}else if(role==-1){
						
					  	toastr.options = {"positionClass": "toast-top-center"};	
						toastr["error"]("Please select organization or project");
						return false;						
					}else if(role==-2){					  	
					  	toastr.options = {"positionClass": "toast-top-center"};	
						toastr["error"]("Please select folder!");
						return false;
					}else{
						toastr.options = {"positionClass": "toast-top-center"};	
						toastr["error"]("You have not access to upload File!");	
						return false;
					}	
                },
          progress: function (e, data) {
                     
                    $('.progress-bar').css('-webkit-transitiond', 'width .6s ease');
                    $('.progress-bar').css('-o-transition', 'width .6s ease');
                    $('.progress-bar').css('transition', 'width .6s ease');
                    
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('.progress-bar').css('width', progress + '%');
                     
                },        
                
        done: function (e, data) {
        			
        			$('.progress-bar').css('-webkit-transitiond', 'initial');
                    $('.progress-bar').css('-o-transition', 'initial');
                    $('.progress-bar').css('transition', 'initial');
        			 
        			if(data.result.status=='success'){
						
						$('.files-content').prepend(data.result.result);
						
						
						angular.element('#crtlid').scope().showFiles(angular.element('#crtlid').scope().getFilesParent());
						angular.element('#crtlid').scope().$apply(); 
						
						toastr.options = {"positionClass": "toast-top-center"};	
						toastr["success"](data.result.message);	
					}else{
						toastr.options = {"positionClass": "toast-top-center"};	
						toastr["error"](data.result.message);	
					}
        			
        			$('.progress-bar').css('width','0%');
        },
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
  });		
			
</script>
@endsection
