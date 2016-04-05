@extends('layouts.protected')
@section('content')
<style>
.showhide{display:none;}
.show{display:block;}

.editUpdatePrj { float:right; display:block !important; margin-left:15px;}
.editUpdatePrj a {font-size:14px; color:#333;}
.editUpdatePrj .fa { margin-left:10px;}
.selectedData {color:#00a6bb; font-weight:bold;}




</style>
 <!-- Second Header -->
    <div class="second-header" >
        <div class="breadcrumb-header">
          <ul>
            <li><a href="<?php echo URL::to('/') ?>/dataroom/view">Rooms</a></li>
            <li><a href="<?php echo URL::to('/') ?>/project/view">Project</a></li>
            <li><a href="#">Folders</a></li>
          </ul>
        </div>
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

    <div id="create-folders" ng-app="ravabe" ng-controller="folderCtrl" class="main main-config main-drag">


    
	<!-- Dashbord Draggable Menu -->
	<div id="create-folder-file">
		<div class="dashboard-draggable-menu dashboard-draggable-menu-open">
			<a href="#" class="draggable-menu-action-dashboard">
				
			</a>
        <a href="#" class="draggable-menu-action-dashboard-mobile">
           
        </a>
        <div class="container-fluid content dashboard-draggable-menu-content dashboard-draggable-content-open">
        
        <div class="select-dataroomList clearfix">
						<div class="col-lg-12 col-md-12 col-sm-12">							
								<div class="addDropdown clearfix">
									<section>
								<p>Select Dataroom</p>
								<select ng-change="getProject()" ng-model="org.orgId" class="form-control">
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
        
            <div class="content-header" style="position:relative;pointer-events:none;opacity:0.5">
                <div class="file-upload">
                    <div class="btn-box">
                        <button ng-click="resetparent()" type="button" data-toggle="modal" id="OpenmyModal" data-target="#myModal">New Folder</button>
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
                        <div style="font-size: 14px;    margin: 16px 0;"><b>Parent Folder : </b> <span class="parfolder"><% org.parfolder %></span> <small class="descp"><a style="color:#23527c" href="javascript:$('.showchanges').show()">(Change)</a></small></div>
                        <div class=" showchanges alert alert-info " style="display:none">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
							To change parent folder you need to click on folder in left side and then click on '+' to add new folder .
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
	<!-- Modal -->			
	<div class="modal " id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" style="display: none;">
					
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h2 id="bet-form-heading">Upload file</h2>
				</div>
				<div class="output alert alert-dismissible" style="display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<div class="message-list"></div>
					</div>
				<div class="modal-body clearfix">
					<form action="raselections/uploadcsv" method="POST" class="dropzone dz-clickable" id="add-record-form">
						<input type="hidden"  id="actionpost" value="raselections/saveinfo" />
						<input type="hidden"  id="actiondel" value="raselections/deletepost" />
						<input type="hidden"  id="updatepost" value="" />
						<div class="dz-default dz-message">
							<span><i class="fa fa-upload"></i><br>Drop files here to upload or click to select</span>
						</div>
							
					
					</form>
					<div id="selection-data-form clearfix">					
							<button class="btn btn-lg submit-btn" type="submit">Save File</button>
					</div>
					
					
				</div>
			</div>
		</div> <!-- End .modal-dialog .modal-lg -->
	</div> 
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
	
	
	
<script type="text/javascript">
var URL='<?php echo URL::to('/')?>';			
ravabe.controller("folderCtrl", function($rootScope,$scope, $http) {
	$scope.org={};
	$scope.org.orgId='<?php echo $data['dataroomid'] ?>';
	$scope.org.project_id='<?php echo $data['projectid'] ?>';	
	
	$scope.org.currentrole='';
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
		$('#create-folders,#projectfolder').css('pointer-events','none');
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
			
			if(response==1){
				
				$('#create-folders,#projectfolder').css('pointer-events','all');
				
				var uri=URL+"/user/listfolders?projectID="+ $scope.org.project_id + "&role="+$scope.org.currentrole;
			
				$http.get(uri).success(function(data, status) {
						$('#tree2').html(data);	
						$('#tree2').treed({openedClass:'open-folder-icon', closedClass:'close-folder-icon'});
						$('.close').click();
						$('#create-folders,#projectfolder').css('pointer-events','all');
						
	
				});	
				toastr.options = {"positionClass": "toast-top-center"};	
				toastr["success"]("Folder has successfully saved!")
				
			}else{
				
				$('.create-folder').show();
				$('.createfolderloader').hide();
				$('#create-folders,#projectfolder').css('pointer-events','all');
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
			if(response==-1){
				toastr["error"]("Folder not found to deleted!");	
			}else if(response==-2){
				toastr["error"]("Unauthorized access!!");
			}else{	
				var uri=URL+"/user/listfolders?projectID="+ $scope.org.project_id + "&role="+$scope.org.currentrole;			
				$http.get(uri).success(function(data, status) {
						$('#tree2').html(data);	
						$('#tree2').treed({openedClass:'open-folder-icon', closedClass:'close-folder-icon'});		
				});
				
				toastr["success"]("Folder was deleted successfully!!");
				
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
		$scope.org.parfolderid='0';
		$scope.org.isupdate='0';
		$('.create-folder').show();
		$('.createfolderloader').hide();
		$('#create-folders,#projectfolder').css('pointer-events','all');
		$('.parfolder').html($scope.org.parfolder);
	},	
	$scope.getProject = function (e){
		if($scope.org.orgId==0 ){
			 //$scope.org.project_id=0;
			 $('.content-header,.search-area').css('pointer-events','none');
			 $('.content-header').css('opacity','0.5');
			 $("#userProject").find('option:gt(0)').remove();
			 $scope.org.currentrole='';
			 $('.overview ul').html('');
			 return false;
		}
		
		var uri=URL+"/users/getUserProject?drId="+ $scope.org.orgId;
		
		$http.get(uri).success(function(data, status) {
			$scope.org.project_id=0; 
			$("#userProject").find('option:gt(0)').remove();
			$.each(data,function(i,proj){
				$("#userProject").append('<option value="'+proj.projid+'">'+proj.name+'</option>');
			});
			
			
		});
	};
	
	$scope.showFolders = function (e){
		$scope.org.currentrole='';
		$('.content-header,.search-area').css('pointer-events','none');
		$('.content-header').css('opacity','0.5');
		$('.overview ul').html('');
		$scope.org.currentrole='';
		
		if($scope.org.orgId==0 || $scope.org.project_id==0){
			 return false;
		}
		
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
						$('#tree2').html(data);	
						$('#tree2').treed({openedClass:'open-folder-icon', closedClass:'close-folder-icon'});		
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
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
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
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

     
			
  });
    
 
		
    $('#tree2').on('click', '.plus',function() { 
		
		
		angular.element('#create-folders').scope().resetparent();
		$('#OpenmyModal').click();
		angular.element('#create-folders').scope().setparent($(this).attr('data-id'),$(this).attr('foldername'));
		angular.element('#create-folders').scope().$apply() 
		
		
	})	
		
    $('#tree2').on('click', '.pencil',function() { 
		
		
		angular.element('#create-folders').scope().resetparent();
		 
		angular.element('#create-folders').scope().seteditparent($(this).attr('data-id'),$(this).attr('parentalias'),$(this).attr('foldername'));
		angular.element('#create-folders').scope().$apply();
		$('#OpenmyModal').click();
		$('.idea-detail-header message,.headcls').html('Edit');
		$('.create-folder').html('Update');
		$('.descp').hide();
		
		
		
		
	})	
		
    $('#tree2').on('click', '.delete',function() { 
		
		
		var attr = $(this).attr('data-id');
	
		if (typeof attr !== typeof undefined && attr !== false) {
				if(confirm('Are you want to delete that folder ?')){
					
						angular.element('#create-folders').scope().deletedFolder(attr);
						angular.element('#create-folders').scope().$apply(); 
					
				}
				
		}
		
		
	});	
		
    

		
		$('#OpenmyModal').on('click',function (){
			$('.foldererror').removeClass('show');
				$('.projecterror').removeClass('show');
				$('.dataroomerror').removeClass('show');
				$('.foldererror').addClass('showhide');
				$('.projecterror').addClass('showhide');
				$('.dataroomerror').addClass('showhide');
				
			
			
		});
		
	
		
		$('#myModal').on('hidden.bs.modal', function (e) {
			$(".output").hide();
		  $('#projectfolder').val('');
			$('.create-folder').html('Create');
			$('.update-folder').html('Create');
			$('.message').html('Create New Folder');
			$('.create-folder').removeAttr('data-id');
		});
	
	$('body').on('click','.upload', function() { 
	 var attr = $(this).attr('data-id');
	 
	});
	
 
	
	


	
</script>
 
@endsection
