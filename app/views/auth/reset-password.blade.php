@extends('layouts.public')
@section('content')
{{HTML::script('assets/js/password-strength.js')}}
<script type="text/javascript">
    $(document).ready(function () {
        $('#password').pwstrength();
    });
</script>
<div class="formLoginsection">
  <div id="client-room" class="main content">
    <div id="client-room" class="add-room">
      <div class="room">
        <div class="row">
          <div class="formsetLogin">
            <h2><strong>Choose A New Password</strong></h2>
            <div class="middle-text"> Enter your password in the box below. For added security it 
              must contain at least one number and capital letter. </div>
            {{ Form::open(array('url' => '/reset-password', 'id'=>'reset_password')) }}
            <div class="loginFormDataroom clearfix">
              <input type="password"  name="password" id="password" placeholder="New Password" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,14}" onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');" required>
              <input type="password" id="confirm_password" name="re-password" class="form-control" placeholder="Confirm Password" required>
              <input type="hidden" name="user_id" value="{{$user_id}}"/>
              <input type="hidden" name="reset_code" value="{{$reset_code}}"/>
              <button type="submit" class="btn btn-lg btn-primary btn-block btn-red btn-login"> Send </button>
            </div>
            {{ Form::close() }} </div>
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