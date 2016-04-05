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
		
		
		 <div id="client-room" class="main content">
        <div id="client-room" class="add-room">
            <div class="room">		
			
		<div class="row">
        <div class="formsetLogin">
		{{ Form::open(array('url' => '/change-password', 'id'=>'change-password')) }}
		<h2><strong>Change Password</strong></h2>
		<div class="loginFormDataroom clearfix">
        
		<label class="password-lbl"><span>Old Password</span><input type="password" name="oldpassword" placeholder="Old Password" required></label>
        <label class="password-lbl"><span>New Password</span> <input type="password" name="password" id="password" placeholder="New Password" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,14}" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');" required></label>
     	<label class="password-lbl"><span>Confirm Password</span> <input type="password"  id="confirm_password" name="re-password" placeholder="Confirm Password" required></label>       
		<button type="submit" class="btn btn-lg btn-primary btn-block btn-red btn-login">
        Save password</button>
		</div>
		{{ Form::close() }}
		</div>
		</div>
            </div>
        </div>
    </div>
		</div>

	
     
    
 
<script>
 $(document).ready(function () {
        var password = document.getElementById("password"), confirm_password = document.getElementById("confirm_password");
        function validatePassword() {
            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
                confirm_password.setCustomValidity('');
            }
        }
        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    });
   
</script> 
@endsection 