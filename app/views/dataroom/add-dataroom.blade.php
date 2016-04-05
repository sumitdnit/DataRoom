@extends('layouts.protected')
@section('content')
<?php $edit=0; ?>
{{HTML::script('assets/js/jquery.fileupload/js/jquery.iframe-transport.js')}}
{{HTML::script('assets/js/jquery.fileupload/js/jquery.fileupload.js')}}
{{HTML::script('assets/js/jquery.fileupload/js/jquery.fileupload-process.js')}}
{{HTML::script('assets/js/jquery.fileupload/js/jquery.fileupload-validate.js')}}
{{HTML::script('assets/js/ngautosuggest.js')}}
{{HTML::style('assets/css/ngautosuggest.css')}}
<style> 
.showhide { display:none;}
.show { display:block;}
</style>

<script src="<?php echo URL::to('/'); ?>/assets/js/angular-sanitize.min.js"></script>
<div id="client-room" class="main content"  ng-app="ravabedata" >

        <div id="client-room" class="add-room" ng-controller="dataroomctrl">

            <div class="room">
               

                <h2><strong>Add</strong> Room</h2>
				{{ Form::open(array('url' => 'dataroom/save','files' => true,'id'=>'upload')) }} 
				<input type="hidden" name="addDataRoom" value="add" class="form-control">  
                <div class="content content-form">

                    <h3>Data Room Name</h3>
                   
					<input type="text" id="dataRoom" name="dataRoom" value="" placeholder="Data Room Name" required> 
                    <h3>Description</h3>
                    <textarea name="description" rows="4" placeholder="Projects admins can add descripton of products..."></textarea>


                </div>

                <div class="content content-form">

                    <h3>Company URL</h3>
                    <input type="text" name="company" id="company" placeholder="www.youcompany.com">
                    <h3>Restrict Domain (if necessary)</h3>
                    <input ng-model="domain_restrict" type="text" name="domain_restrict" id="domain_restrict" placeholder="@yoursite.com">

                    <div class="content left">
                        <h3>Internal User Only</h3>
                        <input type="checkbox" id="unchecked1"   class="cbx cbx1 hidden" >
						<input type="hidden" name="internel_user" value="0" id="internel_user" class="internel_user"/>
                        <label for="unchecked1" class="lbl lbl1 clickChk"></label>
                    </div>

                    <div class="content right">
                        <h3>View Only</h3>
						
                        <input type="checkbox" id="unchecked2" class="cbx cbx2 hidden">
						<input type="hidden" name="view_only" value="0" id="view_only" class="internel_user"/>
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
                    <img src="{{URL::asset('public/assets/images/icon-logo.png')}}" id="dataroomlogo" height="40" width="40" style="float:left;">
					<span class="profile_img_preview" >
                            <input type="hidden" id="userprofile_picture" name="userprofile_picture" value="">
                        </span>
                        
					<span style="margin-right:30px;"><a href='javascript:void(0);' onclick="$('#fileupload').trigger('click')"  class="btn btn-default btn-file btn-generic">+ Add Logo</a></span> <!--<span class="mg-success">Ravabeprofile.jpg <span>0.3MB</span>--></span>
                </div>

                <div class="section-bottom">
                    <div class="content content-form">
                        <h2><strong>Add</strong> people</h2>
						
						
						
				<div id="AutocompleteSumit">
					
					 		
					<div class="section-ip">							
					<div class="input-grouporg">
					
					<div class="angucomplete-holder">
					 <div angucomplete-alt
						  id="email"
						  placeholder="Search Email"
						  pause="100"
						  selected-object="selectedProject"
						  remote-url="<?php echo URL::to('/')?>/dataroom/usernames"
						  remote-url-request-formatter="remoteUrlRequestFn"
						  remote-url-data-field="items"
						  title-field="email"
						  description-field="firstname"
						  image-field="photo"
						  minlength="1"
						  input-class="ip_input fa-iconimg"
						  match-class="highlight"    ng-model="email.emailId" >
					</div>
					
					
					<div class="greenMsgPlus"></div>
					<span ng-click="inviteuser()" 
					class="orgadduserPlus" style="cursor:pointer"><img src="<?php echo URL::to('/')?>/assets/images/bg-add-email.jpg" alt=""></span>
					
					</div>
						
				 	
					  
					  <div style="display:none"  class="errorvalidation">
								<strong>Error!</strong> Please enter valid email
					  </div>
					  <div style="display:none"  class="alert alert-success fade in successvalidation">
						<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
						<strong>Success!</strong> User was added.
					  </div>
					  
					
					</div>
					</div>
					
					
					
					 
				    <div class="userplaceholder">
					
					</div>
					
				    <div id="invusr">
					</div>
				    
				    
				    
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

<script>
var URL='<?php echo URL::to('/')?>';
var currentUserEmail= '<?php 'jhapankaj4u@gmail.com';// echo  $currentUser ?>'; 
<?php $roles=  array(array ( "id" => "admin","role" => "Admin"),array ( "id" => "upload","role" => "Upload"),array ( "id" => "download","role" => "Download"),array ( "id" => "view","role" => "View"));

	?>
function addInvitedUser(email,id,photo,utype){
			if(photo=='') photo = '<?php echo URL::to('/') ?>/assets/images/icon-profile.png';
	        if(email.length>28){
			   emailt=email.substr(0,10) + '....' + 	email.substr(-10);
			}else{
			  emailt=email;	
			}
			
			var HTML = '<span class="project-creator" ieuser="'+utype+'">' +
					'<img class="angucomplete-image" src="'+ photo +'" alt="">'+
					'<span data-id="'+ email+'" class="nameUserManage">' + emailt + '</span>'+
					'<span class="orgcrossbtn userinviteremove" sumit="userid-'+ id +'">x</span>'; 
					
					if(utype=="external") {					
					HTML += ' <span><select data-id="'+ id +'"  class="mangeuserSelect " onChange="fieldChange(this.value,'+ id +');">';
					HTML +=  '<option   value="user">User</option> ';
					HTML +=  '<option   value="admin">Admin</option> ';
					HTML +=  '</select></span>';
					
					}
					HTML +=  '</span>';
					return HTML;

}

var editOrganization={}; 
editOrganization.isedit=-1;
</script>
<script src="<?php echo URL::to('/'); ?>/assets/js/invitation.js"></script>

  <script>
  $( document ).ready(function() {
	$('.lbl').click(function () { 
	var internel_user =  $(this).parent('.content').find('.internel_user').val(); 	
		if(internel_user=='1') {
			$(this).parent('.content').find('.internel_user').val(0);
		} else {
			$(this).parent('.content').find('.internel_user').val(1);
			///// sumit code will call
			$("[ieuser=external]").remove();
			$('.successvalidation').hide();
			
		}
	});	
	  $('#domain_restrict').on('blur', function() {
		validateDomain($('#domain_restrict').val());
    return false;
	});
	 $(document).on('click','.userinviteremove',function(){
		   var UsrRemoveUserDiv = $(this).attr("sumit");
		   $("#"+UsrRemoveUserDiv).remove();
			$('.alert-success').css("display","none");
			$(this).parent().remove();
		});	
	});
  $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '{{URL::to("profile-photo")}}';
        var img_path_prefix = "{{URL::asset('public/uploads/')}}";
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
  
	function validateDomain(email) {
		var re = /^\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;
		if (re.test(email)){
		  
		} else {
			alert('Not a valid Domain.');
		}
	}
	function validateCompanyDomain(email) {
		var re = /^(http(s)?\/\/:)?(www\.)?[a-zA-Z\-]{3,}(\.(com|net|org))?$/;
		if (re.test(email)){		
		} else {
			alert('Not a valid  Company URL.');
		}
	}
	$('#company').on('blur', function() {	
		validateCompanyDomain($('#company').val());
		return false;
	});
  </script>
  
  
		 
  
@endsection