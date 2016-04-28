var galleryUploader;
var gSelectedFile=null;
toastr.options = {"positionClass": "toast-top-center"};

ravabe.directive('myEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.myEnter);
                });

                event.preventDefault();
            }
        });
    };
})

ravabe.controller("folderCtrl", function($rootScope,$scope, $http,$compile) {
	$scope.org={};
	$scope.filesdata={};
	$scope.defaultData={};
	$scope.org.orgId=orgId;
	$scope.org.project_id=project_id;
	$scope.org.currentrole='';
	$scope.org.filerole='0';
	$scope.org.coded="";
	$scope.userdata={};
	$scope.org.parfolder='Root';
	$scope.org.parfolderid='0';
	$scope.org.projectfolder='';
	$scope.org.projectfolderName='';
	$scope.org.isupdate='0';
	$scope.org.lastselected='0';
	$scope.org.selectedObj=0;
	$scope.org.currentroleAccess='0';
	$scope.org.filerole='0';
	$scope.org.currentFileID='0';
	
	$scope.getCurrentRole = function(){
		return $scope.org.currentrole;
	},
	$scope.disableDiv = function (e){
	  if(e==1)	{
		  $('.folder-main-container').css('pointer-events','all');
		  //$('.table-wrapper,.file-operate-wrapper,.left-panel .btn-group').css('opacity',1);
	  }else{
		  $('.folder-main-container').css('pointer-events','none');
		  //$('.table-wrapper,.file-operate-wrapper,.left-panel .btn-group').css('opacity',0.5);
	  }
	},
	
 	$scope.selectFile= function(id,rolenm,coded){
		
		$scope.org.filerole=rolenm;
		$scope.org.currentFileID=id;
		 
		$scope.org.coded=coded;
	},
	
 	$scope.getShareLink= function(){
		 
		return $scope.org.coded;
	},
	
	$scope.deletedFolder = function (id){
		if($scope.org.currentrole!='admin'){
			toastr["error"]("Unauthorized access!!");
			return false;
		}
		
		$http({
		  method: 'post',
		  url:  URL+"/users/deletefolder",
		  data: { fid:$scope.org.parfolderid}
		}).success(function(response, status) {
			toastr.options = {"positionClass": "toast-top-center"};	
			if(response.flag==-1){
				toastr["error"]("File not found to deleted!");	
			}else if(response.flag==-2){
				toastr["error"]("Unauthorized access!!");
			}else{	
				 $scope.folderOperation();
				 $scope.showFiles();
				toastr["success"]("Folder has been deleted successfully!!");
				
			}
			
				
			
		});	
	 
		
	}
	
	$scope.cancelFile=function(){
		if (!gSelectedFile) return;
		var selectedTr = gSelectedFile;	
		selectedTr.find('.filename-edit').val(selectedTr.find('.filename-edit').attr);
		selectedTr.find('.filename-edit').css('display', 'none');
		selectedTr.find('.filename-disp').css('display', 'block');
		
	},
	$scope.checkIsParent = function (e){
		
		//console.log($scope.org.parfolderid);
		if($scope.org.orgId==0 || $scope.org.project_id==0  ){
			sweetAlert("Oops...", "Please select dataroom or Project!", "error"); 			
			return false;
		} else if($scope.org.parfolderid==0){	
		
			sweetAlert("Oops...", "Please select on Folder name to upload !", "error"); 			
			return false;
			
		}else{	
			$scope.setparent($scope.org.parfolderid,'');	
			
			if(e==2){
				 
				 $scope.deletedFolder();
				 
			}else{
				$scope.cleartexts(e);
				$('#createFolderModal').modal();
			}
		}
	},	
	$scope.createFolder = function (e){
		$('.showhide').html(''); 
		$('.showhide').hide();
		if($scope.org.currentrole=='admin' || $scope.org.currentrole=='upload' ){
			$scope.org.currentrole=$scope.org.currentrole;
		}else{	
			$('.showhide').html('You have not access to create folder!!'); 
			$('.showhide').show(); return false;
		}
		if($scope.org.projectfolder==''){
			$('.showhide').html('Please enter folder name!!'); 
			$('.showhide').show(); return false;
		}
		
		$('.create-folder').hide();
		$('.createfolderloader').show();
		$scope.disableDiv(0);
		
		
		
		if($scope.org.isupdate=='0'){
			
		   var uri= URL+"/users/geteditfolder";
		   var params ={ folderId:$scope.org.parfolderid, foldername:$scope.org.projectfolder, projectID:$scope.org.project_id};
		   
		}else{
			
			var uri= URL+"/users/getupdatefolder";
			var params ={ folderId:$scope.org.parfolderid, foldername:$scope.org.projectfolder, projectID:$scope.org.project_id};
			
		}	
		$http({
		  method: 'post',
		  url: uri,
		  data: params
		}).success(function(response, status) {
			
			if(response.flag==0){
				
				$scope.disableDiv(1);
				
				$scope.folderOperation(1,$scope.org.projectfolder, $scope.org.nodeparfolderid );
				$scope.showFiles();
				toastr.options = {"positionClass": "toast-top-center"};	
				toastr["success"]("Folder has been saved successfully!");
				$('#createFolderModal .close').click();
				
			}else{
				
				$('.create-folder').show();
				$('.createfolderloader').hide();
				$scope.disableDiv(1);
				$('.showhide').html(response.error); 
				$('.showhide').show(); return false;
				
			}
			
		  });
		
		
		
	},	
	
	$scope.cleartexts = function (e){
		$('.createfolderloader,.foldererror').hide();
		//alert(e);
		if(e==0){
			$('.headcls').html('Create New Folder');		
			$scope.org.projectfolder='';
			$scope.org.isupdate='0';
		}else{
			$('.headcls').html('Edit Folder');		
			$scope.org.projectfolder=$scope.org.projectfolderName;
			$scope.org.isupdate='1';
		}
		
		
	},
	
	$scope.getProject = function (e){
		$scope.filesdata={};
		$scope.defaultData={};
		$scope.org.selectedObj=0;
		$scope.org.currentroleAccess=0;
		$scope.resetFolders();
		if($scope.org.orgId==0 ){
			 //$scope.org.project_id=0;
			
			 $("#userProject").find('option:gt(0)').remove();
			 $scope.org.currentrole='';			
			 $('.breadcrumb-header').html('<dl><a href="'+ URL +'/dataroom/view">Dataroom</a></dl><dl><a href="'+ URL +'/project/view">Project</a></dl>');
			 return false;
			
		}
		if($scope.org.project_id==0){
			$('.breadcrumb-header').html('<dl><a href="'+ URL +'/dataroom/view">'+ $("#userOrganization option:selected").text()  +'</a></dl>');
		}else{
			$('.breadcrumb-header').html('<dl><a href="'+ URL +'/dataroom/view">'+ $("#userOrganization option:selected").text()  +'</a></dl><dl><a href="'+ URL +'/project/view">'+ $('#userProject option:selected').text() +'</a></dl>');
		}
		var uri=URL+"/users/getUserProject?drId="+ $scope.org.orgId;
		
		$http.get(uri).success(function(data, status) {
			$scope.org.project_id=0; 
			$("#userProject").find('option:gt(0)').remove();
			$.each(data,function(i,proj){
				$("#userProject").append('<option value="'+proj.projid+'">'+proj.name+'</option>');
			});
			
			if($scope.org.project_id==0){
				$('.breadcrumb-header').html('<dl><a href="'+ URL +'/dataroom/view">'+ $("#userOrganization option:selected").text()  +'</a></dl>');
			}else{
				$('.breadcrumb-header').html('<dl><a href="'+ URL +'/dataroom/view">'+ $("#userOrganization option:selected").text()  +'</a></dl><dl><a href="'+ URL +'/project/view">'+ $('#userProject option:selected').text() +'</a></dl>');
			}
			
			
		});
	};
	
	
	
	$scope.setparent = function (id,name){
		$('.headcls').html('Create New Folder');						
		$scope.org.parfolderid=id;
		$scope.org.projectfolder='';
			
	},	
	$scope.resetparent = function (e){
		
		$('.headcls').html('Create Folder');
		$scope.org.parfolder='Root';
		$scope.org.projectfolder='';
		$scope.org.parfolderid='0';
		$scope.org.selectedObj=0;
		$scope.org.isupdate='0';
	},
	$scope.getFolderData = function (e){
		 
		 return $scope.filesdata;
	},	
	$scope.setBread = function(e){
			
			
	},	
	$scope.showFolders = function (e){
		$scope.org.currentrole='';
		$scope.org.currentrole=0;
		$scope.filesdata={};
		$scope.userdata={};
		$scope.org.lastselected=0;
		$scope.org.selectedObj=0;
		$scope.defaultData={};
		$scope.resetFolders();
		$scope.org.currentrole='';
		$scope.org.currentroleAccess=0;
		$scope.org.filerole=0;
		$scope.org.currentFileID='0';
		
		if($scope.org.project_id==0){
				angular.element(document.querySelector('.breadcrumb-header')).innerHTML='<dl><a href="'+ URL +'/dataroom/view">'+ $('#userOrganization option:selected').text()  +'</a></dl>';
		}
		if($scope.org.orgId==0 || $scope.org.project_id==0){		
				
			 return false;
		}
		
		  angular.element(document.querySelector('.breadcrumb-header')).innerHTML='<dl><a href="'+ URL +'/dataroom/view">'+ $('#userOrganization option:selected').text()  +'</a></dl>';
		$scope.disableDiv(0);
		var orgname=$("#userOrganization option:selected").text();
		var proname=$("#userProject option:selected").text();
		$scope.setBread();
		var uri=URL+"/users/getProjectInfo?drId="+ $scope.org.project_id;		
		$http.get(uri).success(function(data, status) {
			$scope.userdata=data.users;
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
				$scope.org.currentroleAccess=data.access;
			}
			
				$scope.folderOperation(); 
			
			});
		
		$('.content-header,.search-area').css('pointer-events','all');
		$('.content-header').css('opacity','1');
		
		
	};	
	$scope.resetFolders= function(){
		$scope.org.filerole=0;
		$scope.org.coded="";
		$scope.org.currentFileID='0';
		$('.folder-tree-wrapper #folder-treeview').treeview({
								data: $scope.defaultData,
								expandIcon: 'glyphicon glyphicon-chevron-right',
								collapseIcon: 'glyphicon glyphicon-chevron-down',
								nodeIcon: 'glyphicon glyphicon-folder-close',
								selectedBackColor: "#00a6bc",
								showBorder: false,								 
								selectedColor: "white"
		});						
		
	} 
	$scope.folderOperation = function(e,nm,lsid){
		$scope.org.filerole=0;
		$scope.org.coded="";
		$scope.org.currentFileID='0';
		var uri=URL+"/user/listfolders?projectID="+ $scope.org.project_id + "&role="+$scope.org.currentrole;
			
				$http.get(uri).success(function(data, status) {
					
						//var data=eval('('+ datares +')');
						$scope.org.filerole=data.visiblility;						
						$scope.defaultData=data.folder;
						$scope.disableDiv(1);						
						if($scope.defaultData.length>0){
							$('.folder-tree-wrapper #folder-treeview').treeview({
								data: $scope.defaultData,
								expandIcon: 'glyphicon glyphicon-chevron-right',
								collapseIcon: 'glyphicon glyphicon-chevron-down',
								nodeIcon: 'glyphicon glyphicon-folder-close',
								selectedBackColor: "#00a6bc",
								showBorder: false,								 
								selectedColor: "white",								
								onNodeSelected: function(event, data){									
									 $scope.org.parfolderid = data.id;									 									 
									 $scope.org.nodeparfolderid = data.nodeId;	
									 $scope.org.selectedObj=data.access;		
									 console.log(data);
									 $scope.org.projectfolderName=data.text;						 									 
									 $('.folder-main-container .right-panel').addClass('open');
									 
									 $scope.showFiles();
									// alert('sel');
									 
								},
									
								onNodeUnselected: function(event, data){
									//return false;
									//$scope.org.lastselected=data.nodeId; 
									//$('.folder-tree-wrapper #folder-treeview').treeview('selectNode',data.nodeId);
									 $scope.org.parfolderid ='0';
									 $scope.org.nodeparfolderid = "";
									 $scope.org.projectfolderName="";
									 $scope.org.selectedObj=0;
									 $scope.showFiles();
									// alert('usel');
									 //console.log('unsel');			
									 //$scope.showFiles();						 									 
									$('.folder-main-container .right-panel').addClass('open');
								}
							});
							
							
							
							
							if(e==1){
								//alert(nm);
								$('.folder-tree-wrapper #folder-treeview').treeview('search', nm, {
								  ignoreCase: true,     // case insensitive
								  exactMatch: true,    // like or equals
								  revealResults: true,  // reveal matching nodes
								});
								$('.folder-tree-wrapper #folder-treeview').treeview('selectNode',lsid);
								
							}else{
								
								$('.folder-tree-wrapper #folder-treeview').treeview('selectNode',0);
								
							}
							 
						}
								
				});	
		
		
		
	} 
	 
	
	
	$scope.getFilesParent = function (e){
		
		
		return $scope.org.parfolderid;
	};	
	
	$scope.doShare = function (){
		
		if($scope.org.currentrole=='view' || $scope.org.currentrole=='' || $scope.org.currentrole=='0' ){
			toastr["error"]("You have not access to share file!");	
		}	
		//alert($('.share-list-wrapper .selected').length);
		if($('.share-list-wrapper .selected').length==0){
			toastr["error"]("Please select user to share file!");	
		}
		
		var shusers=[]
		var ctr=0;;
		$( ".share-list-wrapper .selected" ).each(function( index ) {
		   shusers[ctr++]=$( this ).attr('data-id');		  
		});		
		
		var uri=URL + '/sharefile';
				$http.post(uri,{shared:$scope.org.currentFileID,usersval:shusers}).success(function(data, status) {
					
					if(data.status=='error')	{						 	
							toastr["error"](data.message);			 
							return false;
					 }else{
						 $scope.showFiles();
						 $('#sharedID').val('');
						 $('.share-list-wrapper a').removeClass('selected');
						 $("#shareFileModal").modal("hide");
						 toastr["success"](data.message);			 
					}
					
				});
		
		
		
		return $scope.org.parfolderid;
	};	
	
	$scope.getFilesAccess = function (e){
		if($scope.org.orgId==0 || $scope.org.project_id==0){
		  return -1;	
		}
		
		if($scope.org.parfolderid==0){
		  return -2;	
		}
		
		return $scope.org.selectedObj;
	};	
	
	$scope.editFiles = function(){
		if (!gSelectedFile) return;
		var selectedTr = gSelectedFile;		
		var fname=selectedTr.find('.filename-edit').val();
		 
		if($scope.org.currentrole=='upload' ){
			if($scope.org.filerole!=1){
				toastr.options = {"positionClass": "toast-top-center"};	
				toastr["error"]("You have not access to rename file!");					
				return false;	
			}
		}else if($scope.org.currentrole=='admin' ){
			// do overr
		}else{	
			 
			toastr.options = {"positionClass": "toast-top-center"};	
			toastr["error"]("You have not access to rename file!");			 
			return false;
		}
		if($.trim(fname)==''){
			toastr.options = {"positionClass": "toast-top-center"};	
			toastr["error"]("Please enter file name!");	
			 return false;
		}
		
		var uri=URL+"/renamefiles";	
				$http.post(uri,{files:fname, fid:$scope.org.currentFileID}).success(function(data, status) {
					 if(data.status=='error')	{
						 toastr[data.status](data.message);
							//selectedTr.find('.filename-edit').val(selectedTr.find('.filename-disp').html());				
							selectedTr.find('.filename-edit').attr('data-id',selectedTr.find('.filename-disp').html());				
							//selectedTr.find('.filename-edit').css('display', 'none');
							//selectedTr.find('.filename-disp').css('display', 'block');
					 }else{
							toastr[data.status](data.message);
							selectedTr.find('.filename-disp').html(selectedTr.find('.filename-edit').val());
							selectedTr.find('.filename-edit').attr('data-id',selectedTr.find('.filename-edit').val());
							selectedTr.find('.filename-edit').css('display', 'none');
							selectedTr.find('.filename-disp').css('display', 'block');
					}
				});
		
		
		
		
		
	},
	
	$scope.copyFiletoDB = function (){
		if( $scope.org.currentrole!='admin' ){
							toastr.options = {"positionClass": "toast-top-center"};	
							toastr["error"]("You have not access to copy file!");			 
							return false;
		}
		if($.trim($('#copyfilt').val())==''){
			toastr.options = {"positionClass": "toast-top-center"};	
			toastr["error"]("Please enter file name!");	
			 return false;
		}
		var uri=URL + '/copyfile';
				$http.post(uri,{src:$scope.org.currentFileID,des:$.trim($('#copyfilt').val())}).success(function(data, status) {
					
					if(data.status=='error')	{						 	
							toastr["error"](data.message);			 
							return false;
					 }else{
						 $scope.showFiles();
						 $('#copyfilt').val('');
						 $("#copyFileModal").modal("hide");
						 toastr["success"](data.message);			 
					}
					
				});
		
	},	
	$scope.copyFile = function (){
		if( $scope.org.currentrole!='admin' ){
							toastr.options = {"positionClass": "toast-top-center"};	
							toastr["error"]("You have not access to copy file!");			 
							return false;
		}	
		if($scope.org.currentFileID==0){
				toastr.options = {"positionClass": "toast-top-center"};	
				toastr["error"]("Please select file to copy!");			 
				return false;
		}
			showCopyFileModal();
	},	
	$scope.downloadFile = function (){
		if($scope.org.currentrole=='upload' || $scope.org.currentrole=='download' || $scope.org.currentrole=='admin' ){
			
			if($scope.org.currentFileID==0){
				toastr.options = {"positionClass": "toast-top-center"};	
				toastr["error"]("Please select file to download!");			 
				return false;
			}
			
			var uri=URL + '/download?check=1&file='+$scope.org.currentFileID;
				$http.get(uri,{}).success(function(data, status) {
					 if(data.status=='error')	{
						 toastr.options = {"positionClass": "toast-top-center"};	
							toastr["error"]("You have not access to download file!");			 
							return false;
					 }else{
						 window.location.href=URL + '/download?file='+$scope.org.currentFileID;						 
					}
				});
			
			//window.location.href=URL + '/download?file='+$scope.org.currentFileID;
		}else{
			toastr.options = {"positionClass": "toast-top-center"};	
			toastr["error"]("You have not access to download file!");			 
			return false;
		}
	},
	
	$scope.deleteFile = function (){
		 if($scope.org.currentrole=='upload' ){
			if($scope.org.filerole!=1){
				toastr.options = {"positionClass": "toast-top-center"};	
				toastr["error"]("You have not access to delete file!");					
				return false;	
			}
		}else if($scope.org.currentrole=='admin' ){
			// do overr
		}else{	
			 
			toastr.options = {"positionClass": "toast-top-center"};	
			toastr["error"]("You have not access to delete file!");			 
			return false;
		}
			 
		
		
				var uri=URL+"/deletefiles";	
				$http.post(uri,{fid:$scope.org.currentFileID}).success(function(data, status) {
					 if(data.status=='error')	{
						 toastr[data.status](data.message);
					 }else{
						 
						 $scope.showFiles($scope.org.fileParent);
						 toastr["success"]("Files has been deleted successfully");
						  $("#deleteFileModal").modal("hide");
					}
				});
				
			
	
		
	},	
	
	$scope.showFiles = function (){
		
		
		$scope.org.filerole=0;
		$scope.org.currentFileID='0';
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
			var uri=URL+"/showfiles?folder="+ $scope.org.parfolderid;			
			$http.get(uri).success(function(data, status) {
				$scope.filesdata=data.result;
				
				
				
				
				
				
			});	
		
	};
	
	$scope.showFolders();
	
});	
	






$(document).ready(function() {
	
	
	
	
	
	
    /* Folder Treeview (By Gleb C.) */
    initialFolderTreeview();

    /* Custom tooltip (By Gleb C.) */
    $('.file-operate-wrapper a').tooltipster({
        theme: 'tooltipster-light'
    });
    
    $('body').on('click','#folder-treeview .list-group li',function(){
	 
		 alert('clicked');
	});

    /* File list select/deselect (By Gleb C.) */
    $('.folder-main-container').on('mousedown',' .right-panel tbody tr' , function(e) {
        var selectedTr = $(this);        
       
        if (e.button == 0 || e.button == 2) {
			
			var currole=angular.element('#crtlid').scope().getCurrentRole();
		//	alert(currole);
			if(currole=='view'){
				$('#context-menu').hide();
			  return false;
			}
			
			angular.element('#crtlid').scope().selectFile($(this).attr('data-id'),$(this).attr('data-access'),$(this).attr('data-shared'));
			angular.element('#crtlid').scope().$apply();
			
            //process already opend edit box
            if (!$(this).hasClass('selected')) {
                editFileEnd();
            }

            $('.folder-main-container .right-panel tr').removeClass('selected');
            $(this).addClass('selected');
            gSelectedFile = $(this);
        }
    });
    
   

    //$('.folder-main-container .right-panel tbody input').keydown(function(e) {
    /*$('.folder-main-container').on('keydown', '.right-panel tbody input', function(e) {
		
        if (e.keyCode == 13){
			var ret=angular.element('#crtlid').scope().selectFile($(this).val());
        }
    });*/

    /* file share icon click (By Gleb C.) */
    $('#shareFileModal').on('click',' .share-list-wrapper a',function() {
        $(this).toggleClass('selected');
    });

    /* File move select (By Gleb C.) */
    $(document).on('click', '#moveFileModal .move-file-wrapper li', function() {
        if (!$(this).hasClass('selected')) {
            $('#moveFileModal .move-file-wrapper li').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    //alert($('.right-panel').height());
    $('#fine-uploader-gallery').height($('.right-panel').height());
    $('.qq-uploader').css('height',$('.right-panel').height());
    
    
    $('.right-panel').on('dragover', function(e) {
		$('#fine-uploader-gallery').show();
		$('.folder-main-container .right-panel').css('border','2px dashed #00A6BA')
	});
	
	$('.right-panel').on('dragleave', function(e) {
		dragTimer = window.setTimeout(function() {
			$('#fine-uploader-gallery').hide();
			//$('#fine-uploader-gallery').css('opacity','1');
			$('.folder-main-container .right-panel').css('border','none')
		}, 2000);
	});
    	
	galleryUploader = new qq.FineUploader({
		element: document.getElementById("fine-uploader-gallery"),
		template: 'qq-template-gallery',
		
		request: {
			endpoint: URL + '/upload-file',
			 
			method: 'POST' // Only for the gh-pages demo website due to Github Pages limitations
		},
		thumbnails: {
			placeholders: {
				waitingPath: URL + '/assets/img/waiting-generic.png',
				notAvailablePath: URL + '/assets/img/not_available-generic.png'
			}
		},
		validation: {
			  sizeLimit: 1073741824*2
		},
		callbacks: {
			onSubmit: function(id, name) {
			
					var role=angular.element('#crtlid').scope().getFilesAccess();
					var parfolder =angular.element('#crtlid').scope().getFilesParent();					
					angular.element('#crtlid').scope().$apply() ; 
					$('#fine-uploader-gallery').hide();
					if(role==1 || role==2){
						 
						 galleryUploader.setParams({'folder':parfolder});
						 var pos=name.lastIndexOf(".");
						 var ext = name.substr(parseInt(pos)+1);
						 //alert(ext);
						 var addloders ='<tr id="fid'+ id +'"><td class="filename exe '+ ext +'">' + name  + '</td><td class="file-status"><span class="fstatus" style="font-size: 12px!important;"></span><img class="process" src="'+ URL + '/assets/images/folderloder.gif" alt=""> <img style="display:none" class="success" src="'+ URL + '/assets/images/success-icon.png" alt=""> <img style="display:none" class="error" src="'+ URL + '/assets/images/error-icon.png" alt=""></td></tr>';
						
						
						$('.uploadprogress').prepend(addloders);
						var count=parseInt($('.file-status .process:visible').size());
						if(count==0) count++;
						$('.file-process-popup .nooffileupload').html('Uploading ' + (count) + ' files');						
						$('.file-process-popup').show();
						 
					}else if(role==-1){
						
					  	toastr.options = {"positionClass": "toast-top-center"};	
						toastr["error"]("Please select dataroom or project");
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
			
			onComplete: function(id, fileName, responseJSON) {
				 //console.log(id);
				if(responseJSON.success==true){
					
						angular.element('#crtlid').scope().showFiles(angular.element('#crtlid').scope().getFilesParent());
						angular.element('#crtlid').scope().$apply(); 
						$('#fid'+id + ' .process').hide();
						$('#fid'+id + ' .error').hide();						
						$('#fid'+id + ' .success').show();						
						$('#fid'+id + ' .fstatus').html('')
						if($('.file-status .process:visible').size()>0){
							$('.file-process-popup .nooffileupload').html('Uploading ' + (parseInt($('.file-status .process:visible').size())) + ' files');	
						}else if($('.file-status .success:visible').size()>0){
							$('.file-process-popup .nooffileupload').html( (parseInt($('.file-status .success:visible').size())) + ' files uploaded');		
						}else{
							$('.file-process-popup .nooffileupload').html( (parseInt($('.file-status .error:visible').size())) + ' files failed');		
						}
						
						
						
						
						//toastr.options = {"positionClass": "toast-top-center"};	
						//toastr["success"](responseJSON.message);	
						window.setTimeout($('.qq-file-id-'+id).remove(), 4000);
						
					}else{
						
						$('#fid'+id + ' .process').hide();
						$('#fid'+id + ' .success').hide();
						$('#fid'+id + ' .error').show();
						$('#fid'+id + ' .fstatus').html('<span style="color:#F7821E; font-size:11px">Failed </span>');
						if($('.file-status .process:visible').size()>0){
							$('.file-process-popup .nooffileupload').html('Uploading ' + (parseInt($('.file-status .process:visible').size())) + ' files');	
						}else if($('.file-status .success:visible').size()>0){
							$('.file-process-popup .nooffileupload').html( (parseInt($('.file-status .success:visible').size())) + ' files uploaded');		
						}else{
							$('.file-process-popup .nooffileupload').html( (parseInt($('.file-status .error:visible').size())) + ' files failed');		
						}
						if(responseJSON.error==9){
							toastr.options = {"positionClass": "toast-top-center"};	
							toastr["error"](responseJSON.message);	
						}
					}
				
			},
			onProgress: function(id, fileName, loaded, total) {
				if (loaded < total) {
				progress = Math.round(loaded / total * 100) + '% of ' + Math.round(total / 1024) + ' kB';
					$('#file-' + id).removeClass('alert-info')
									.html('<img src="'+ URL +'/assets/css/loading.gif" alt="In progress. Please hold."> ' +
										  'Uploading ' +
										  '“' + fileName + '” ' +
										  progress);
				  } else {
					$('#file-' + id).addClass('alert-info')
									.html('<img src="'+ URL +'/assets/css/loading.gif" alt="Saving. Please hold."> ' +
										  'Saving ' +
										  '“' + fileName + '”');
				  }
			},
			
			
		},
		debug: true
		});
    
    if($('#userProject option:selected').val()==0){
		
		$('.breadcrumb-header').html('<dl><a href="'+ URL +'/dataroom/view">'+ $("#userOrganization option:selected").text()  +'</a></dl>');
	}else{
		$('.breadcrumb-header').html('<dl><a href="'+ URL +'/dataroom/view">'+ $("#userOrganization option:selected").text()  +'</a></dl><dl><a href="'+ URL +'/project/view">'+ $('#userProject option:selected').text() +'</a></dl>');
	}
	
	$('body').on('click','.task',function(){
		
		$('.task').removeClass('selected');
		$(this).addClass('selected');
		
	});

	$(window).resize(function(){resizeFolderWrapper()});
});

/*=============By Gleb C.=============*/
function userDetailPopup () {
    $('.workflow-draggable-menu').toggleClass('workflow-draggable-menu-open');
    $('.workflow-draggable-menu-content').toggleClass('workflow-draggable-content-open');
}

function editUserCard() {
    $('.manager-user-content .user-role-dropdown').css('display', 'block');
    $('.manager-user-content .user-card-role').css('display', 'none');
}

function userDetailSave() {
    $('.manager-user-content .user-role-dropdown').css('display', 'none');
    $('.manager-user-content .user-card-role').css('display', 'block');
    $('.manager-user-content .user-card-role').html($('.manager-user-content .user-role-dropdown').val());
}

function toggleFolderSearch() {
    if ($('.search-wrapper').css('display') == 'none') {
        $('.search-wrapper').css('display', 'block');
        $('.folder-header .collapse-btn').removeClass('open');
        $('.folder-header .collapse-wrapper').removeClass('open');
    }
    else {
        $('.search-wrapper').css('display', 'none');
        $('.folder-header .collapse-btn').addClass('open');
        $('.folder-header .collapse-wrapper').addClass('open');
    }
    resizeFolderWrapper();
}

function resizeFolderWrapper() {
    if ($(window).width() > 776) {
        $('.folder-main-container').css('height', $(window).height() - $('.header').outerHeight() - $('.second-header').outerHeight());
        $('.folder-main-container').css('margin-top', $('.header').outerHeight() + $('.second-header').outerHeight());
    } else {
        $('.folder-main-container').css('height', $(window).height() - $('.header').outerHeight());
        $('.folder-main-container').css('margin-top', $('.header').outerHeight());
    }
}

function toggleLeftFolderPanel() {
    $('.folder-main-container').toggleClass('closed');
}

function minFileProcPopup() {
    $('.file-process-popup').toggleClass('min-popup');
}

function closeFileProcPopup() {
	var flag=false;
	$(".file-status").each(function(){
		 console.log($(this).find('.process').css('display'));
		 if($(this).find('.process').css('display')=='block' || $(this).find('.process').css('display')=='inline'){
			 swal({   title: "Are you sure to cancel?",   
				text: "You will not be able to recover this imaginary file!",   
				type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   
				confirmButtonText: "Yes, cancel it!",   closeOnConfirm: true }, function(){   
					
					galleryUploader.cancelAll();
					$('.file-process-popup tbody').html('');
					$('.file-process-popup').hide();
				});
				flag=true;
				return false;
	
		 }
		 
	});
	if(flag==false){
		//alert('hide')
		$('.file-process-popup tbody').html('');
		$('.file-process-popup').hide();
	}
	
	
	
    
}



function initialFolderTreeview() {
    
	
    $('.folder-tree-wrapper #folder-treeview').treeview({
							data: angular.element('#crtlid').scope().getFolderData(),
							expandIcon: 'glyphicon glyphicon-chevron-right',
							collapseIcon: 'glyphicon glyphicon-chevron-down',
							nodeIcon: 'glyphicon glyphicon-folder-close',
							selectedBackColor: "#00a6bc",
							showBorder: false,
							selectedColor: "white",
							onNodeSelected: function(event, data){
								//if the screen is mobile, open the right panel like popup
								$('.folder-main-container .right-panel').addClass('open');
							}
						});
    resizeFolderWrapper();
}

function editFileStart() {
    if (!gSelectedFile){
				toastr.options = {"positionClass": "toast-top-center"};	
				toastr["error"]("Please select file to edit!");			 
				return false;	
	}

    var selectedTr = gSelectedFile;
    selectedTr.find('.filename-edit').val(selectedTr.find('.filename-edit').attr('data-id'));
    var text=selectedTr.find('.filename-edit').attr('data-id').lastIndexOf('.');
    console.log(text);
    selectedTr.find('.filename-edit').css('display', 'block');
    selectedTr.find('.filename-edit').focus(); 
	if(text>-1){
		selectedTr.find('.filename-edit')[0].setSelectionRange(0,text);
	}else{
		selectedTr.find('.filename-edit').select();
	}
    selectedTr.find('.filename-disp').css('display', 'none');
    
}

function editFileEnd() {
    if (!gSelectedFile) return;

    var selectedTr = gSelectedFile;
    //selectedTr.find('.filename-disp').html(selectedTr.find('.filename-edit').val());
    selectedTr.find('.filename-edit').css('display', 'none');
    selectedTr.find('.filename-disp').css('display', 'block');
}

function showDeleteFileModal() {
     
	 if (!gSelectedFile){
				toastr.options = {"positionClass": "toast-top-center"};	
				toastr["error"]("Please select file to delete!");			 
				return false;	
	}	
	
    $('#deleteFileModal').modal();
}

function showShareFileModal () {
     if (!gSelectedFile){
				toastr.options = {"positionClass": "toast-top-center"};	
				toastr["error"]("Please select file to share!");			 
				return false;	
	}
	var sid=angular.element('#crtlid').scope().getShareLink();
	
	$('#sharedID').val(URL + '/folder/shared?users='+ sid);
    $('#shareFileModal').modal();
}

 
function showCopyFileModal() {
    if (!gSelectedFile) return;
    var parts = gSelectedFile.find('.filename-edit').val().split('.');
    var ext = parts[parts.length - 1];
    var filename = parts.slice(0, parts.length - 1).join(".");
    $('#copyFileModal .modal-body input').val(filename + "_Copy." + ext);
    $('#copyFileModal').modal();
}

function showMoveFileModal() {
    if (!gSelectedFile) return;
    $('#moveFileModal').modal();
}

function getRelatedFolder(type) {
    //will get parent folder list from api
    //this is example
    var folder = [];
    if (type == 'parent') {
        folder = [
            {hasParent: false, hasChild: true, name: 'Parent 1'},
            {hasParent: false, hasChild: false, name: 'Parent 2'},
            {hasParent: false, hasChild: false, name: 'Parent 3'}
        ];
    } 
    else if (type == 'child') {
        folder = [
            {hasParent: true, hasChild: false, name: 'Child 1'},
            {hasParent: false, hasChild: false, name: 'Child 2'},
            {hasParent: false, hasChild: false, name: 'Child 3'}
        ];
    }

    var html = '<div class="move-file-wrapper"><ul>';
    for (var i = 0; i < folder.length; i++) {
        var class_name= '';
        if (folder[i].hasParent)  class_name += ' has-parent';
        
        if (folder[i].hasChild)   class_name += ' has-child';

        html += '<li class="' + class_name + '">';
        html += '<a class="back" href="javascript:getRelatedFolder(\'parent\');"><i class="glyphicon glyphicon-chevron-left"></i></a>';
        html += folder[i].name;
        html += '<a class="forward" href="javascript:getRelatedFolder(\'child\');"><i class="glyphicon glyphicon-chevron-right"></i></a>';
        html += '</li>';
    }
    html += '</ul></div>';

    $('#moveFileModal .move-file-wrapper').animate({
        opacity: 0
    }, 300, function() {
        $(this).remove;
        $('#moveFileModal .modal-body').html(html);
    });
}


function closeRightPanel() {
    $('.folder-main-container .right-panel').removeClass('open');
}
