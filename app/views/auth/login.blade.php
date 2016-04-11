@extends('layouts.public')
@section('content')
<div class="formLoginsection">
  <div id="client-room" class="main content">
    <div id="client-room" class="add-room">
      <div class="room">
        <div class="row">
          <div class="formsetLogin">
		   <span>
                        
                        <h2><strong>Login</strong> DataRoom</h2>
                       
                    </span>
            
			{{ Form::open(array('url' => 'login', 'id'=>'login-form')) }}   
            <div class="loginFormDataroom clearfix">
              <input type="email" value="{{{ $cookie['email'] != ''? $cookie['email'] : ''}}}" name="email"  id="email" placeholder="Email Address" oninvalid="InvalidEmail(this)" oninput="InvalidEmail(this)" required>  
              <input type="password" value=""  name="password" id="password" placeholder="password" oninvalid="this.setCustomValidity('Password field is required')" oninput="setCustomValidity('')" required> 
              <div class="remberLogin clearfix">
                <label class="checkbox pull-left">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="checkbox"  name="remember" value="remember-me" <?php if($cookie['email'] != '' ) echo 'checked';?>>
                Remember me</label>
                <a href="{{url('/forgot-password')}}" class="pull-right need-help">Forgot password? </a><span class="clearfix"></span> </div>
              <button type="submit" class="btn btn-lg btn-primary btn-block btn-red btn-login"> Login</button>
            </div>
			{{ Form::close() }}  
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
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
@endsection