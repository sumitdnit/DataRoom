<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="{{{ asset('assets/images/android-icon-36x36.png') }}}" type="image/x-icon">
<title>Data Room</title>
{{HTML::style('assets/css/bootstrap.min.css')}}
        {{HTML::style('assets/css/font-awesome.min.css')}}
        {{HTML::style('assets/js/jquery-ui-1.11.3/jquery-ui.css')}}
        {{HTML::style('assets/css/style.css?ver=0.3')}}
        {{HTML::style('assets/css/toastr.css')}}
		{{HTML::style('assets/css/toastr.css')}}
		{{HTML::style('assets/css/lightslider.css')}}
		{{HTML::style('assets/css/queries.css')}}
		{{HTML::style('assets/css/jquery.custom-scrollbar.css')}}
		{{HTML::style('assets/css/tagmanager.css')}}

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
<body ng-app="ravabe" class="ng-cloak">
<div class="hero-unit">
  <div class="appheader">
    <div class="container">
      <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 logo-box"> <></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".toggle_nav" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 iconmenu hidden-sm hidden-xs" style="padding-top:20px;">
          <nav class="navbar navbar-default">
            <div class="container-fluid"> 
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#usernav"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
              </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="usernav">
                <ul class="nav navbar-nav navbar-right" style="width:184px;">
                  <li id="dropdown" > <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Data Room <span id="caret"></span></a>
                    <div class="top-arrow"></div>
                    <div class="dropdown-menu">
                      <div class="triangle-up"></div>
                      <div class="user-dropdown">
                        <h3>Data Room</h3>
                        <div class="user-link"><a class="nav-item " href="{{url('dataroom/view')}}">DataRoom View</a></div>
                        <div class="user-link"><a class="nav-item " href="{{url('project/view')}}">Project View</a></div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- /.navbar-collapse --> 
            </div>
            <!-- /.container-fluid --> 
          </nav>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 pull-right iconmenu hidden-sm hidden-xs">
          <nav class="navbar navbar-default">
            <div class="container-fluid"> 
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#usernav"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
              </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="usernav">
                <ul class="nav navbar-nav navbar-right" style="width:184px;">
                  <li id="dropdown" > <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <img class="user_profile_pic" src="{{$user_profile_pic or URL::asset('assets/images/60.png')}}" /> <span id="caret"></span></a>
                    <div class="top-arrow"></div>
                    <div class="dropdown-menu">
                      <div class="triangle-up"></div>
                      <div class="user-dropdown">
                        <h3>My Account</h3>
                        <div class="user-link"><a href="{{url('/general-settings')}}">General Settings</a></div>
                      </div>
                      <div class="menu-separator"></div>
                      <div class="help-menu"><a href="http://help.ravabe.com/">Help & Support</a></div>
                      <div class="menu-separator"></div>
                      <div class="logout-menu"><a href="{{url('/logout')}}">Log out</a></div>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- /.navbar-collapse --> 
            </div>
            <!-- /.container-fluid --> 
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@yield('content')
{{ Toastr::render() }}
</body>
</html>
