<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="{{{ asset('assets/images/android-icon-36x36.png') }}}" type="image/x-icon">
<title>Data Room</title>
{{HTML::style('assets/css/bootstrap.min.css')}}
        
		{{HTML::style('assets/js/jquery-ui.css')}}
        {{HTML::style('assets/js/jquery-ui-1.11.3/jquery-ui.css')}}
        {{HTML::style('assets/css/lightslider.css')}}
        {{HTML::style('assets/css/style.css?ver=0.3')}}
        {{HTML::style('assets/css/queries.css')}}
        {{HTML::style('assets/css/jquery.custom-scrollbar.css')}}
        {{HTML::style('assets/css/font-awesome.min.css')}}
        {{HTML::style('assets/css/toastr.css')}}
		{{HTML::style('assets/css/toastr.css')}}
		
		{{HTML::style('assets/css/queries.css')}}
		
		{{HTML::style('assets/css/tagmanager.css')}}
		
		{{HTML::style('assets/css/dropzone.css')}}

        {{HTML::script('assets/js/jquery-2.1.1.min.js')}}

        {{HTML::script('assets/js/jquery-ui-1.11.3/jquery-ui.min.js')}}
        {{HTML::script('assets/js/jquery.slimscroll.min.js')}}
        {{HTML::script('assets/js/jquery-heapbox.min.js')}}
        {{HTML::script('assets/js/icheck/icheck.min.js')}}
        {{HTML::script('assets/js/mcustomscrollbar/mcustomscrollbar.js')}}
        {{HTML::script('assets/js/angular/angular.min.js')}}
        {{HTML::script('assets/js/angular/angular-resource.min.js')}}
        {{HTML::script('assets/js/bootbox.min.js')}}
        {{HTML::script('assets/js/ngBootbox.min.js')}}
		
		
		
        {{HTML::script('assets/js/angular/app.js')}}
		
        {{HTML::script('assets/js/bootstrap-toggle.min.js')}}
      
		
		 {{HTML::script('assets/js/bootstrap.min.js')}}
        {{HTML::script('assets/js/toastr.min.js')}}
		{{HTML::script('assets/js/column-grid.js')}}
		{{HTML::script('assets/js/main.js')}}
		{{HTML::script('assets/js/dropzone.js')}}
		{{HTML::script('assets/js/jquery.custom-scrollbar.js')}}
		{{HTML::script('assets/js/lightslider.js')}}
		{{HTML::script('assets/js/tagmanager.js')}}
</head>
<body  >
<!-- Header -->
<div class="header">
  <div class="logo"> <a href="{{url('/')}}"> <img src="{{URL::asset('assets/images/logo.png')}}" alt="RaVaBe"> </a> </div>
  <div class="menu">
    <ul>
      <li> <a href="{{url('dataroom/view')}}"><img src="{{URL::asset('assets/images/icon-dataroom.png')}}" alt="Dataroom"></a>
        <div class="dataroom-dropdown">
          <ul>
            <li><a href="{{url('dataroom/view')}}">Dataroom</a></li>
            <li><a href="{{url('project/view')}}">Project room</a></li>
            <li><a href="{{url('users/folder')}}">Folders</a></li>
          </ul>
        </div>
      </li>
      <!-- <li>
                    <a href=""><img src="img/icon-people.png" alt="People"></a>
                </li>
                <li>
                    <a href=""><img src="img/icon-settings.png" alt="Settings"></a>
                </li>-->
    </ul>
  </div>
  <div class="header-nav">
    <div class="search"> <a href="javascript:void(0)"> <i class="fa fa-search"></i> </a> </div>
    <!-- <div class="notification">
                <a href="">
                    <i class="fa fa-bell"></i>
                    <span>32</span>
                </a>
            </div>-->
			<?php 
			$user = Sentry::getUser();	
			$profiles =  Profile::getUserDetail($user->id);
			
			?>
    <div class="profile"><?php if($profiles[0]['image']) {?> <img src="{{$profiles[0]['image'];}}" alt="User" height="40" width="40"><?php } else {?><img src="{{URL::asset('assets/images/header-profile.png')}}" alt="User"><?php }?>
      <div class="arrowClickbox"> <a href="javascript:void(0)"><span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span></a>
        <ul class="profileDropdown right">
          <li><a href="{{url('/general-settings')}}">Settings</a></li>
          <li><a href="{{url('/change-password')}}">Change Password</a></li>
          <li><a href="{{url('/logout')}}">Logout</a></li>
        </ul>
      </div>
    </div>
    <div class="header-nav-menu"> <a href="#"><i class="fa fa-bars"></i></a>
      <div class="mobilenavigation">
        <ul>
          <li><a href="{{url('dataroom/view')}}">Dataroom</a>
            <ul>
              <li><a href="{{url('dataroom/view')}}">Dataroom</a></li>
              <li><a href="{{url('project/view')}}">Project room</a></li>
              <li><a href="{{url('users/folder')}}">Folders</a></li>
            </ul>
          </li>
          <li><a href="javascript:void(0)">Search</a></li>
          <li><a href="javascript:void(0)">Profile Setting</a>
            <ul>
              <li><a href="{{url('/general-settings')}}">Settings</a></li>
             
              <li><a href="{{url('/logout')}}">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- End of Header --> 

<script>
$(document).ready(function(){	
    $('.arrowClickbox').on("click",function(e){
		$('.profileDropdown').toggle();
		e.stopPropagation();
	});
	$('body,html').click(function(e) {   
	$('.profileDropdown').hide();
	});
});
</script> 


<script>
//Mobile Menu
$(document).ready(function(){
	$('.header-nav-menu').on("click",function(e){
		$('.mobilenavigation').toggle();
		e.stopPropagation();
	});
	
	$('.mobilenavigation li a').on("click",function(e){				
		$('.mobilenavigation li').prevAll('ul').slideUp();
		$(this).parent('li').find('ul').slideToggle();
		e.stopPropagation();
	});
	
	$('body,html').click(function(e) {   
	$('.mobilenavigation').hide();
	});
});
</script>

@yield('content')
{{ Toastr::render() }}
</body>
</html>
