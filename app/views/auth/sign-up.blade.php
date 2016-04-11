@extends('layouts.public')
@section('content')
{{HTML::script('assets/js/password-strength.js')}}
<script type="text/javascript">
    $(document).ready(function () {
    $('#password').pwstrength();    
    $('.rule').hide();
    $('#password').focus(function(event){
        $('.rule').show();
    });
    $('#password').focusout(function(event){
        $('.rule').hide();
    });
    $('.show').click(function(){
        var type = $('#password').attr('type');
        var check = $('#password').val();
        if(type == 'password'){
            $('#password').attr('type', 'text');
            $(this).find('i').attr('class', 'fa fa-eye-slash');
        }else{
            $('#password').attr('type', 'password');
            $(this).find('i').attr('class', 'fa fa-eye');
        }
    });
    $('#signup-form').bind('submit', function(){
        var network_name = $('#time-zone').val();
        if(!network_name){
            toastr.clear(toast); 
            var toast = toastr.error('Please Choose your Time Zone.');
            return false;
        }
    });
    });
</script>
<style type="text/css">
 .login-wrapper .strengthmeter{ 
    width:50%;float:left;margin-top:5px
  }
 .login-wrapper .password-verdict{
    margin-top:5px;display:inline-block
 }
 #time-zone{max-width: 100%;
    width:100%;}
</style>
<div class="formLoginsection">
  <div id="client-room" class="main content">
    <div id="client-room" class="add-room">
      <div class="room">
        <div class="row">
          <div class="formsetLogin">
            <h2><strong>Signup</strong> DataRoom</h2>
            <div class="loginFormDataroom clearfix"> {{ Form::open(array('url' => '/create-user', 'id'=>'signup-form')) }}
							<input type="hidden" value="{{$data['userid']}}" name="user_id" />
							<input type="hidden" value="{{$data['token']}}" name="token" />
							<input type="hidden" value="{{$data['email']}}" name="email" />
              <input type="text" name="firstname" placeholder="First Name" pattern="^[a-z \A-Z \u4E00-\u9FA5\uF900-\uFA2D]{2,20}$" oninvalid="this.setCustomValidity('First Name should be alphabatical and must be at least 2 characters long')" oninput="setCustomValidity('')" required >
              <input type="text" placeholder="Last Name" name="lastname" class=""  pattern="^[a-z \A-Z \u4E00-\u9FA5\uF900-\uFA2D]{1,20}$" oninvalid="this.setCustomValidity('Last Name should be alphabatical and must be at least 1 characters long')" oninput="setCustomValidity('')" required>
              <input type="email" name="emailshow"  value="{{$data['email']}}" readonly >
							
              <input type="hidden" name='user_tz' id="time-zone" value="Asia/Kolkata">
              <input type="password" placeholder="Password" class="" name="password" id="password" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,30}" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');" data-toggle="password" required>
							<!-- <input type="text" placeholder="Enter Organization" class="" name="organization" id="Organization"  required> -->
							 
							 <!--<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 std-code">
								<input type="text" placeholder="STD Code" class="" name="stdcode" id="stdcode" required>
								</div>
								
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<input type="text" placeholder="Enter Phone number" class="" name="phonenumber" id="phonenumber" required>
								</div>
							 </div>-->
							 
              <div class="remberLogin clearfix">
                <label class="checkbox pull-left agree-text">
                <input type="checkbox" value="remember-me" onchange="this.setCustomValidity(validity.valueMissing ? 'Please agree to the Terms and Conditions' : '');" required>
                I agree to the <a id="terms" href="javascript:void(0)" style="cursor: pointer;"><b>Terms and conditions<b></a>. </label>
                <!--<a href="#" class="pull-right need-help">Forgot password? </a><span class="clearfix"></span>-->
              </div>
              <button type="submit" class="btn btn-lg btn-primary btn-block btn-red btn-login" id="sign_up" value="SIGN UP"> SIGN UP</button>
              {{ Form::close() }} </div>
            <!--<p class="member-login">Already a member? <a href="login.php"> Login</a></p>-->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script> 
function InvalidEmail(textbox) {
    if (textbox.value == '') {
        textbox.setCustomValidity('Email field is required');
    }
    else if (textbox.validity.typeMismatch){
        textbox.setCustomValidity('please type a valid email address');
    }
    else {
       textbox.setCustomValidity('');
    }
    return true;
}
    
</script>
<style type="text/css">
.form-group .heapBox .heap{
    width: 473px;
}
.form-group .heapBox .handler{
    width: 5%;
    z-index: 1;
}
.form-group .heapBox{
    width: 473px;
}
.form-group .heapBox .holder{
    width: 445px;
    font-size: 16px;
    text-indent: 5px;
    z-index: 1;

}
.form-group .heapBox .heap .heapOptions .heapOption a{
    font-size:13px;
    text-indent:5px;
}
</style>
@endsection
