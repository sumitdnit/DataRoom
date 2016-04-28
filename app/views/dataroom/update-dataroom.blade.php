@extends('layouts.protected')
@section('content')

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
<script src="<?php echo URL::to('/'); ?>/assets/js/angular-sanitize.min.js"></script>
<div id="client-room" class="main content" ng-app="ravabedata">
  <div id="client-room" class="add-room" ng-controller="dataroomctrl">
   
      <div>
   
        <div class="breadcrumb-header" style="margin:0 15px 25px 0;">
          <ul>
            <li><a href="{{url('dataroom/view-dataroom')}}"> <?php echo Lang::get('messages.middle_header_link_dataroom');?></a></li>
           
            <li><a href="{{url('dataroom/view-dataroom?den='.base64_encode($data['id']))}}">{{$data['name']}}</a></li>
   
          </ul>
        </div>
      </div>
    
    <div class="room">
      <h2><strong><?php echo Lang::get('messages.label_update');?></strong> <?php echo Lang::get('messages.middle_header_link_dataroom');?></h2>
      {{ Form::open(array('url' => 'dataroom/saveupdate','files' => true,'id'=>'upload')) }}
      <input type="hidden" name="Action" value="update" class="form-control">
      <input type="hidden" name="dataRoomId" value="{{$data['id']}}" class="form-control">
	   <input type="hidden" name="varDataRoomAdminId" value="{{$data['varDataRoomUserId']}}" class="form-control">	  
      <div class="content content-form">
        <h3><?php echo Lang::get('messages.dataroom_name');?></h3>
        <input type="text" id="dataRoom" name="dataRoom" value="{{$data['name']}}" placeholder="<?php echo Lang::get('messages.dataroom_name');?>" required>
        <h3><?php echo Lang::get('messages.label_description');?></h3>
        <textarea name="description" rows="4" placeholder="<?php echo Lang::get('messages.add_description_msg');?>...">{{$data['description']}}</textarea>
      </div>
      <div class="content content-form override">
        <h4><?php echo Lang::get('messages.label_override');?></h4>
        <input type="hidden" name="company" id="company" placeholder="www.youcompany.com"  onblur="isUrlValid()"value="{{$data['company']}}">
        <h3><?php echo Lang::get('messages.domain_validation_msg');?></h3>
        <input type="text" name="domain_restrict" id="domain_restrict" placeholder="@yoursite.com" onblur="isUrlDomain()" value="{{$data['domain_restrict']}}">
         <input type="hidden" name="domain-restrict-old" id="domain-restrict-old"  value="{{$data['domain_restrict']}}">
        
        <?php
	  	$did = $data['id'] ;
		$Dataroom 	  = Dataroom::where('id', $did)->first();
		$readonly = 0;
		$internalUserOnly = 0;
		
		if(sizeof($Dataroom)>0) {   
			$internalUserOnly = $Dataroom->internal_user; 
			$readonly = $Dataroom->view_only;	
		}
///echo $internalUserOnly; die;
		?>
        
        <div class="content left">
          <h3><?php echo Lang::get('messages.internal_user_valid_msg');?></h3>
          <input type="checkbox" id="unchecked1" class="cbx cbx1 hidden"  <?php if($internalUserOnly){?> checked="checked" <?php } ?>   >
          <input type="hidden" name="internel_user" value="<?php echo $internalUserOnly;?>" id="internel_user" class="internel_user"/>
          <label for="unchecked1" class="lbl lbl1"></label>
        </div>
        <div class="content right">
          <h3><?php echo Lang::get('messages.label_view_only');?></h3>
          <input type="checkbox" id="unchecked2" class="cbx cbx2 hidden" <?php if($readonly){?> checked="checked" <?php } ?>   >
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
        </span>
        <?php if($data['photo']){?>
        <img src="{{URL::asset('public/uploads/'.$data['photo'])}}" id="dataroomlogo" height="50" width="50" style="float:left;">
        <?php } else { ?>
        <img src="{{URL::asset('assets/images/icon-logo.png')}}" id="dataroomlogo" height="40" width="40" style="float:left;">
        <?php } ?>
        <span class="profile_img_preview" >
        <input type="hidden" id="userprofile_picture" name="userprofile_picture" value="{{$data['photo']}}">
        </span> <span style="margin-right:30px;"><a href='javascript:void(0);' onclick="$('#fileupload').trigger('click')"  class="btn btn-default btn-file btn-generic">+ <?php echo Lang::get('messages.label_people');?></a></span>
        
        </span> </div>
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
						  remote-url="<?php echo URL::to('/')?>/dataroom/usernames"
						  remote-url-request-formatter="remoteUrlRequestFn"
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
            <div class="userplaceholder">
			<?php // print_r($data); die;
				
				
				?>
			@foreach($data['addedUsersInfo'] as $rkey=>$val)
				<?php $showrole=(ucfirst($val['addrole'])=="Internaluser")?"Internal User":ucfirst($val['addrole']);?>
				 <span class="project-creator" ieuser="{{$val['addrole']}}">
				<img class="angucomplete-image" src="{{$val['userphoto']}}" alt="">
					<span data-id="{{$val['addemail']}}" class="nameUserManage"> {{$val['addemail']}} </span>
					<span class="orgcrossbtn userinviteremove" sumit="userid-{{$val['addemailid']}}">x</span>
					<span>{{$showrole}}<select  data-id="{{$val['id']}}" style="pointer-events: none;" class="mangeuserSelect hidden" onChange="fieldChange(this.value,{{$val['id']}});">
					<option   value="{{$val['addrole']}}" selected="selected">{{ucfirst($val['addrole'])}}</option> 
					</select></span>
					
					</span>
			@endforeach
			</div>
            <div id="invusr"> 
			@foreach($data['addedUsersInfo'] as $rkey=>$val)
				<input type="hidden" value="{{$val['addtableid']}}" name="userOldId[]" />
				<div class="usrControl" id="userid-{{$val['addemailid']}}" ieuser="{{$val['addrole']}}">
				<input type="hidden" value=" {{$val['addemail']}} " name="userEmail[]" />
				<input type="hidden" value="{{$val['addemailid']}}" name="userId[]" />
				<input id="role{{$val['addemailid']}}" type="hidden" value="{{$val['addrole']}}" name="userRole[]" />
				<input id="role{{$val['addemailid']}}" type="hidden" value="{{$val['addrole']}}" name="source[]" />
				<input id="role{{$val['addemailid']}}" type="hidden" value="old" name="newold[]" />
				</div>
			@endforeach
			
			</div>
          </div>
        </div>
      </div>
      <button class="btn-red" type="submit"  value="add"><?php echo Lang::get('messages.label_update');?></button>
      <a  class="greybtnLink" href="{{url('dataroom/view-dataroom')}}"><?php echo Lang::get('messages.label_cancel');?></a>
      <div id="useremailid" > </div>
      {{ Form::close() }} </div>
  </div>
</div>
<script>
var varProjectSaveSuccessMsg = '<?php echo Lang::get('messages.msg_projectroom_save');?>';
var varUserInvitedSuccesfully = '<?php echo Lang::get('messages.msg_user_invited_success');?>';
var varUserNotInvitedSuccessfully = '<?php echo Lang::get('messages.msg_user_invited_not_success');?>';
var varWrongMsg = '<?php echo Lang::get('messages.msg_something_gone_wrong');?>';
var varValidEmail = '<?php echo Lang::get('messages.valid_email_msg');?>';
var varAddNotYourself = '<?php echo Lang::get('messages.msg_add_not_yourself');?>';
var varEmailAlreadyExist = '<?php echo Lang::get('messages.msg_email_already_exist');?>';
var varUserAllowed = '<?php echo Lang::get('messages.msg_already_user_allowed');?>';
var varDomainAlreadyResctricted = '<?php echo Lang::get('messages.msg_domain_already_resctricted');?>';
var varValidEmail = '<?php echo Lang::get('messages.valid_email_msg');?>';
var varInternalUsersAllowed = '<?php echo Lang::get('messages.msg_internal_user_allowed');?>';
var URL='<?php echo URL::to('/')?>';
var currentUserEmail= '<?php echo  $currentUser ?>'; 
<?php $roles=  array(array ( "id" => "admin","role" => "Admin"),array ( "id" => "upload","role" => "Upload"),array ( "id" => "download","role" => "Download"),array ( "id" => "view","role" => "View"));

	?>
function addInvitedUser(email,id,photo,utype){
			if(photo=='') photo = '<?php echo URL::to('/') ?>/assets/images/icon-profile.png';
	        if(email.length>28){
			   emailt=email.substr(0,10) + '....' + 	email.substr(-10);
			}else{
			  emailt=email;	
			}
			var showutype = utype.substr(0, 1).toUpperCase() + utype.substr(1);
			showutype=(showutype=="Internaluser")?"<?php echo Lang::get('messages.label_internal_user');?>":showutype;
			var onlytype = utype;
			utype = (utype=="external")?'user':utype;
			var HTML = '<span class="project-creator" id="showuserid-'+id+'" ieuser="'+utype+'">' +
					'<img class="angucomplete-image" src="'+ photo +'" alt="">'+
					'<span data-id="'+ email+'" class="nameUserManage">' + emailt + '</span>'+
					'<span class="orgcrossbtn userinviteremove" sumit="userid-'+ id +'">x</span>'; 
					
					if(onlytype=="external") {					
					HTML += ' <span><select data-id="'+ id +'"  class="mangeuserSelect" onChange="fieldChange(this.value,\''+ id +'\');">';
					HTML +=  '<option   value="user"><?php echo Lang::get('messages.label_user');?></option> ';
					HTML +=  '<option   value="admin"><?php echo Lang::get('messages.label_admin');?></option> ';
					HTML +=  '<option   value="internaluser"><?php echo Lang::get('messages.label_internal_user');?></option> ';
					HTML +=  '</select></span>';
					
					}
					else{
					HTML += ' <span>'+showutype+'<select data-id="'+ id +'"  class="mangeuserSelect hidden" onChange="fieldChange(this.value,\''+ id +'\');">';
					HTML +=  '<option   value="'+utype+'">'+showutype+'</option> ';
					HTML +=  '</select></span>';
					}
					HTML +=  '</span>';
					return HTML;

}

var editOrganization={}; 
editOrganization.isedit=-1;
</script>
<script src="<?php echo URL::to('/'); ?>/assets/js/invitation.js"></script>

<script>
 $(document).ready(function () {
	 $("#dataRoom").focusout(function() {
			$('.btn-red').removeAttr("disabled");
		});
$("#domain_restrict")
  .focusout(function() {
	  var domain = $(this).val();	 
		if(domain!=''){
			var re = /^\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;
			if (re.test(domain)) {				
				$("[ieuser=user]").each(function() {					
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
				$("[ieuser=admin]").each(function() {					
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
				$("[ieuser=internaluser]").each(function() {					
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
	$('.lbl1').click(function () { 
	var internel_user =  $(this).parent('.content').find('.internel_user').val(); 	
		if(internel_user=='1') {
			$(this).parent('.content').find('.internel_user').val(0);
			$('.mangeuserSelect').css('pointer-events','all');
		} else {
			$(this).parent('.content').find('.internel_user').val(1);
			///// sumit code will call
			$('.mangeuserSelect').css('pointer-events','none');
			$("[ieuser=user]").remove();
			$("[ieuser=admin]").remove();
			$('.successvalidation').hide();
			
		}
	});
	$('.lbl2').click(function () { 
	var view_only =  $(this).parent('.content').find('.view_only').val(); 	
		if(view_only=='1') {
			$(this).parent('.content').find('.view_only').val(0);
		} else {
			$(this).parent('.content').find('.view_only').val(1);
			$('.successvalidation').hide();
			
		}
	});
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
         var img_path_prefix = "{{URL::asset('public/uploads/')}}";
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
				toastr['error']('<?php echo Lang::get('messages.msg_not_valid_domain');?>');
				$('#domain_restrict').val("");
			}
		}
	}
	/*$(".btn-red").click(function(){
		  $(this).attr("disabled","true");
    });
	
	$( document ).ready(function() {
	   function show_domain_end(){
		 var ABC = $("#domain-restrict-old").val();		
		$("#domain_restrict").val(ABC);
	   };
	   window.setTimeout( show_domain_end, 300); // 5 seconds
	});*/

  </script>
@endsection
