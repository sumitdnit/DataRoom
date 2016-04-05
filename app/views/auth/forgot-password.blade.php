@extends('layouts.public')
@section('content')

  <div class="formLoginsection">
		
		
		 <div id="client-room" class="main content">
        <div id="client-room" class="add-room">
            <div class="room">		
			 {{ Form::open(array('url' => '/forgot-password', 'id'=>'forgot-password-form')) }}  
		<div class="row">
        <div class="formsetLogin">
		<h2><strong>Forgot your password?</strong></h2>
		<div class="loginFormDataroom clearfix">
		<label class="password-lbl"><span>Email Address</span>
		<input type="email" name="email" class="form-control" id="email" placeholder="Your Email Address"  oninvalid="this.setCustomValidity('Email Name field is required')" oninput="setCustomValidity('')" required> 
		</label>
		
		
			
			<button type="submit" class="btn btn-lg btn-primary btn-block btn-red btn-login" >
                    Send </button>					
		
					
		</div>
		
		</div>
		</div>
		{{ Form::close() }} 
            </div>
        </div>
    </div>
		</div>
@endsection