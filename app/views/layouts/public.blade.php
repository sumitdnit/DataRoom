<!DOCTYPE html>
<html lang="en">
        {{HTML::style('assets/css/bootstrap.min.css')}}
        {{HTML::style('assets/css/font-awesome.min.css')}}
		{{HTML::style('assets/js/jquery-ui.css')}}
        {{HTML::style('assets/js/jquery-ui-1.11.3/jquery-ui.css')}}
        {{HTML::style('assets/js/mcustomscrollbar/mcustomscrollbar.css')}}
        {{HTML::style('assets/css/style.css?ver=0.3')}}
        {{HTML::style('assets/css/toastr.css')}}
		{{HTML::style('assets/css/lightslider.css')}}
		{{HTML::style('assets/css/queries.css')}}
		{{HTML::style('assets/css/jquery.custom-scrollbar.css')}}
		{{HTML::style('assets/css/tagmanager.css')}}

        {{HTML::script('assets/js/jquery-2.1.1.min.js')}}
        {{HTML::script('assets/js/jquery-ui-1.11.3/jquery-ui.min.js')}}
        {{HTML::script('assets/js/jquery-heapbox.min.js')}}
        {{HTML::script('assets/js/mcustomscrollbar/mcustomscrollbar.js')}}
        {{HTML::script('assets/js/jquery.slimscroll.min.js')}}
        {{HTML::script('assets/js/bootstrap.min.js')}}
        {{HTML::script('assets/js/toastr.min.js')}}
		{{HTML::script('assets/js/column-grid.js')}}
		{{HTML::script('assets/js/main.js')}}
		{{HTML::script('assets/js/dropzone.js')}}
		{{HTML::script('assets/js/jquery.custom-scrollbar.js')}}
		{{HTML::script('assets/js/lightslider.js')}}
		{{HTML::script('assets/js/tagmanager.js')}}
		
		  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <title><?php echo Lang::get('messages.msg_dataroom_with_space');?></title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
   

       
       
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

    </head>
    <body>
         {{ Toastr::render() }}
		 <!-- Header -->
    <div class="header">
        <div class="logo">
           <a href="{{url('/')}}"> <img src="{{URL::asset('assets/images/logo.png')}}"></a>
        </div>
		
       <!-- <div class="menu">
            <ul>
                <li>
                    <a href=""><img src="img/icon-project.png" alt="Projects"></a>
                </li>
                <li>
                    <a href=""><img src="img/icon-people.png" alt="People"></a>
                </li>
                <li>
                    <a href=""><img src="img/icon-settings.png" alt="Settings"></a>
                </li>
            </ul>
        </div> -->
		
        <div class="header-nav">
				<!-- Language menu option start-->
					<div class="lang_menu clearfix">
						<ul>
							<li>
								<a href="javascript:void(0)" title="EN" language="en" class="<?php if(Session::get('local') == '') {echo 'selected';} else if(Session::get('local') == 'en') {echo 'selected';}   ?>">EN</a>
							</li>
							<li>
								<a href="javascript:void(0)" language="mn" title="??" class="<?php if(Session::get('local') == 'mn') {echo 'selected';}?>">??</a>
							</li>				
						</ul>
					</div>  
		<!-- Language menu option end-->
           <!--  <div class="search">
                <a href="">
                    <i class="fa fa-search"></i>
                </a>
            </div> 
            <div class="notification">
                <a href="">
                    <i class="fa fa-bell"></i>
                    <span>32</span>
                </a>
            </div>
            <div class="profile">
                <img src="img/header-profile.png" alt="User">
                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
            </div>-->
            <div class="header-nav-menu">
                <a href="">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
        </div>
		

    </div>
    <!-- End of Header -->
<script type="text/javascript">
    $(document).ready(function () {
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
			
        $('#terms').click(function () {
          $('#modal-opener').trigger('click');
        });
    });
</script>
<style>

    #project-list { position:relative; margin:0px auto; padding:0px; height: 400px; overflow: hidden; }
    .mCSB_scrollTools.mCSB_3_scrollbar.mCS-minimal.mCSB_scrollTools_vertical {
    margin: 0 !important;
    padding: 0 !important;
}
    .col-lg-12.modal-body-term {
    margin: 55px 0 0 6px;
    padding: 0px 50px;
}


</style>

<button type="button" id="modal-opener" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style="display: none;">
    Launch demo modal
</button>

<!-- Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row modal-header-align">
                    <div class="col-md-6 modal-text ">
                        <h4  class="modal-title-term" id="myModalLabel">Terms And Conditions</h4>
                    </div>
                </div>
            </div>
            <div class="row terms-pop-up">
                <div class="col-lg-12 modal-body-term">
                    <div id="project-list">
                        <div class="modal-body">
                           
<h3>OVERVIEW</h3>
<p>
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum..</p>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/*    jQuery(document).ready(function($) {

  if (window.history && window.history.pushState) {

    window.history.pushState('forward', null);

    $(window).on('popstate', function() {
      location.reload();
    });

  }
});*/
    $(function () {

        $('#project-list').mCustomScrollbar({
                    theme: "minimal"
                });
              });

</script>
        @yield('content')
    </body>
</html>

