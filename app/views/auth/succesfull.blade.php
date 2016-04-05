@extends('layouts.public')
@section('content')


	<div class="formLoginsection">
		
		
		 <div id="client-room" class="main content">
        <div id="client-room" class="add-room">
            <div class="room">		
			
		<div class="row">
		
		<div class="userverification-cont clearfix">
			<h1>Thank you</h1>
			<p>You've just been sent an email to confirm your email address.
Please click on "Login" button to confirm your account.</p>
			
<a class="linkbtn" href="{{url('/login')}}">Login</a>

		</div>		
      
		</div>
            </div>
        </div>
    </div>
		</div>
<script type="text/javascript">
$(document).ready(function() {
    $(".loading").click(function() {
        var $btn = $(this);
        $btn.button('loading');
        setTimeout(function () {
            $btn.button('reset');
        }, 1000);
    });
});    
</script>
@endsection