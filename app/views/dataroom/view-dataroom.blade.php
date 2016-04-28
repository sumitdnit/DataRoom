@extends('layouts.protected')
@section('content')
{{HTML::script('assets/js/append-dataroom.js')}}
<style type="text/css">
.centered
{
    text-align:center;
}</style>
<section class="main-wrapper" ng-app="ravabe" ng-controller="ListofRooms">
  <div class="row">
    <div class="col-md-6 col-dataroom" > 
      {{Form::open(array('url'=> 'dataroom/update','name'=>'dataroomupdate','id'=>'dataroomupdate'))}}
      <input type="hidden" value="" name="_token">
      <input type="hidden" value="" name="varDataRoomId" id="varDataRoomId">
      <input type="hidden" value="" name="varDataRoomUserId" id="varDataRoomUserId">
      <input type="hidden" value="" name="varDataRoomRole" id="varDataRoomRole">
      {{Form::close()}}
      {{Form::open(array('url'=> 'dataroom/delete','name'=>'dataroomdelete','id'=>'dataroomdelete'))}}
      <input type="hidden" value="" name="_token">
      <input type="hidden" value="" name="DataRoomId" id="DataRoomId">
      <input type="hidden" value="" name="DataRoomUserId" id="DataRoomUserId">
      <input type="hidden" value="" name="DataRoomRole" id="DataRoomRole">
      {{Form::close()}}
      <div class="dataroom-wrapper">
        <div class="dataroom-add dataroom-drop-shadow"> <a class="add-btn" href="{{url('dataroom/add')}}"><span class="plscircle"><i class="glyphicon glyphicon-plus"></i></span><h4 class="titleaddlink" ><?php echo Lang::get('messages.label_add');?> <?php echo Lang::get('messages.middle_header_link_dataroom');?></h4></a> </div>
        <div class="dataroom-list">
          <div id="data-<% dataroom.id %>" class="dataroom-unit dataroom-drop-shadow <% dataroom.over_ride %> clearfix" ng-repeat="(index,dataroom) in alerts"> <!--class -> active -->
            
            <div class="dataroomunitwrap" ng-click="showProjectsss(dataroom.encyptid)">
              <div class="title-wrapper">
                <div class="title">
                  <% dataroom.name %>
                </div>
                <div class="sub-title">
                  <% dataroom.user_name %>
                </div>
              </div>
			 <a href="{{url('/users?did=')}}<%dataroom.encyptid%>" title="User">
			  <div class="project-qty">
				<% dataroom.user_count %>
			  </div>
			  </a>
              <div class="update-wrapper">
                <div class="title"><?php echo Lang::get('messages.last_updated');?></div>
                <div>
                  <% dataroom.updated_at %>
                </div>
              </div>
            </div>
			
            <div class="testsetting">
              <div class="setting-wrapper"> <a href="javascript:void(0);"><img src="{{ URL::asset('assets/img/setting-icon.png') }}" title="Setting" alt=""></a> </div>
            </div>
            
            <!-- Inner section for on click project room start -->
            <div class="utility-box">
              <ul>
                <li ng-if="'admin'== dataroom.currentuserType" class="editutility"><a href="javascript:void(0)"> <i class="fa fa-pencil-square-o"></i> <?php echo Lang::get('messages.label_edit');?></a></li>
                <li ng-if="'admin'== dataroom.currentuserType" class="copyutility"><i class="fa fa-clone"></i> <?php echo Lang::get('messages.label_copy');?></li>
                <li class="shareutility"><a href="javascript:void(0)"> <i class="fa fa-share-alt"></i> <?php echo Lang::get('messages.label_share');?></a></li>
                <li ng-if="'admin'== dataroom.currentuserType" class="delutility"><a href="javascript:void(0)"> <i class="fa fa-times-circle"></i> <?php echo Lang::get('messages.label_delete');?></a></li>
              </ul>
              <div class="info" style="display:none;">
                <div class="id">
                  <% dataroom.id %>
                </div>
                <div class="uid">
                  <% dataroom.user_id %>
                </div>
                <div class="datarole">
                  <% dataroom.role %>
                </div>
                <div class="over_ride_value">
                  <% dataroom.over_ride %>
                </div>
              </div>
            </div>
            <div class="clearfix CopyFile">
              <div class="closeCopyFile"><a href="#"><i class="fa fa-times"></i></a></div>
              <div class="utility-popup-title"><?php echo Lang::get('messages.copy_file');?> </div>
              <hr>
              <div class="fldr-title"><?php echo Lang::get('messages.middle_header_link_dataroom');?></div>
              <div class="fldrsubmitTxt">
                <input type="text" name="copyDataRoom" class="copyDataRoom submitnameFolder" value="<% dataroom.name %> - 1" />
              </div>
              <div class="content left">
                <div class="fldr-title"><?php echo Lang::get('messages.copy_content_with_structure');?>
                  <input type="checkbox" class="CopyWithfiles cbx cbx1" name="CopyWithfiles">
                </div>
              </div>
              <button did = "<% dataroom.id %>" diden = "<% dataroom.encyptid %>" type="button" onclick="CopyDRoom(this);" class="btn btn-lg btn-primary btn-red pull-right utilitybtn dataroomutilitybtn"><?php echo Lang::get('messages.label_copy');?></button>
            </div>
            <div class="utility-popup sutility clearfix">
              <div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>
              <div class="utility-popup-title"><?php echo Lang::get('messages.label_share');?> </div>
              <hr>
              <div class="fldr-title"><?php echo Lang::get('messages.copy_link');?>:</div>
              <div class="fldrsubmitTxt">
                <div id="selectable" class="submitnameFolder submitautofocus" >{{ url('project/view?d=') }}
                  <% dataroom.encyptid %>
                </div>
                <p class="member-visible"><i class="fa fa-lock" aria-hidden="true"></i> <?php echo Lang::get('messages.msg_visible_members');?> </p>
              </div>
            </div>
            
            <!-- Inner section for on click project room end --> 
            
          </div><br>
          <div class="centered">
          <button class="btn btn-success" ng-show="ismore==1" ng-click="loadmore()"><?php echo Lang::get('messages.msg_load_more');?></button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-project">
      <div class="project-wrapper"> 
        <!--<div class="dataroom-cursor"><i class="glyphicon glyphicon-triangle-left"></i></div>-->
        <div ng-show="projectView==1">
          <div class="project-add"> <a class="add-btn" href="{{url('project/add-project?d=')}}<%dataRoomEn%>"><span class="plscircle"><i class="glyphicon glyphicon-plus"></i></span><h4 class="titleaddlink" style="color:#000"><?php echo Lang::get('messages.label_add_project');?> </h4></a> </div>
          <div class="project-unit clearfix <%proroom.over_ride%>" ng-repeat="(index,proroom) in proInfos">
            <div class="dataroomunitwrap" room-en="<% proroom.encyptid %>">
              <div class="title-wrapper">
                <div class="title">
                  <%proroom.name%>
                </div>
                <div class="sub-title">
                  <%proroom.user_name%>
                </div>
              </div>
			  <a href="{{url('/users?pid=')}}<% proroom.encyptid %>" title="User">
              <div class="project-qty">
                <%proroom.user_count%>
              </div>
			  </a>
              <div class="update-wrapper">
                <div class="title"><?php echo Lang::get('messages.last_updated');?></div>
                <div>
                  <%proroom.updated_at%>
                </div>
              </div>
            </div>
            <div class="testsetting">
              <div class="setting-wrapper"> <a href="javascript:void(0)"><img src="{{ URL::asset('assets/img/setting-icon.png') }}" title="Setting" alt=""></a> </div>
              <div class="utility-box">
                <ul>
                  <li ng-if="'admin'== proroom.currentuserType" class="editutility"><a href="{{ url('project/edit?p=') }}<% proroom.encyptid %>"> <i class="fa fa-pencil-square-o"></i> <?php echo Lang::get('messages.label_edit');?></a></li>
                  <li ng-if="'admin'== proroom.currentuserType" class="copyutility"><a href="javascript:void(0);"> <i class="fa fa-clone"></i> <?php echo Lang::get('messages.label_copy');?></a></li>
                  <li class="shareutility"><a href="javascript:void(0);"> <i class="fa fa-share-alt"></i> <?php echo Lang::get('messages.label_share');?></a></li>
                  <li ng-if="'admin'== proroom.currentuserType" class="delutility" ng-click="delProroom(proroom.encyptid,proroom.dataroomid)" id="delProject" proj-id="<% proroom.encyptid %>"><i class="fa fa-times-circle"></i><?php echo Lang::get('messages.label_delete');?></li>
                </ul>
              </div>
              <div class="clearfix CopyFile">
                <div class="closeCopyFile"><a href="#"><i class="fa fa-times"></i></a></div>
                <div class="utility-popup-title"><?php echo Lang::get('messages.copy_file');?></div>
                <hr>
                <div class="fldr-title"><?php echo Lang::get('messages.label_project');?></div>
                <div class="fldrsubmitTxt">
                  <input type="text" name="copyProject" class="copyDataRoom submitnameFolder" value="<%proroom.name%> - 1" />
                </div>
                <div class="content left">
                  <div class="fldr-title"><?php echo Lang::get('messages.msg_copy_content_structure');?>
                    <input type="checkbox" class="CopyWithfiles cbx cbx1" name="CopyWithfiles">
                  </div>
                </div>
                <button did = "<% proroom.dataroom_id %>" pid = "<% proroom.id %>" type="button" onclick="CopyPRoom(this);" class="btn btn-lg btn-primary btn-red pull-right utilitybtn dataroomutilitybtn"><?php echo Lang::get('messages.label_copy');?></button>
              </div>
            </div>
            <div class="utility-popup sutility clearfix">
              <div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>
              <div class="utility-popup-title"><?php echo Lang::get('messages.label_share');?></div>
              <hr>
              <div class="fldr-title"><?php echo Lang::get('messages.copy_link');?>:</div>
              <div class="fldrsubmitTxt">
                <div id="selectable" class="submitnameFolder submitautofocus">{{ url('users/folder') }}</div>
                <p class="member-visible"><i class="fa fa-lock" aria-hidden="true"></i><?php echo Lang::get('messages.msg_visible_members');?> </p>
              </div>
            </div>
          </div>
        </div>
        <br>
            <div class="centered">
              <button class="btn btn-success" ng-show="isproject==1" ng-click="projectload()"><?php echo Lang::get('messages.msg_load_more');?></button>
            </div>
    </div>
    </div>
    <div class="project-wrapper-mobile"> <a href="javascript:closeProjectListDialog();" class="close-btn"><i class="glyphicon glyphicon-remove"></i></a>
      <div ng-show="projectView==1">
        <div class="project-add"> <a class="add-btn" href="{{url('project/add-project?d=')}}<%dataRoomEn%>"><span class="plscircle"><i class="glyphicon glyphicon-plus"></i></span><h4 class="titleaddlink" style="color:#000"><?php echo Lang::get('messages.label_add_project');?> </h4></a> </div>
        <div class="project-unit clearfix <%proroom.over_ride%>" ng-repeat="(index,proroom) in proInfos">
          <div class="dataroomunitwrap">
            <div class="title-wrapper">
              <div class="title">
                <%proroom.name%>
              </div>
              <div class="sub-title">
                <%proroom.user_name%>
              </div>
            </div>
			<a href="{{url('/users')}}" title="User">
            <div class="project-qty">
              <%proroom.user_count%>
            </div>
			</a>
            <div class="update-wrapper">
              <div class="title"><?php echo Lang::get('messages.last_updated');?></div>
              <div>
                <%proroom.updated_at%>
              </div>
            </div>
          </div>
          <div class="testsetting">
            <div class="setting-wrapper"> <a href="javascript:void(0)"><img src="{{ URL::asset('assets/img/setting-icon.png') }}" title="Setting" alt=""></a> </div>
            <div class="utility-box">
              <ul>
                <li ng-if="'admin'== proroom.currentuserType" class="editutility"><a href="{{ url('project/edit?p=') }}<% proroom.encyptid %>"> <i class="fa fa-pencil-square-o"></i> <?php echo Lang::get('messages.label_edit');?></a></li>
                <li ng-if="'admin'== proroom.currentuserType" class="copyutility"><a href="javascript:void(0)"> <i class="fa fa-clone"></i>  <?php echo Lang::get('messages.label_copy');?></a></li>
                <li class="shareutility"><a href="javascript:void(0)"> <i class="fa fa-share-alt"></i>  <?php echo Lang::get('messages.label_share');?></a></li>
                <li ng-if="'admin'== proroom.currentuserType" class="delutility" ng-click="delProroom(proroom.encyptid,proroom.dataroomid)" id="delProject" proj-id="<% proroom.encyptid %>"><i class="fa fa-times-circle"></i> <?php echo Lang::get('messages.label_delete');?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
$(document).ready(function(){
	
	$(document).on("click", ".dataroom-unit .testsetting", function(e) {
				
		//$('.utility-box').css({"display":"none"});
		//$('.utility-box').animate({height: "0px"});
		$('.dataroom-unit').removeClass('active arrow-data');
		
		$(this).next('.utility-box').animate({height: "100%"});
		$(this).next('.utility-box').css({"display":"block"});
		$(this).parent().addClass('active arrow-data');
		$('.copyutility').on("click",function(e){			
			e.stopPropagation();
			$(this).parent('ul').parent('.utility-box').siblings('.CopyFile').show();
			$('.mutility').hide();
			$('.sutility').hide();			
		});
		$('.closeutilityPopup a').on("click",function(e){
			e.stopPropagation();
			$('.cutility').hide();			
		});

		$('.closeutilityPopup a').on("click",function(e){
			e.stopPropagation();
			$('.mutility').hide();			
		});
		$('.editutility').on("click",function(e){
			e.stopPropagation();
			$(this).parents('.utility-box').find('.cutility').hide();
			$(this).parents('.utility-box').find('.mutility').hide();
			$(this).parents('.utility-box').find('.sutility').hide();	
			
			/*code for edit informations*/
			var varDataRoomId = $(this).parents('.utility-box').find('.info').find('.id').html();			
			$("#varDataRoomId").val(varDataRoomId);
			var varDataRoomUserId = $(this).parents('.utility-box').find('.info').find('.uid').html();
			$("#varDataRoomUserId").val(varDataRoomUserId);
			var varDataRoomRole = $(this).parents('.utility-box').find('.info').find('.datarole').html();
			$("#varDataRoomRole").val(varDataRoomRole);
			$("#dataroomupdate").submit();
			/* end code for edit informations*/
		});
		$('.delutility').on("click",function(e){
			e.stopPropagation();
			$(this).parents('.utility-box').find('.cutility').hide();
			$(this).parents('.utility-box').find('.mutility').hide();
			$(this).parents('.utility-box').find('.sutility').hide();	
			
			/*code for edit informations*/
			var DataRoomId = $(this).parents('.utility-box').find('.info').find('.id').html();			
			$("#DataRoomId").val(DataRoomId);
			//alert(varDataRoomId);
			var DataRoomUserId = $(this).parents('.utility-box').find('.info').find('.uid').html();
			$("#DataRoomUserId").val(DataRoomUserId);
			//alert(varDataRoomUserId);
			var DataRoomRole = $(this).parents('.utility-box').find('.info').find('.datarole').html();
			$("#DataRoomRole").val(DataRoomRole);
			//alert(varDataRoomRole);
			swal({   
				title: "<?php echo Lang::get('messages.msg_are_u_sure');?>",   
				text: "<?php echo Lang::get('messages.msg_not_able_to_recover_dataroom');?>!",   
				type: "warning",   
				showCancelButton: true,
				cancelButtonText: "<?php echo Lang::get('messages.label_cancel');?>", 				
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "<?php echo Lang::get('messages.msg_delete_it');?>" 
			}, 
			function(){
				$("#dataroomdelete").submit();
				/* end code for edit informations*/
				
			});
		});
		
		
		$('.shareutility').on("click",function(e){
			e.stopPropagation();
			$(this).parent('ul').parent('.utility-box').siblings('.sutility').show();						
			$('.mutility').hide();
			$('.cutility').hide();	
			$('.CopyFile').hide();					
		});
		$('.closeutilityPopup a').on("click",function(e){
			e.stopPropagation();
			$('.sutility').hide();			
		});
		$('.closeCopyFile a').on("click",function(e){
			e.stopPropagation();
			$(this).parent('.closeCopyFile').parent('.CopyFile').hide();					
		});
		
		$('.utility-popup').on("click",function(e){						
			//utilitybx = 1;			
			//$(this).show();
		//	$(this).animate({height: "100%"});
			//$(this).css({"display":"block"});
			//$(this).parent('ul').parent('.utility-box').siblings('.cutility').show();
			//console.log("aaaaaaaaaaaaaaaaaa");
		});
	});
	
	$('body,html').click(function(e) { 	
		$('.utility-box').animate({height: "0px"});
		$('.cutility').hide();
		$('.mutility').hide();
		$('.sutility').hide();
		$('.utility-box').hide();
		//$('.CopyFile').hide();
	});
		
});
	
	
	function CopyDRoom(current) {
		//CopyDRoom(this);
		CopyWithfiles  = 0;	
		$(current).parents('.CopyFile').find('.dataRoomError').attr("style","display:none");
		var did=$(current).attr('did');
		var pid=$(current).attr('pid');
		dName  = $(current).parents('.CopyFile').find('.copyDataRoom').val();	
		if($(current).parents('.CopyFile').find('.CopyWithfiles').prop("checked")) 
			CopyWithfiles  = 1;
		
		if(!dName) {				
				toastr.options = {"positionClass": "toast-top-center"};
				toastr['error']('<?php echo Lang::get('messages.msg_dataroom_required');?>'); 	
				$(current).parents('.CopyFile').find('.copyDataRoom').focus();
				return 0;
			}
			
	    nnName = parseInt(dName)*1;
	    if(dName==nnName) {				
				toastr.options = {"positionClass": "toast-top-center"};
				toastr['error']('<?php echo Lang::get('messages.msg_dataroom_not_numeric');?>'); 	
				$(current).parents('.CopyFile').find('.copyDataRoom').focus();
				return 0;
			}		
			
		if (did && dName) {
			$.ajax({
				type: "POST",
				url: '<?php echo URL::to('/')?>/copydataroom',
				data: { did: did,pid: pid,dName: dName,CopyWithfiles: CopyWithfiles},
				dataType: "json",
				success: function (response) {									
					toastr.options = {"positionClass": "toast-top-center"};
					toastr['success'](response.msg); 
					window.location=URL+'/dataroom/view-dataroom';				
				},
				error: function (response) {
					toastr.options = {"positionClass": "toast-top-center"};
					toastr['error'](response.msg); 
										
				}
			});
			} else {				
				toastr.options = {"positionClass": "toast-top-center"};
				toastr['error']('<?php echo Lang::get('messages.msg_try_again');?>..'); 	
			
			}
    }
    
    	function CopyPRoom(current) {
		
		CopyWithfiles  = 0;	
		$(current).parents('.CopyFile').find('.dataRoomError').attr("style","display:none");
		var did=$(current).attr('did');
		var pid=$(current).attr('pid');
		dName  = $(current).parents('.CopyFile').find('.copyDataRoom').val();		
		if($(current).parents('.CopyFile').find('.CopyWithfiles').prop("checked")) 
			CopyWithfiles  = 1;
		
		if(!dName) {				
				toastr.options = {"positionClass": "toast-top-center"};
				toastr['error']('<?php echo Lang::get('messages.msg_project_name_not_blank');?>'); 	
				$(current).parents('.CopyFile').find('.copyDataRoom').focus();
				return 0;
			}
			
			
	    nnName = parseInt(dName)*1;
	    if(dName==nnName) {				
				toastr.options = {"positionClass": "toast-top-center"};
				toastr['error']('<?php echo Lang::get('messages.msg_project_name_not_numeric');?>'); 	
				$(current).parents('.CopyFile').find('.copyDataRoom').focus();
				return 0;
			}		
				
			
		if (pid && did && dName) {
			$.ajax({
				type: "POST",
				url: '<?php echo URL::to('/')?>/copyproject',
				data: { did: did,pid: pid,dName: dName,CopyWithfiles: CopyWithfiles},
				dataType: "json",
				success: function (response) {									
					toastr.options = {"positionClass": "toast-top-center"};
					toastr['success'](response.msg); 
					window.location=URL+'/dataroom/view-dataroom?den='+response.den;				
				},
				error: function (response) {
					toastr.options = {"positionClass": "toast-top-center"};
					toastr['error'](response.msg); 
										
				}
			});
			} else {				
				toastr.options = {"positionClass": "toast-top-center"};
				toastr['error']('<?php echo Lang::get('messages.msg_try_again');?>..'); 	
			
			}
    }
</script> 
<script>
var URL='<?php echo URL::to('/')?>';
var varAreYouSure = '<?php echo Lang::get('messages.msg_are_u_sure');?>';
var varNotAbleToRecoverProject = '<?php echo Lang::get('messages.msg_not_able_for_recover_project');?>';
var varCancel = '<?php echo Lang::get('messages.label_cancel');?>';
var varDeleteIt = '<?php echo Lang::get('messages.msg_delete_it');?>';
var varmsgProjectDeletedSuccessfully = '<?php echo Lang::get('messages.msg_project_deleted_successfully');?>';
var dataID='<?php echo (isset($_GET['den']) && $_GET['den'] )? base64_decode($_GET['den']): '0';?>';
</script> 
<script type="text/javascript" src="{{ URL::asset('assets/js/data-project-rooms.js') }}"></script> 
@endsection
