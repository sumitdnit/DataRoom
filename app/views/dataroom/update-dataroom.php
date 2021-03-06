@extends('layouts.protected')
@section('content')

{{HTML::script('assets/js/jquery.fileupload/js/jquery.iframe-transport.js')}}
{{HTML::script('assets/js/jquery.fileupload/js/jquery.fileupload.js')}}
{{HTML::script('assets/js/jquery.fileupload/js/jquery.fileupload-process.js')}}
{{HTML::script('assets/js/jquery.fileupload/js/jquery.fileupload-validate.js')}}
<style> 
.showhide { display:none;}
.show { display:block;}
</style>

<div id="client-room" class="main content">

        <div id="client-room" class="add-room">

            <div class="room">
               

                <h2><strong>Add</strong> Room</h2>
				{{ Form::open(array('url' => 'dataroom/saveupdate','files' => true,'id'=>'upload')) }} 
				<input type="hidden" name="dataRoom" value="update" class="form-control"> 
                <div class="content content-form">

                    <h3>Data Room Name</h3>
                   
					<input type="text" id="dataRoom" name="dataRoom" value="" placeholder="Data Room Name" required> 
                    <h3>Description</h3>
                    <textarea name="description" rows="4" placeholder="Projects admins can add descripton of products..."></textarea>


                </div>

                <div class="content content-form">

                    <h3>Company URL</h3>
                    <input type="text" name="company" placeholder="www.youcompany.com">
                    <h3>Restrict Domain (if necessary)</h3>
                    <input type="text" name="domain_restrict" placeholder="@yoursite.com">

                    <div class="content left">
                        <h3>Internal User Only</h3>
                        <input type="checkbox" id="unchecked1" class="cbx cbx1 hidden">
                        <label for="unchecked1" class="lbl lbl1"></label>
                    </div>

                    <div class="content right">
                        <h3>View Only</h3>
						
                        <input type="checkbox" id="unchecked2" class="cbx cbx2 hidden">
                        <label for="unchecked2" class="lbl lbl2"></label>
                    </div>


                </div>

                <div class="section-bottom">
				
				    <input id="fileupload" style="position:absolute; left:-9999px;" type="file" name="profile_pic" />
					 <span class="filename pull-left profile_dropbox" id='profile_dropzone'>
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success" ></div>
                            </div>
                        </span>
                    <img src="{{URL::asset('assets/images/icon-logo.png')}}" id="dataroomlogo" height="40" width="40" style="float:left;">
					<span class="profile_img_preview" >
                            <input type="hidden" id="userprofile_picture" name="userprofile_picture" value="">
                        </span>
                        
					<span style="margin-right:30px;"><a href='javascript:void(0);' onclick="$('#fileupload').trigger('click')"  class="btn btn-default btn-file btn-generic">+ Add Logo</a></span> <!--<span class="mg-success">Ravabeprofile.jpg <span>0.3MB</span>--></span>
                </div>

                <div class="section-bottom">
                    <div class="content content-form">
                        <h2><strong>Add</strong> people</h2>
                        <input type="text" id="names"  placeholder="Search Email" class="addpeople-form" >
						<input id="log" name="email_id" type="hidden"/>
						
						
                        <span class="mg-success showhide"><strong>Success!</strong> User was added. Please assign role to added user.<span class="hidemessage">x</span></span>
						
						<div id="UserList" >						
                       
						</div>
                    </div>
                </div>

                <button class="btn-red" type="submit"  value="add">Save</button>
                <a  class="greybtnLink" href="{{url('dataroom/view')}}">Cancel</a>
				
				<div id="useremailid" >					
				</div>
				
				
{{ Form::close() }}
            </div>


        </div>

    </div>
	 <!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
	<script> var URL='<?php echo URL::to('/')?>';</script>
  <script>
 $(document).ready(function () {
     $( "#names" ).autocomplete({
      source: URL+"/dataroom/usernames",
    });
	
	 $('#names').on('change', function () {
	 	 
		
	    var UserEmail = this.value;
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
   		if(regex.test(UserEmail) ) {
				
			var oldHTML  =  $('#UserList').html();		
			var str = "Hello world, welcome to the universe.";
			var n = oldHTML.indexOf(UserEmail);
			text = UserEmail.replace('@', '-');
			text = text.replace('.', '-');
			if(n == -1) {
				var HTML = '<span class="project-creator">';
				
				var ImgURL = "{{ URL::asset('assets/images/icon-profile.png')}}";
				
				var img =  '<img src="'+ImgURL+'">';
				var desg =  'View'; 		
				HTML  +=  img + '<span>' +  UserEmail; 
				HTML  += '</span> <span onclick="RemoveUser(this,\''+text+'\')">x</span> <span>' +  desg + '</span></span>'; 		
				$('#UserList').append(HTML);
				var input = '<input type="hidden" id="'+text+'" name="emails[]" value="'+UserEmail+'" >';
				$('#useremailid').append(input);
				
				$('.mg-success').removeClass('showhide');				
				$('.mg-success').addClass('show');
				}
		}
		
    }).change();
    $('#names').on('autocompleteselect', function (e, ui) {
        var UserEmail = this.value;	
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
   		if(regex.test(UserEmail) ) {
			var oldHTML  =  $('#UserList').html();		
			var str = "Hello world, welcome to the universe.";
			var n = oldHTML.indexOf(UserEmail);
			if(n == -1) {	
				var HTML = '<span class="project-creator">';
				
				var ImgURL = "{{ URL::asset('assets/images/icon-profile.png')}}";
				text = UserEmail.replace('@', '-');
				text = text.replace('.', '-');
				
				var img =  '<img src="'+ImgURL+'">';
				var desg =  'View'; 		
				HTML  +=  img + '<span>' +  UserEmail; 
				HTML  += '</span> <span onclick="RemoveUser(this,\''+text+'\')">x</span> <span>' +  desg + '</span></span>'; 
				
				$('#UserList').append(HTML);
				
				
				
				var input = '<input type="hidden" id="'+text+'" name="emails[]" value="'+UserEmail+'" >';
				$('#useremailid').append(input);
				
				$('.mg-success').removeClass('showhide');				
				$('.mg-success').addClass('show');
				
				}
		}
		 
    });
	
	$( ".hidemessage" ).click(function() {
		$('.mg-success').removeClass('show');				
		$('.mg-success').addClass('showhide');
	});
	
  });
  
  function RemoveUser(userSpan,emailtext){ 
 
		$('.mg-success').removeClass('show');				
		$('.mg-success').addClass('showhide');
		$(userSpan).parent(".project-creator").remove();
		$('#'+emailtext).remove();
		
 }
 
  $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '{{URL::to("profile-photo")}}';
        var img_path_prefix = "{{URL::asset('uploads/')}}";
        $('#fileupload').fileupload({
            dropZone: $('#profile_dropzone'),
            url: url,
            dataType: 'json',
            acceptFileTypes:  /^image\/(gif|jpe?g|png)$/i,
            sequentialUploads: true,
            add: function (e, data) {
                var fileType = data.files[0].name.split('.').pop(), allowdtypes = 'jpeg,jpg,png,gif';
                if (allowdtypes.indexOf(fileType.toLowerCase()) < 0) {
                        toastr.clear(toast); 
                        var toast = toastr.error('Invalid file type, aborted');
                        return false;
                    }                   
                data.submit();
            },
            done: function (e, data) {
		   
                var newsrc = $('#dataroomlogo').attr("src",data.result.result.image_url);
                $('#userprofile_picture').val(data.result.result.image_name);
                $('#profile_dropzone').hide();
                $('.profile_img_preview').css("display", "block")
                $('#progress .progress-bar').css('width', '0%');
                $('#fileupload').val('');
            },
            progress: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                        );
            }
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
  
	
  </script>
  
  
		 
  
@endsection