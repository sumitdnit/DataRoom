@extends('layouts.protected')
@section('content')

{{HTML::script('assets/js/password-strength.js')}}
{{HTML::script('assets/js/jquery.fileupload/js/jquery.iframe-transport.js')}}
{{HTML::script('assets/js/jquery.fileupload/js/jquery.fileupload.js')}}
{{HTML::script('assets/js/jquery.fileupload/js/jquery.fileupload-process.js')}}
{{HTML::script('assets/js/jquery.fileupload/js/jquery.fileupload-validate.js')}}
<script type="text/javascript">
    $(document).ready(function () {
        $('#password').pwstrength();
        $('.password-rule').hide();
        $('#password').keydown(function(event){
            $('.password-rule').show();
        });
        $('.show').click(function(){
            var type = $('#password').attr('type');
            var check = $('#password').val();
            
                if(type == 'password'){
                    $('#password').attr('type', 'text');
                    $(this).find('i').attr('class', 'fa fa-eye-slash');
                }
                else{
                    $('#password').attr('type', 'password');
                    $(this).find('i').attr('class', 'fa fa-eye');
                }
            
        });
    });
</script>
<style>
.progress.strengthmeter,.show.eye{ display:none;
}
.profilelogo{ margin-right:10px;}
</style>

	<div class="formLoginsection">
		<div class="main content" id="client-room">
      <div class="add-room" id="client-room">
        <div class="room">		
				{{ Form::open(array('url' => 'update-setting','files'=> true,'id' => 'general-setting-form')) }}
				<input type="hidden" name="user_tz" value="America/Barbados" />
					<div class="row">
						<div class="formsetLogin">
							<h2><strong><?php echo Lang::get('messages.right_header_link_account_setting');?></strong> </h2>
							<div class="loginFormDataroom clearfix">
								<input type="text" class="form-control" id="firstname" placeholder="<?php echo Lang::get('messages.label_first_name');?>" pattern="^[a-z \A-Z \u4E00-\u9FA5\uF900-\uFA2D]{2,20}$" value="{{ $profiles['firstname']}}" oninvalid="this.setCustomValidity('<?php echo Lang::get('messages.msg_first_name_validation');?>')" oninput="setCustomValidity('')" name="firstname" required>
								
								<input type="text" class="form-control" id="secondname" placeholder="<?php echo Lang::get('messages.label_last_name');?>" pattern="^[a-z \A-Z \u4E00-\u9FA5\uF900-\uFA2D]{1,20}$" value="{{ $profiles['lastname']}}" oninvalid="this.setCustomValidity('<?php echo Lang::get('messages.msg_last_name_validation');?>')" oninput="setCustomValidity('')" name="lastname" required>
							
							
								 <input type="email" class="form-control" id="email" placeholder="<?php echo Lang::get('messages.label_email_address');?>" value="{{ $user->email}}" name="email" readonly="readonly" oninvalid="this.setCustomValidity('<?php echo Lang::get('messages.msg_email_required_valid');?>')" oninput="setCustomValidity('')" required>
								 
								 
								  <!--<input type="password" class="form-control" id="password" placeholder="Password" name="password" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,30}" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');">-->
									
									 <input id="fileupload" style="position:absolute; left:-9999px;" type="file" name="profile_pic" />
                         <span class="filename pull-left profile_dropbox" id='profile_dropzone' style="display:none;">
                            <div id="progress" class="progress" >
                                <div class="progress-bar progress-bar-success"  ></div>
                            </div>
                        </span>
						<?php if($profiles['image']){?>
                    <img src="{{$profiles['image']}}" id="profilelogo" height="50" width="50" style="float:left;">
					<?php } else { ?>
					 <img src="{{URL::asset('assets/images/header-profile.png')}}"  id="profilelogo" height="50" width="50" style="float:left;">
					 <?php } ?>
					<span class="profile_img_preview" style="margin:5px;">
					
                            <input type="text" id="userprofilepicture"  name="userprofilepicture" value="{{$profiles['photo']}}" style="display:none;">
                        </span>
                        <a href='javascript:void(0);' onclick="$('#fileupload').trigger('click')"  class="btn btn-default btn-file btn-generic"><?php echo Lang::get('messages.label_browse');?></a>
								
								<button class="btn btn-lg btn-primary btn-block btn-red btn-login"  type="submit"  value="update"><?php echo Lang::get('messages.label_update');?></button>		
							</div>
						</div>
					</div>
				{{ Form::close() }}
        </div>
      </div>
    </div>
	</div>
 
<script>
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '{{URL::to("updateprofile-photo")}}';
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
		   
                var newsrc = $('#profilelogo').attr("src",data.result.result.image_url);
                $('#userprofilepicture').val(data.result.result.image_name);
				
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
</script> 
@endsection 