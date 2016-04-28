@extends('layouts.protected')
@section('content')
<link href="<?php echo URL::to('/')?>/assets/css/fine-uploader-gallery.min.css" rel="stylesheet" />
<link href="<?php echo URL::to('/')?>/assets/css/fine-uploader-new.min.css" rel="stylesheet" />		
<script src="<?php echo URL::to('/')?>/assets/js/all.fine-uploader.min.js"></script>

<div style="height:100%"  ng-app="ravabe" ng-controller="folderCtrl" id="crtlid">
 <!-- Second Header -->
    <div class="second-header  folder-header" >
        <div class="breadcrumb-header" style="margin:0px 36px 0px 28px;border-bottom: solid 1px #d8dee3;padding: 12px 0 6px 0px;">           
            <dl><a href="<?php echo URL::to('/') ?>/dataroom/view">Dataroom</a></dl>
            <dl><a href="<?php echo URL::to('/') ?>/project/view">Project</a></dl>
        </div>
        
        <div class="search-wrapper" style="padding-top: 9px;">
        	<ul class="clearfix">
        		<li>
        			<div><strong>Select Dataroom</strong></div>
        			<div>
						
        				<select id="userOrganization" ng-change="getProject()" ng-model="org.orgId" class="form-control">
										<option value="0" >-Select Dataroom-</option>
										@if($data['dataroom']!=null)
											@foreach($data['dataroom'] as $key=>$alert)
										<option value="{{$alert->roomid}}">{{ $alert->name }}</option>
										  @endforeach
										@endif	
						</select>
        			</div>
        		</li>
        		<li>
        			<div><strong>Select Project</strong></div>
        			<div>
        				<select  ng-change="showFolders()"  ng-model="org.project_id" id="userProject" class="form-control" >
										<option value="0">-Select Project-</option>
										@if($data['projects']!=null)
											@foreach($data['projects'] as $key=>$alert)
											<option value="{{$alert->projid}}">{{ $alert->name }}</option>
										  @endforeach
										@endif
								</select>
        			</div>
        		</li>
        	</ul>
        </div>
        <div class="collapse-wrapper">
        	<a class="collapse-btn" href="javascript:toggleFolderSearch();"></a>
        </div>
        

    </div>

<!-- End of Second Header -->

	<div class="folder-main-container">
		
		 <div class="left-panel">
			<a class="toggle-btn" href="javascript:toggleLeftFolderPanel();"></a>
			<div class="btn-group">
				<button  ng-show="org.currentrole=='admin' || org.currentrole=='upload'" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img src="<?php echo URL::to('/')?>/assets/images/new-icon.png">NEW
				</button>
				<ul class="dropdown-menu">
				    <li   ng-click="checkIsParent(0)">
                        <a href="#" data-toggle="modal" ><img src="<?php echo URL::to('/')?>/assets/images/folder-icon.png">Folder</a>
                    </li>
				    <li ng-click="checkIsParent(1)" ng-show="org.currentrole=='admin'">
                        <a href="#"><img src="<?php echo URL::to('/')?>/assets/images/file-edit-icon.png">Rename Folder</a>
                    </li>
				    <li  ng-click="checkIsParent(2)" ng-show="org.currentrole=='admin'">
                        <a href="#"><img src="<?php echo URL::to('/')?>/assets/images/file-delete-icon.png">Delete Folder</a>
                    </li>
				    <li role="separator" class="divider"></li>
				    <li ng-show="org.currentrole=='admin' || org.currentrole=='upload'" >
                        <a href="#" onclick="$('.qq-upload-button-selector input').click()" ><img src="<?php echo URL::to('/')?>/assets/images/upload-file-icon.png">Upload File</a>
                    </li>
				    
				   <!--  <li><a href="#" data-toggle="modal" data-target="#uploadFolderModal"><img src="<?php echo URL::to('/')?>/assets/images/upload-folder-icon.png">Upload Folder</a></li> -->
				</ul>
			</div>
			<div>
				<div style=" width: 85%; margin: 0 auto" ng-show="org.project_id==0  && org.orgId==0" class="alertwarning"><p class="alert alert-danger">Please select Dataroom & Project to create or list all folders & file.</p></div>					
				<div style=" width: 85%; margin: 0 auto" ng-show="org.project_id==0  && org.orgId!=0" class="alertwarning"><p class="alert alert-danger">Please select Project to create or list all folders & file.</p></div>					
			</div>
			<div class="folder-tree-wrapper">
				<div id="folder-treeview"></div>
			</div>
		</div>
		
		<div class="right-panel" >
			
            <a class="close-btn" href="javascript:closeRightPanel();"><i class="glyphicon glyphicon-remove"></i></a>
            <div class="file-operate-wrapper clearfix">
                <a ng-click="downloadFile()" ng-show="org.currentrole=='admin' || org.currentrole=='upload' || org.currentrole=='download'" class="download" title="Download" href="javascript:void(0);"><img src="<?php echo URL::to('/')?>/assets/images/download.png" alt=""></a>
                <a ng-show="org.currentrole=='admin' || org.filerole==1"  class="delete" title="Delete" href="javascript:void(0);" onclick="showDeleteFileModal();"><img src="<?php echo URL::to('/')?>/assets/images/file-delete-icon.png" alt=""></a>
                <a ng-show="org.currentrole=='admin'" class="move hidden" title="Move" href="javascript:showMoveFileModal();"><img src="<?php echo URL::to('/')?>/assets/images/file-move-icon.png" alt=""></a>
                <a ng-show="org.currentrole!='view' " class="share hidden" title="Share" href="javascript:showShareFileModal();"><img src="<?php echo URL::to('/')?>/assets/images/file-share-icon.png" alt=""></a>
                <a ng-click="copyFile()" ng-show="org.currentrole=='admin'" class="copy" title="Copy" href="javascript:void(0);"><img src="<?php echo URL::to('/')?>/assets/images/file-copy-icon.png" alt=""></a>
                <a  ng-show="org.currentrole=='admin' || org.filerole==1" class="edit" title="Edit" href="javascript:void(0);" onclick="editFileStart();"><img src="<?php echo URL::to('/')?>/assets/images/file-edit-icon.png" alt=""></a>
            </div>
            
            <script type="text/template" id="qq-template-gallery">
									<div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
										<div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
											<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
										</div>
										<div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
											<span class="qq-upload-drop-area-text-selector"></span>
										</div>
										<div class="qq-upload-button-selector qq-upload-button">
											<div>Upload files</div>
										</div>
										<span class="qq-drop-processing-selector qq-drop-processing">
											<span>Processing dropped files...</span>
											<span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
										</span>
										<ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
											<li>
												<span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
												<div class="qq-progress-bar-container-selector qq-progress-bar-container">
													<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
												</div>
												<span class="qq-upload-spinner-selector qq-upload-spinner"></span>
												<div class="qq-thumbnail-wrapper">
													<img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
												</div>
												<button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
												<button type="button" class="qq-upload-retry-selector qq-upload-retry">
													<span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
													Retry
												</button>

												<div class="qq-file-info">
													<div class="qq-file-name">
														<span class="qq-upload-file-selector qq-upload-file"></span>
														<span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
													</div>
													<input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
													<span class="qq-upload-size-selector qq-upload-size"></span>
													<button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
														<span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
													</button>
													<button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
														<span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
													</button>
													<button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
														<span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
													</button>
												</div>
											</li>
										</ul>

									</div>
								</script>
            
			<div class="table-wrapper" >
				<table class="table">
					<thead>
						<tr>
							<th class="filename-title">File Name</th>
							<th>Owner</th>
							<th>Last Added</th>
						</tr>
					</thead>
                    <tbody>
                        <tr data-id="<% values.id %>" data-access="<%values.roleaccess%>" class="task" ng-click="selectFile(values.id,values.roleaccess)" ng-repeat="values in filesdata">
                            <td class="filename exe <%values.extcss%>">
                                <div class="filename-disp"><% values.name %> <% value.roleaccess %></div>
                                <input data-id="<% values.name %>" on-blur="cancelFile()" my-enter="editFiles()" class="filename-edit form-control" type="text" value="<% values.name %>">
                            </td>
                            <td><% values.user %></td>
                            <td><% values.dated %></td>
                         </tr>
                    </tbody>
				</table>
			    
			</div>
			<div id="fine-uploader-gallery"></div>
		</div>
            
         <div style="display:none" class="file-process-popup">
            <div class="title">
                 <span class="nooffileupload">Uploading 1 Files ...</span> 
                <div class="action-wrapper clearfix">
                    <a href="javascript:minFileProcPopup();" class="minimize"></a>
                    <a href="javascript:closeFileProcPopup();" class="close-popup"></a>
                </div>
            </div>
            <div class="table-wrapper">
                <table class="table uploadprogress"></table>
            </div>
        </div>                

	</div>



  <!-- Modal -->
    <div class="modal fade" id="createFolderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title headcls" id="myModalLabel">Create New Folder</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group clearfix">
							<p style="display:none;width: 300px;margin: 0 41px;margin-bottom: 13px;" class="alert alert-danger error showhide foldererror"></p>								
							<p  ng-show="org.currentrole!='admin' && org.currentrole!='upload'"  class="alert alert-danger">You have not access to create or update folder </p>
							
                            <label for="inputType"   ng-show="org.currentrole=='admin' || org.currentrole=='upload'"  class="col-md-2 control-label">Name</label>
                            <div class="col-md-5">
                                <input ng-show="org.currentrole=='admin' || org.currentrole=='upload'" ng-model="org.projectfolder"  type="text" name="projectfolder" id ="projectfolder"type="text" class="form-control" placeholder="Please input new folder name">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button  ng-show="org.currentrole=='admin' || org.currentrole=='upload'" ng-click="createFolder()" type="button" class="btn btn-primary">Save</button>
                    <div class="createfolderloader" style="display:none;"><img src="<?php echo URL::to('/')?>/assets/images/loader.gif" style="	width: 41px;"></div>
                </div>
                
            </div>
        </div>
    </div>
   
    <div class="modal fade" id="shareFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Share File</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputType">Link to file</label>
                        <input type="text" class="form-control" placeholder="http://">
                    </div>
                    <div class="form-group">
                        <label for="inputType">Send this link to</label>
                        <div class="share-list-wrapper clearfix">
                        <?php
                            for ($i = 0; $i < 14; $i ++) {
                                echo '<a href="javascript:void(0);"><i class="glyphicon glyphicon-ok"></i></a>';
                            }
                        ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send</button>
                </div>
            </div>
        </div>
    </div>    
    <div class="modal fade" id="deleteFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delete File</h4>
                </div>
                <div class="modal-body">
                    Are you sure to delete this ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button ng-click="deleteFile()" type="button" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>    
    <div class="modal fade" id="copyFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Copy File</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group clearfix">
                            <label for="inputType" class="col-md-2 control-label">Name</label>
                            <div class="col-md-5">
                                <input type="text" id="copyfilt" class="form-control" placeholder="Please input copy file name">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" ng-click="copyFiletoDB()" class="btn btn-primary">Copy</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="moveFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Move File</h4>
                </div>
                <div class="modal-body">
                    <div class="move-file-wrapper">
                        <ul>
                            <li class="has-child selected">
                                <a class="back" href="javascript:getRelatedFolder('parent');"><i class="glyphicon glyphicon-chevron-left"></i></a>
                                Project 1
                                <a class="forward" href="javascript:getRelatedFolder('child');"><i class="glyphicon glyphicon-chevron-right"></i></a>
                            </li>
                            <li>
                                <a class="back" href="javascript:getRelatedFolder('parent');"><i class="glyphicon glyphicon-chevron-left"></i></a>
                                Project 2
                                <a class="forward" href="javascript:getRelatedFolder('child');"><i class="glyphicon glyphicon-chevron-right"></i></a>
                            </li>
                            <li>
                                <a class="back" href="javascript:getRelatedFolder('parent');"><i class="glyphicon glyphicon-chevron-left"></i></a>
                                Project 3
                                <a class="forward" href="javascript:getRelatedFolder('child');"><i class="glyphicon glyphicon-chevron-right"></i></a>
                            </li>
                            <li>
                                <a class="back" href="javascript:getRelatedFolder('parent');"><i class="glyphicon glyphicon-chevron-left"></i></a>
                                Project 4
                                <a class="forward" href="javascript:getRelatedFolder('child');"><i class="glyphicon glyphicon-chevron-right"></i></a>
                            </li>
                            <li>
                                <a class="back" href="javascript:getRelatedFolder('parent');"><i class="glyphicon glyphicon-chevron-left"></i></a>
                                Project 5
                                <a class="forward" href="javascript:getRelatedFolder('child');"><i class="glyphicon glyphicon-chevron-right"></i></a>
                            </li>
                            <li>
                                <a class="back" href="javascript:getRelatedFolder('parent');"><i class="glyphicon glyphicon-chevron-left"></i></a>
                                Project 6
                                <a class="forward" href="javascript:getRelatedFolder('child');"><i class="glyphicon glyphicon-chevron-right"></i></a>
                            </li>
                            <li>
                                <a class="back" href="javascript:getRelatedFolder('parent');"><i class="glyphicon glyphicon-chevron-left"></i></a>
                                Project 7
                                <a class="forward" href="javascript:getRelatedFolder('child');"><i class="glyphicon glyphicon-chevron-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Move</button>
                </div>
            </div>
        </div>
    </div>
   
   
    <nav id="context-menu" class="context-menu">
        <ul class="context-menu__items">
            <li  ng-click="downloadFile()"   ng-show="org.currentrole=='admin' || org.currentrole=='upload' || org.currentrole=='download'" class="context-menu__item">
                <a href="javascript:void(0);" class="context-menu__link" >
                    <img src="<?php echo URL::to('/')?>/assets/images/download.png">Download
                </a>
            </li>
            
            <li  ng-show="org.currentrole=='admin' || org.filerole==1"  class="context-menu__item">
                <a href="javascript:void(0);" class="context-menu__link" data-action="edit">
                    <img src="<?php echo URL::to('/')?>/assets/images/file-edit-icon.png">Edit
                </a>
            </li>
            <li  ng-show="org.currentrole=='admin'"  class="context-menu__item">
                <a href="javascript:void(0);" class="context-menu__link" data-action="copy">
                    <img src="<?php echo URL::to('/')?>/assets/images/file-copy-icon.png">Copy
                </a>
            </li>
            <li  ng-show="org.currentrole!='view' " class="context-menu__item hidden">
                <a href="#" class="context-menu__link" data-action="share">
                    <img src="<?php echo URL::to('/')?>/assets/images/file-share-icon.png">Share
                </a>
            </li>
            <li  ng-show="org.currentrole=='admin' " class="context-menu__item hidden">
                <a href="#" class="context-menu__link" data-action="move">
                    <img src="<?php echo URL::to('/')?>/assets/images/file-move-icon.png">Move
                </a>
            </li>
            <li  ng-show="org.currentrole=='admin' || org.filerole==1"  class="context-menu__item">
                <a href="#" class="context-menu__link" data-action="delete">
                    <img src="<?php echo URL::to('/')?>/assets/images/file-delete-icon.png">Delete
                </a>
            </li>
        </ul>
    </nav>

</div>	

 

<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/')?>/assets/css/context-menu.css">


<script type="text/javascript">
var URL='<?php echo URL::to('/')?>';
var orgId='<?php echo $data['dataroomid'] ?>';
var project_id='<?php echo ($data['projectid'])?$data['projectid']:0 ?>';
</script>
<script type="text/javascript" src="<?php echo URL::to('/')?>/assets/js/folder.js"></script>	
<script type="text/javascript" src="<?php echo URL::to('/')?>/assets/js/context-menu.js"></script>	
@endsection
