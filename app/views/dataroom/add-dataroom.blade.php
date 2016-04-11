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

.addloader {
		left: 50%;
    margin-left: -32px;
    margin-top: -32px;
    position: absolute;
    top: 50%;
    z-index: 99999;
	}
.addloader img { width:64px; height:64px;}
.bodyloader {opacity:0.3; width:100%; height:100%; position:absolute; left:0; top:0; z-index:9999; pointer-events:none;}
</style>
 <link href="<?php echo URL::to('/'); ?>/assets/css/ngautosuggest.css" type="text/css" rel="stylesheet" />
 {{HTML::script('assets/js/ngautosuggest.js')}}
<script src="<?php echo URL::to('/'); ?>/assets/js/angular-sanitize.min.js"></script>
<div class="bodyloader"></div>
<div class="addloader"></div>
<div id="client-room" class="main content"  ng-app="ravabedata" >
  <div id="client-room" class="add-room" ng-controller="dataroomctrl">
    <div class="room">
      <h2><strong>Add</strong> Dataroom</h2>
      {{ Form::open(array('url' => '','files' => true,'id'=>'addDataroomForm')) }}
      <input type="hidden" name="addDataRoom" value="add" class="form-control">
      <div class="content content-form">
        <h3>Dataroom Name</h3>
        <input type="text" id="dataRoom" name="dataRoom" value="" placeholder="Dataroom Name" >
        <h3>Description</h3>
        <textarea name="description" rows="4" placeholder="Projects admins can add descripton of products..."></textarea>
      </div>
      <div class="content content-form">
        <h3>Override</h3>
      <input type="hidden" name="company" id="company" value="www.youcompany.com"  placeholder="www.youcompany.com">
        <h3>Restrict Domain (if necessary)</h3>
        <input type="text" name="domain_restrict" value="" id="domain_restrict" onblur="isUrlDomain()" placeholder="@yoursite.com">
        <div class="content left">
          <h3>Internal User Only</h3>
          <input type="checkbox" id="unchecked1"   class="cbx cbx1 hidden" >
          <input type="hidden" name="internel_user" value="0" id="internel_user" class="internel_user"/>
          <label for="unchecked1" class="lbl lbl1 clickChk"></label>
        </div>
        <div class="content right">
          <h3>View Only</h3>
          <input type="checkbox" id="unchecked2" class="cbx cbx2 hidden">
          <input type="hidden" name="view_only" value="0" id="view_only" class="internel_user"/>
          <label for="unchecked2" class="lbl lbl2"></label>
        </div>
      </div>
      <div class="section-bottom" style="display:none;">
        <input id="fileupload" style="position:absolute; left:-9999px;" type="file" name="profile_pic" />
        <span class="filename pull-left profile_dropbox" id='profile_dropzone'>
        <div id="progress" class="progress">
          <div class="progress-bar progress-bar-success" ></div>
        </div>
        </span> <img src="{{URL::asset('public/assets/images/icon-logo.png')}}" id="dataroomlogo" height="40" width="40" style="float:left;"> <span class="profile_img_preview" >
        <input type="hidden" id="userprofile_picture" name="userprofile_picture" value="">
        </span> <span style="margin-right:30px;"><a href='javascript:void(0);' onclick="$('#fileupload').trigger('click')"  class="btn btn-default btn-file btn-generic">+ Add Logo</a></span>
        <span class="mg-success">Ravabeprofile.jpg <span>0.3MB</span>
        </span> </div>
      <div class="section-bottom">
        <div class="content content-form">
          <h2><strong>Add</strong> people</h2>
          <div id="AutocompleteSumit">
            <div class="section-ip">
              <div class="input-grouporg">
                <div class="angucomplete-holder">
                  <div angucomplete-alt
						  id="email"
						  placeholder="Search Email"
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
                <div style="display:none"  class="errorvalidation"> <strong>Error!</strong> Please enter valid email </div>
                <div style="display:none"  class="alert alert-success fade in successvalidation"> <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a> <strong>Success!</strong> User is added. </div>
              </div>
            </div>
            <div class="userplaceholder"> </div>
            <div id="invusr"> </div>
          </div>
        </div>
      </div>
      <button class="btn-red" type="submit"  value="add">Save</button>
      <a  class="greybtnLink" href="{{url('dataroom/view')}}">Cancel</a>
      <div id="useremailid" > </div>
      {{ Form::close() }} </div>
  </div>
</div>
<script>
$( document ).ready(function() {
	
	
	$('.addloader').hide();
	$(document).on("submit", "form", function(event){
		//toastr.options = {"positionClass": "toast-top-center"};
		//toastr.clear();
		//$('.addloader').show();
		//$('.btn-red').addClass('disabled');
		//console.log( $('#addDataroomForm').serialize() );
			//event.preventDefault();
			
			//alert('p');
			
    $.ajax({
        url: '<?php echo URL::to('/')?>/dataroom/save',
        type: 'POST',
        dataType: "JSON",
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (data){ 
					 $('.addloader').hide();						
					 toastr[data.flag](data.msg);
						$('.btn-red').removeClass('disabled');
						
						if(data.flag=='success')
							window.location.href = '<?php echo URL::to('/')?>/dataroom/view';
						/*setTimeout(function(){ 
							$('.btn-red').removeClass('disabled');

						}, 8000);*/
        },
        error: function (data){
					$('.addloader').hide();
					$('.btn-red').removeClass('disabled');
					//toastr['error']('There is some error to save dataroom!!');
					
				}
				
    }); 
	});
});

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
			
			var HTML = '<span class="project-creator" ieuser="'+utype+'">' +
					'<img class="angucomplete-image" src="'+ photo +'" alt="">'+
					'<span data-id="'+ email+'" class="nameUserManage">' + emailt + '</span>'+
					'<span class="orgcrossbtn userinviteremove" sumit="userid-'+ id +'">x</span>'; 
					
					if(utype=="external") {					
					HTML += ' <span><select data-id="'+ id +'"  class="mangeuserSelect " onChange="fieldChange(this.value,'+ id +');">';
					HTML +=  '<option   value="user">User</option> ';
					HTML +=  '<option   value="admin">Admin</option> ';
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
  $( document ).ready(function() {
	  $("#dataRoom").focusout(function() {
			$('.btn-red').removeAttr("disabled");
		});
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
	$('.lbl').click(function () { 
	var internel_user =  $(this).parent('.content').find('.internel_user').val(); 	
		if(internel_user=='1') {
			$(this).parent('.content').find('.internel_user').val(0);
		} else {
			$(this).parent('.content').find('.internel_user').val(1);
			///// sumit code will call
			$("[ieuser=external]").remove();
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
                        var toast = toastr.error('Invalid file type, aborted');
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
				toastr['error']('Not a valid Compnay url !!');
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
				toastr['error']('Not a valid Domain.');
				$('#domain_restrict').val("");
				}
		}
	}
	$(".btn-red").click(function(){
		  //$(this).attr("disabled","true");
    });
  </script>
@endsection
