@extends('layouts.protected')
@section('content')
<?php $edit=0; ?>
{{HTML::script('assets/js/jquery.fileupload/js/jquery.iframe-transport.js')}}
{{HTML::script('assets/js/jquery.fileupload/js/jquery.fileupload.js')}}
{{HTML::script('assets/js/jquery.fileupload/js/jquery.fileupload-process.js')}}
{{HTML::script('assets/js/jquery.fileupload/js/jquery.fileupload-validate.js')}}
<style> 
.showhide { display:none;}
.show { display:block;}
</style>
 <link href="<?php echo URL::to('/'); ?>/assets/css/ngautosuggest.css" type="text/css" rel="stylesheet" />
 {{HTML::script('assets/js/ngautosuggest.js')}}
<?php
	  	$frompro=0;
		$Dataroom 	  = Dataroom::where('id', $did)->first();
		$readonly = 0;
		$internalUserOnly = 0;
		
		if(sizeof($Dataroom)>0) {   
			$internalUserOnly = $Dataroom->internal_user; 
			$readonly = $Dataroom->view_only;
			if(!$readonly){
				$projectroom 	  = Project::where('id',base64_decode($proId))->first();
				$readonly = $projectroom->view_only;
				$frompro=1;
			}
		}

		?>
<script src="<?php echo URL::to('/'); ?>/assets/js/angular-sanitize.min.js"></script> 
<script src="<?php echo URL::to('/'); ?>/assets/js/invitation-project.js"></script>
<div id="client-room" class="main content">
  <div id="client-rooms" ng-app="ravabedata" ng-controller="ProjectInfo"class="add-room" >
   <div class="row">
      <div>
        <?php 
   $Dataroom 	  = Dataroom::where('id', $did)->first();
   $dname = '';
   $varGetDataRoomId = base64_encode($did);
   if(sizeof($Dataroom)>0) {   
   	$dname = ucfirst($Dataroom->name);
   }
    ?>
        <div class="breadcrumb-header" style="margin:0 15px 0 0;">
          <ul>
            <li><a href="{{url('dataroom/view-dataroom')}}"><?php echo Lang::get('messages.middle_header_link_dataroom');?></a></li>
            <?php if($dname ){ ?>
            <li><a href="{{url('dataroom/view-dataroom?den='.base64_encode($did))}}">{{$dname}}</a></li>
            <?php } ?>
            <li><a href="{{url('dataroom/view-dataroom?den='.base64_encode($did))}}"><%newproData.name%></a></li>
            <?php  ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="room">
      <h2><strong><?php echo Lang::get('messages.label_edit');?></strong> <?php echo Lang::get('messages.label_project');?></h2>
      <input type="hidden" name="addProjectRoom" ng-model="newproData.proid"  value="add" class="form-control">
	  <input type="hidden" ng-model="project.dataRoomId" name="dataRoomId" value="<%newproData.dataroom_id%>" >
      <div class="content content-form">
        <h3><?php echo Lang::get('messages.label_project_name');?></h3>
        <input type="text" id="dataRoom" name="projectRoom" ng-model="newproData.name"  placeholder="Project Name" required>
        <h3><?php echo Lang::get('messages.label_description');?></h3>
        <textarea name="description" ng-model="newproData.description" rows="4" placeholder="<?php echo Lang::get('messages.valid_msg_for_project_add');?>..."></textarea>
      </div>
      <div class="content content-form override">
        <h4><?php echo Lang::get('messages.label_override');?></h4>
       <input type="hidden" name="company" ng-model="newproData.company" id="company" onBlur="isUrlValid()" placeholder="www.youcompany.com">
        <h3><?php echo Lang::get('messages.domain_validation_msg');?></h3>
        <input type="text" name="domain_restrict" id="domain_restrict" onblur="isUrlDomain()" ng-model="newproData.domain_restrict"  placeholder="@yoursite.com">
        <div class="content left">
           <h3><?php echo Lang::get('messages.internal_user_valid_msg');?></h3>
          <input type="checkbox" id="unchecked1" class="cbx cbx1 hidden"  <?php if($internalUserOnly){?> checked="checked" <?php } ?> >
          <input type="hidden" name="internel_user" value="<?php echo $internalUserOnly;?>" id="internel_user" class="internel_user"/>
          <label for="unchecked1" class="lbl lbl1 clickChk"></label>
        </div>
        <div class="content right">
         <h3><?php echo Lang::get('messages.label_view_only');?></h3>
          <input type="checkbox" id="unchecked2" class="cbx cbx2 hidden"  <?php if($readonly){?> checked="checked" <?php } ?>>
          <input type="hidden" name="view_only" value="<?php echo $readonly;?>" id="view_only" class="internel_user view_only"/>
          <label for="unchecked2" class="lbl lbl2"></label>
        </div>
      </div>
      <div class="section-bottom" style="display:none;">
        <input id="fileupload" style="position:absolute; left:-9999px;" type="file" name="profile_pic" />
        <span class="filename pull-left profile_dropbox" id='profile_dropzone'>
        <div id="progress" class="progress">
          <div class="progress-bar progress-bar-success" ></div>
        </div>
        </span> <img src="{{URL::asset('assets/images/icon-logo.png')}}" id="dataroomlogo" height="40" width="40" style="float:left;"> <span class="profile_img_preview" >
        <input type="hidden" id="userprofile_picture" name="userprofile_picture" value="">
        </span> <span style="margin-right:30px;"><a href='javascript:void(0);' onclick="$('#fileupload').trigger('click')"  class="btn btn-default btn-file btn-generic">+ <?php echo Lang::get('messages.label_people');?></a></span> </span> </div>
      <div class="section-bottom">
        <div class="content content-form">
          <h2><strong><?php echo Lang::get('messages.label_add');?></strong> <?php echo Lang::get('messages.label_people');?></h2>
          <div id="AutocompleteSumit">
            <div class="section-ip">
              <div class="input-grouporg">
                <div class="angucomplete-holder">
                  <div angucomplete-alt
						  id="email"
						  placeholder="<?php echo Lang::get('messages.label_search_email');?>"
						  pause="100"
						  selected-object="selectedProject"
						  remote-url="<?php echo URL::to('/')?>/project/usernames"
						  remote-url-request-formatter="proRemoteUrlRequestFn"
						  remote-url-data-field="items"
						  title-field="email"
						  description-field="firstname"
						  image-field="photo"
						  minlength="1"
						  input-class="ip_input fa-iconimg"
						  match-class="highlight"    ng-model="email.emailId" > </div>
                  <div class="greenMsgPlus"></div>
                  <span ng-click="inviteuser()" 
					class="orgadduserPlus" style="cursor:pointer"><img src="<?php echo URL::to('/')?>/assets/images/bg-add-email.jpg" alt=""></span> </div>
                <div style="display:none"  class="errorvalidation"> <strong><?php echo Lang::get('messages.error_msg');?>!</strong> <?php echo Lang::get('messages.valid_email_msg');?> </div>
                <div style="display:none"  class="alert alert-success fade in successvalidation"> <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a> <strong><?php echo Lang::get('messages.label_success');?>!</strong> <?php echo Lang::get('messages.user_add_msg');?>. </div>
              </div>
            </div>
            <div class="userplaceholder"> </div>
            <div id="invusr"> </div>
          </div>
        </div>
      </div>
      <button class="btn-red" type="submit" ng-click="updatePro()"  value="add"><?php echo Lang::get('messages.label_update');?></button>
      <a  class="greybtnLink" href="{{url('dataroom/view-dataroom')}}"><?php echo Lang::get('messages.label_cancel');?></a>
      <div id="useremailid" > </div>
    </div>
  </div>
</div>
<script>
var varProjectSaveSuccessMsg = '<?php echo Lang::get('messages.msg_prj_saved_successfully');?>';
var varAddNotYourself = '<?php echo Lang::get('messages.msg_add_not_yourself');?>';
var varValidEmail = '<?php echo Lang::get('messages.valid_email_msg');?>';
var varEmailAlreadyExist = '<?php echo Lang::get('messages.msg_email_already_exist');?>';
var varInternalUsersAllowed = '<?php echo Lang::get('messages.msg_internal_user_allowed');?>';
var varMsgOops = '<?php echo Lang::get('messages.msg_oops');?>';
var varDomainAlreadyResctricted = '<?php echo Lang::get('messages.msg_domain_already_resctricted');?>';
var varOrgUserSavedSuccess = '<?php echo Lang::get('messages.msg_org_user_saved_successfully');?>';
var varUserInvitedSuccesfully = '<?php echo Lang::get('messages.msg_user_invited_success');?>';
var varUserNotInvitedSuccessfully = '<?php echo Lang::get('messages.msg_user_invited_not_success');?>';
var varMsgWentWrong = '<?php echo Lang::get('messages.something_gone_wrong_msg');?>';
var varMsgSuccess = '<?php echo Lang::get('messages.label_success');?>';
var varMsgError = '<?php echo Lang::get('messages.error_msg');?>';
var URL='<?php echo URL::to('/')?>';
var proId = '<?php echo $proId?>';
var currentUserEmail= '<?php echo  $currentUser ?>'; 
var addrole;
<?php $roles=  array(array ( "id" => "admin","role" => "Admin"),array ( "id" => "upload","role" => "Upload"),array ( "id" => "download","role" => "Download"),array ( "id" => "view","role" => "View"));

	?>
function addInvitedUser(email,id,photo,utype){
if(photo=='') photo = '<?php echo URL::to('/') ?>/assets/images/icon-profile.png';
       if(email.length>28){
  emailt=email.substr(0,10) + '....' + email.substr(-10);
}else{
 emailt=email;	
}
var HTML = '<span class="project-creator" ieuser="'+utype+'">' +
'<img class="angucomplete-image" src="'+ photo +'" alt="">'+
'<span data-id="'+ email+'" class="nameUserManage">' + emailt + '</span>'+
'<span class="orgcrossbtn userinviteremove" sumit="userid-'+ id +'">x</span>'; 
HTML += ' <span class="id_100"><select data-id="'+ id +'"  class="mangeuserSelect " onChange="fieldChange(this.value,'+ id +');">';

HTML +=  '<option   value="view"';
if(addrole=="view")
	HTML +=  'selected="selected"';
HTML +=  '><?php echo Lang::get('messages.label_view');?></option> ';

HTML +=  '<option   value="download"';
if(addrole=="download")
	HTML +=  'selected="selected"';
HTML +=  '><?php echo Lang::get('messages.label_download');?></option> ';

HTML +=  '<option   value="upload"';
if(addrole=="upload")
	HTML +=  'selected="selected"';
HTML +=  '><?php echo Lang::get('messages.label_upload');?></option> ';

HTML +=  '</select></span>';
HTML +=  '</span>';
return HTML;

}

var editOrganization={}; 
editOrganization.isedit=-1;
var datRoom={{$did}};
</script>
<?php if(!$internalUserOnly){?>
<script>
  $( document ).ready(function() {
	$('.lbl1').click(function () { 
	var internel_user =  $(this).parent('.content').find('.internel_user').val(); 	
		if(internel_user=='1') {
			$(this).parent('.content').find('.internel_user').val(0);			
		} else {
			$(this).parent('.content').find('.internel_user').val(1);
			///// sumit code will call
		}
	});
	});
</script>
<?php } ?>
<?php if($frompro==1){?>
<script>
  $( document ).ready(function() {	
	$("#domain_restrict")
  .focusout(function() {
	  var domain = $(this).val();	 
		if(domain!=''){
			var re = /^\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;
			if (re.test(domain)) {				
				$("[ieuser=external]").each(function() {					
					mail = $(this).find("input[name='userEmail[]']").val();
					if(mail){
						if(!restrictDomain(mail, domain)) {
							$(this).remove();
						}
					}
					else{
						var email=$(this).find("span[class='nameUserManage']").html();
						if(!restrictDomain(email, domain)){
							$(this).remove();
						}
					}
				});
				$("[ieuser=internal]").each(function() {					
					mail = $(this).find("input[name='userEmail[]']").val();
					if(mail){
						if(!restrictDomain(mail, domain)) {
							$(this).remove();
						}
					}
					else{
						var email=$(this).find("span[class='nameUserManage']").html();
						if(!restrictDomain(email, domain)){
							$(this).remove();
						}
					}
				});
			}
			}	
	});
	$('.lbl2').click(function () { 
	var internel_user =  $(this).parent('.content').find('.internel_user').val(); 	
		if(internel_user=='1') {
			$(this).parent('.content').find('.internel_user').val(0);			
		} else {
			$(this).parent('.content').find('.internel_user').val(1);
			///// sumit code will call
		}
	});

});
</script>
<?php }else{ ?>
<script>
  $( document ).ready(function() {	
	$('.lbl2').click(function () {
		toastr.clear(toast);
		var toast = toastr.error('Dataroom overrided!!');
		return false;
	});
});
</script>
<?php } ?>
<script>
  $( document ).ready(function() {
	 $(document).on('click','.userinviteremove',function(){
		   var UsrRemoveUserDiv = $(this).attr("sumit");
		   $("#"+UsrRemoveUserDiv).remove();
			$('.alert-success').css("display","none");
			$(this).parent().remove();
		});	
	});
  $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '{{URL::to("profile-photo")}}';
        var img_path_prefix = "{{URL::asset('uploads/')}}";
        $('#fileupload').fileupload({
            dropZone: $('#profile_dropzone'),
            url: url,
            dataType: 'json',
            acceptFileTypes:  /^image\/(gif|jpe?g|png)$/i,
            sequentialUploads: true,
            add: function (e, data) {
                var fileType = data.files[0].name.split('.').pop(), allowdtypes = 'jpeg,jpg,png,gif';
                if (allowdtypes.indexOf(fileType.toLowerCase()) < 0) {
                        toastr.clear(toast); 
                        var toast = toastr.error('<?php echo Lang::get('messages.msg_invalid_file_type');?>');
                        return false;
                    }                   
                data.submit();
            },
            done: function (e, data) {
		   
                var newsrc = $('#dataroomlogo').attr("src",data.result.result.image_url);
                $('#userprofile_picture').val(data.result.result.image_name);
                $('#profile_dropzone').hide();
                $('.profile_img_preview').css("display", "block")
                $('#progress .progress-bar').css('width', '0%');
                $('#fileupload').val('');
            },
            progress: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                        );
            }
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

	function isUrlValid() {
		var url = 'http://'+$('#company').val();
		var rs = /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
		if($('#company').val()){
			if(!rs){
				toastr.options = {"positionClass": "toast-top-center"};
				toastr['error']('<?php echo Lang::get('messages.msg_not_valid_url');?>');
				$('#company').val("");
			}
		}
	}
	function isUrlDomain() {
		var email = $('#domain_restrict').val();
		if(email!=''){
			var re = /^\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;
			if (!re.test(email)){
				toastr.options = {"positionClass": "toast-top-center"};
				toastr['error']('<?php echo Lang::get('messages.msg_invalid_file_type');?>');
				$('#domain_restrict').val("");
			}
		}
	}
  </script> 
@endsection 
