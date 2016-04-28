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
		
		
		{{HTML::style('assets/css/queries.css')}}
		
		{{HTML::style('assets/css/tagmanager.css')}}
		{{HTML::style('assets/css/bootstrap-treeview.css')}}
		{{HTML::style('assets/css/tooltipster.css')}}
		
		
		{{HTML::style('assets/css/sweetalert.css')}}

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
		
		{{HTML::script('assets/js/jquery.custom-scrollbar.js')}}
		{{HTML::script('assets/js/lightslider.js')}}
		{{HTML::script('assets/js/tagmanager.js')}}
		{{HTML::script('assets/js/sweetalert-dev.js')}}
		{{HTML::script('assets/js/bootstrap-treeview.js')}}
		{{HTML::script('assets/js/jquery.tooltipster.js')}}
</head>
<body>
<!-- Header -->

<div class="header" <?php echo ( Route::currentRouteName()=='folder')? 'style="position:fixed"':'' ; ?>>
  <div class="logo"> <a href="{{url('/')}}"> <img src="{{URL::asset('assets/images/logo.png')}}" alt="RaVaBe"> </a> </div>
  <div class="menu">
     
		<ul>
                <li>
                    <a href="{{url('dataroom/view')}}"><img src="<?php echo URL::to('/')?>/assets/images/nav_dataroom.png" alt="Dataroom"><span class="menuTxt"><?php echo Lang::get('messages.middle_header_link_dataroom');?></span></a>
                </li>
				
				<li>
                    <a href="{{url('users/folder')}}"><img src="<?php echo URL::to('/')?>/assets/images/nav_folders.png" alt="Dataroom"><span class="menuTxt"><?php echo Lang::get('messages.middle_header_link_folders');?></span></a>
                </li>
				
				<li>
                    <a href="{{url('users')}}"><img src="<?php echo URL::to('/')?>/assets/images/nav_user.png" alt="Dataroom"><span class="menuTxt"><?php echo Lang::get('messages.middle_header_link_users');?></span></a>
                </li>
               
            </ul>
		
     
  </div>
  <div class="header-nav">
	<!-- Language menu option start-->
				<div class="lang_menu clearfix">
						<ul>
							<li>
								<a href="javascript:void(0)" title="EN" language="en" class="<?php if(Session::get('local') == '') {echo 'selected';} else if(Session::get('local') == 'en') {echo 'selected';}   ?>">EN</a>
							</li>
							<li>
								<a href="javascript:void(0)" language="mn" title="中文" class="<?php if(Session::get('local') == 'mn') {echo 'selected';}?>">中文</a>
							</li>				
						</ul>
					</div>  
		<!-- Language menu option end-->
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
          <li><a href="{{url('/general-settings')}}"><?php echo Lang::get('messages.right_header_link_settings');?></a></li>
          <li><a href="{{url('/change-password')}}"><?php echo Lang::get('messages.change_password');?></a></li>		  
          <li><a href="{{url('/logout')}}"><?php echo Lang::get('messages.label_logout');?></a></li>
        </ul>
      </div>
    </div>
    <div class="header-nav-menu"> <a href="#"><i class="fa fa-bars"></i></a>
      <div class="mobilenavigation">
        <ul>
          <li><a href="javascript:void(0)"><?php echo Lang::get('messages.middle_header_link_dataroom');?></a>
            <ul>
              <li><a href="{{url('dataroom/view')}}"><?php echo Lang::get('messages.middle_header_link_dataroom');?></a></li>
              <li><a href="{{url('users/folder')}}"><?php echo Lang::get('messages.middle_header_link_folders');?></a></li>
							<li><a href="{{url('users')}}"><?php echo Lang::get('messages.middle_header_link_users');?></a></li>
            </ul>
          </li>
            <li><a href="javascript:void(0)"><?php echo Lang::get('messages.label_search');?></a></li>
          <li><a href="javascript:void(0)"><?php echo Lang::get('messages.label_profile_search');?></a>
            <ul>
              <li><a href="{{url('/general-settings')}}"><?php echo Lang::get('messages.right_header_link_settings');?></a></li>
              <li><a href="{{url('/logout')}}"><?php echo Lang::get('messages.label_logout');?></a></li>
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
		 $('.lang_menu li a').on("click",function(event){
				event.preventDefault();
				$('.lang_menu li a').removeClass('selected');
				$(this).toggleClass('selected');		
				var language = $(this).attr('language');
				window.location.href = '<?php echo URL::to('/')?>/language?lang='+language;	
			/*	$.ajax({
			url: '<?php echo URL::to('/')?>/language',
			type: 'GET',
			data: { lang: language },
			//processData: false,
			//contentType: false,
			success: function (data){ 
				//toastr[data.flag](data.msg);
				window.location.href = '<?php echo URL::to('/')?>';	
			}
			})
		
			*/
		});
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
