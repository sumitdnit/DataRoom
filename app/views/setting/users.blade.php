@extends('layouts.protected')
@section('content')
<div class="second-header">
  <div class="breadcrumb-header">
    <ul>
       <li><a href="{{url('dataroom/view')}}"><?php echo Lang::get('messages.middle_header_link_dataroom');?></a></li>
      <li><a href="{{url('users')}}"><?php echo Lang::get('messages.middle_header_link_users');?></a></li>
    </ul>
  </div>
  <div class="content-header">
    <section>
      <p>A-Z</p>
      <?php $firstUser = $Users[0]; ?>
      <select class="form-control" name="selectuser" id="selectuser" >
        <option value="asc" <?php if($sortby=='profiles.firstname' && $ascdsc=='asc' ) { ?> selected="selected" <?php } ?> ><?php echo Lang::get('messages.label_ascending');?></option>
        <option value="desc" <?php if($sortby=='profiles.firstname' && $ascdsc=='desc' ) { ?> selected="selected" <?php } ?>><?php echo Lang::get('messages.label_descending');?></option>
      </select>
    </section>
    <section>
      <p><?php echo Lang::get('messages.last_updated');?></p>
      <select class="form-control" name="selectLastUpdated" id="selectLastUpdated">
        <option value="asc" <?php if($sortby=='users.updated_at' && $ascdsc=='asc' ) { ?> selected="selected" <?php } ?>><?php echo Lang::get('messages.label_ascending');?></option>
        <option value="desc" <?php if($sortby=='users.updated_at' && $ascdsc=='desc' ) { ?> selected="selected" <?php } ?>><?php echo Lang::get('messages.label_descending');?></option>
      </select>
    </section>
  </div>
</div>
<!-- End of Second Header --> 
<!-- Draggagle Menu -->
<div class="workflow-draggable-menu swipe-area"> <a href="javascript:void(0);" class="draggable-menu-action">
  <div class="label capture-label"> 
    <!--span></span--> 
    <img src="<?php echo URL::to('/')?>/assets/images/user.png" alt=""> </div>
  </a> <a href="javascript:void(0);" class="draggable-menu-action">
  <div class="menu-dots"> <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> </div>
  </a>
  <div class="container-fluid content workflow-draggable-menu-content swipe-area-content">
    <div class="menu-header">
      <div class="title">
        <h2><?php echo Lang::get('messages.label_dataroom_project');?></h2>
      </div>
    </div>
    <div class="usercard-dataroom-wrapper" id="usercard-dataroom-wrapper">
      <?php $datarooms=Dataroom::getDataRoomByUserId($firstUser->userid);?>
      <?php if (sizeof($datarooms)>0){?>
      <ul>
        <?php foreach ($datarooms as $dr) { 
				$class = "dataroom-unit clearfix";
				if(Dataroom::getDataRoomOverRide($dr->roomid))	
				$class = "dataroom-unit active clearfix";
				
			
			?>
        <li class="expand">
          <div class="<?php echo $class?>">
            <div class="info"><strong><?php echo ucfirst($dr->name)?></strong></div>
            <div class="update-date"><?php echo date('m/d/Y | H:i A',strtotime($dr->updated_at))?></div>
            <?php if($currentUser['role']=="admin"){ ?>
            <div class="roleEdit"> <?php echo Lang::get('messages.label_edit');?></div>
            <div class="expand-wrapper"><a href="javascript:void(0);"></a></div>
            <?php } else { ?>
             <span class="leavemedata" d="<?php echo $dr->roomid;?>"><?php echo Lang::get('messages.msg_leave_me');?></span>
             <?php } ?>
          </div>
          <?php $projectrooms=Project::getProjectByUserDataRoomId($dr->roomid,$firstUser->userid); ?>
          <?php if (sizeof($projectrooms)>0){?>
          <ul>
            <?php foreach ($projectrooms as $pr) { 
			
			$pid=base64_encode($pr->projid);
			$url=URL::to('/').'/project/edit?p='.$pid;
			$pclass = "project-unit clearfix";
			if(Project::getProjectRoomOverRide($pr->projid))	
				$pclass = "project-unit clearfix active";
				
			?>
            <li>
              <div class="<?php echo $pclass?>">
                <div class="info"><strong><?php echo ucfirst($pr->name)?></strong></div>
                <?php 	if($currentUser['role']=="admin"){ ?>
                <span class="roleEditsmall"><a href="<?php echo $url?>"><?php echo Lang::get('messages.label_edit');?></a></span>
                <?php } else {?>
                <span class="leavemeproject" d="<?php echo $dr->roomid;?>" p="<?php echo $pr->projid;?>"><?php echo Lang::get('messages.msg_leave_me');?></span>
                <?php } ?>
              </div>
            </li>
            <?php } ?>
          </ul>
          <?php } ?>
          <div style="display:none" class="editdataroom">
            <div class="DataRoomId" val="<?php echo $dr->roomid?>"></div>
            <div class="DataRoomUserId" val="<?php echo $dr->role?>"></div>
            <div class="DataRoomRole" val="<?php echo $dr->user_id?>"></div>
          </div>
        </li>
        <?php } ?>
      </ul>
      <?php } ?>
    </div>
  </div>
</div>
<div style="display:none;"> {{Form::open(array('url'=> 'dataroom/update','name'=>'dataroomupdate','id'=>'dataroomupdate'))}}
  <input type="hidden" value="" name="_token">
  <input type="hidden" value="" name="varDataRoomId" id="varDataRoomId">
  <input type="hidden" value="" name="varDataRoomUserId" id="varDataRoomUserId">
  <input type="hidden" value="" name="varDataRoomRole" id="varDataRoomRole">
  {{Form::close()}} </div>
<!-- End of Draggagle Menu -->
<div id="manager-user" class="main main-config main-drag" ng-app="ravabe" ng-controller="ListofUsers">
  <div class="manager-user-content">
    <?php 
  $detasils  = Profile::getUserDetail($firstUser->userid);
  //echo '<pre>';
 // print_r($firstUser);
  //die;
  $firstUserimage = ($firstUser->photo != '') ? URL::asset('public/uploads/'.$firstUser->photo) : URL::asset('assets/images/60.png');	 
		 
  ?>
    <div class="user-data">
      <div class="content-header">
        <div class="row">
          <div class="col-md-9 col-xs-9">
            <div class="pull-left"> <img src="<?php echo $firstUserimage ?>" class="img-circle userimage" alt="User Image"> </div>
            <h4 class="userfullname"><?php echo ucfirst(strtolower($firstUser->firstname))." ".ucfirst(strtolower($firstUser->lastname))?></h4>
            <?php if($firstUser->usertype!='internaluser') {?>
            <p class="userrole"><?php echo ucfirst($firstUser->usertype)?></p>
            <?php } else { ?>
             <p class="userrole"><?php echo Lang::get('messages.label_internal_user');?></p>
            <?php } ?>
          </div>
          <div class="col-md-3 col-xs-3">
            <?php 	
			
			
			if($currentUser['role']=="admin"){ 
			
			//die;
			if($firstUser->userid!=$currentUser['id']){
			?>
            <div class="user-tools"> <a href="javascript:editUserCard();"><img src="<?php echo URL::to('/')?>/assets/images/icon-pencil.png"></a> 
              <!--<a href="javascript:void(0);"><img src="<?php echo URL::to('/')?>/assets/images/icon-user-.png"></a>--> 
              <a href="javascript::void(0);" class="DeleteUser" user="<?php echo $firstUser->userid ?>"><img src="<?php echo URL::to('/')?>/assets/images/delete.png"></a> </div>
            <?php }} ?>
          </div>
        </div>
      </div>
      <div class="content-body room">
        <ul class="double">
          <li><span class="small-text"><strong><?php echo Lang::get('messages.label_email');?></strong></span></li>
          <li><span class="small-text"><strong><?php echo Lang::get('messages.label_roles');?></strong> </span></li>
          <li><span class="small-text useremail"><?php echo $firstUser->email ?></span></li>
          <li>
          <?php if($firstUser->usertype!="internaluser") { ?>
            	 <span class="small-text user-card-role usertype"><?php echo ucfirst($firstUser->usertype) ?></span>
               <?php } else { ?>
              <span class="small-text user-card-role usertype"><?php echo Lang::get('messages.label_internal_user');?></span>               
          <?php } ?>
        
            <select class="user-role-dropdown" name="">
              <option value="user"><?php echo Lang::get('messages.label_user');?></option>
              <option value="admin"><?php echo Lang::get('messages.label_admin');?></option>
              <option value="internaluser"><?php echo Lang::get('messages.label_internal_user');?></option>
            </select>
          </li>
          <li style="margin-top:15px;pointer-events:none;"> <span class="small-text"><strong><?php echo Lang::get('messages.msg_activated');?></strong> </span> <span class="small-text" style="margin-top:10px;">
            <?php if($firstUser->source!="internel"){?>
            <input type="checkbox" id="unchecked1" class="cbx cbx1 hidden"  >
            <?php } else {?>
            <input type="checkbox" id="unchecked1" class="cbx cbx1 hidden" checked="checked" >
            <?php }?>
            <label for="unchecked1" class="lbl lbl1"></label>
            </span> </li>
			<button class="revokebtn btn-blue  <?php if($firstUser->source=="internel"){?> hidden <?php }?>" style="max-width:182px; padding:10px 35px !important;" revokeusr-id="<?php echo $firstUser->userid ?>" ng-click="revoke()"><?php echo Lang::get('messages.label_resend_invitation');?></button>
        </ul>
		
        <ul class="double" style="margin-top:5px;">
          <button class="btn-red" onclick="javascript:userDetailPopup();"><?php echo Lang::get('messages.label_see_details');?></button>
          <button class="btn-blue" style="display:none;" id="usersave" user="<?php echo $firstUser->userid ?>"><?php echo Lang::get('messages.label_save');?></button>
        </ul>
      </div>
    </div>
  </div>
</div>
<div id="manager-user-menu">
  <div class="dashboard-draggable-menu dashboard-draggable-menu-open"> <a href="javascript:void(0);" class="draggable-menu-action-dashboard"> 
    <!-- <div class="feed-btn">
                <img src="<?php echo URL::to('/')?>/assets/images/icon-feed.png" alt="Feed">
            </div> --> 
    </a> <a href="javascript:void(0);" class="draggable-menu-action-dashboard-mobile"> 
    <!-- <div class="feed-btn">
                <img src="<?php echo URL::to('/')?>/assets/images/icon-feed.png" alt="Feed">
            </div> --> 
    </a>
    <div class="container-fluid content dashboard-draggable-menu-content dashboard-draggable-content-open">
      <div class="content-header ravabe-skin-sm scroll">
        <div class="scroller-friends">
          <?php foreach($Users as $user) { 
		 // print_r($user);
		  //die;
		  ?>
          <?php if($user->data_room_id=="" && $user->usertype=="user") { 
		//continue;
		 } 
		 ?>
          <?php 
		  $image = ($user->photo != '') ? URL::asset('public/uploads/'.$user->photo) : URL::asset('assets/images/60.png');	 
		 
		  ?>
          <div class="user-friends"> <a href="javascript:void(0)" class="userclick" user="<?php echo $user->userid?>">
            <div class="pull-left"> <img src="<?php echo $image ?>" class="img-circle" alt="User Image"> </div>
            <h4><span id="link">
              <?php if($user->firstname!=''){ ?>
              <?php echo ucfirst(strtolower($user->firstname))." ".ucfirst(strtolower($user->lastname)) ?>
              <?php }else {?>
              <?php echo $user->email; } ?> </span></h4>
              <?php if($user->usertype!="internaluser") { ?>
            	<p id="showusertype-<?php echo $user->userid?>"><?php echo ucfirst($user->usertype)?></p>
               <?php } else { ?>
               <p id="showusertype-<?php echo $user->userid?>"><?php echo Lang::get('messages.label_internal_user');?></p>
               <?php } ?>
            </a> </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <!-- End of Dashbord Draggable Menu --> 
  </div>
</div>
<script>
var URL='<?php echo URL::to('/')?>';
$(document).ready(function() {
	/*$(".revokebtn").click(function(){
		
	});*/

   function EditRoom(){ 
   
   //alert("hhhhhhhhhh");
	
	//alert('tttt');
        /*code for edit informations*/
        var varDataRoomId = $(this).parents('.expand').find('.editdataroom').find('.DataRoomId').attr("val");
        $("#varDataRoomId").val(varDataRoomId);
        var varDataRoomUserId = $(this).parents('.expand').find('.editdataroom').find('.DataRoomUserId').attr("val");
        $("#varDataRoomUserId").val(varDataRoomUserId);
        var varDataRoomRole = $(this).parents('.expand').find('.editdataroom').find('.DataRoomRole').attr("val");
        $("#varDataRoomRole").val(varDataRoomRole);
        $("#dataroomupdate").submit();
        /* end code for edit informations*/
    }
    $('.roleEdit').on("click", function() {
	
	//alert('tttt');
        /*code for edit informations*/
        var varDataRoomId = $(this).parents('.expand').find('.editdataroom').find('.DataRoomId').attr("val");
        $("#varDataRoomId").val(varDataRoomId);
        var varDataRoomUserId = $(this).parents('.expand').find('.editdataroom').find('.DataRoomUserId').attr("val");
        $("#varDataRoomUserId").val(varDataRoomUserId);
        var varDataRoomRole = $(this).parents('.expand').find('.editdataroom').find('.DataRoomRole').attr("val");
        $("#varDataRoomRole").val(varDataRoomRole);
        $("#dataroomupdate").submit();
        /* end code for edit informations*/
    });
	
	var URL='<?php echo URL::to('/')?>';
	
	$('.userclick').click(function (e) {
        e.preventDefault();
		var id=$(this).attr('user');
		$('.user-tools').hide();
		$('.manager-user-content #usersave').css('display', 'none');
		$('.revokebtn').attr('revokeusr-id',id);
		//alert('test');
        $.ajax({
            type: "POST",
            url: '<?php echo URL::to('/')?>/usersdetails',
            data: { id: id },
            dataType: "json",
            success: function (msg) {
				var tmp = msg.msg.split('--predeep--');	
						
				var antmp =tmp[0].split('--ppp--');
				
				$(".userimage").attr('src',tmp[1]);	
				if(antmp[1]!='Internaluser') {	
					$(".userrole").html(antmp[1]); 
					$(".usertype").html(antmp[1]);
				} else {
					$(".userrole").html('<?php echo Lang::get('messages.label_internal_user');?>'); 
					$(".usertype").html('<?php echo Lang::get('messages.label_internal_user');?>');	
				}
				  
				$(".useremail").html(antmp[3]);
				$(".userfullname").html(antmp[4]);
				var show= antmp[5];
				$("#usersave").attr('user',antmp[0]);
				$(".DeleteUser").attr('user',antmp[0]);
				
				if(show==1){
					$('.user-tools').show();
				} 
				
				if(antmp[2]=="Internel") {
							$("#unchecked1").prop("checked","checked");							
							$(".revokebtn").addClass("hidden");
						} else {
							$("#unchecked1").removeAttr("checked");	
							$(".revokebtn").removeClass("hidden");							
							}
				
				
			
						if(antmp[1]=="Admin"){						
							var nHTML = '<option value="admin"><?php echo Lang::get('messages.label_admin');?></option><option value="user"><?php echo Lang::get('messages.label_user');?></option><option value="Internaluser"><?php echo Lang::get('messages.label_internal_user');?></option>';
							$('.user-role-dropdown').html(nHTML);													
						} else if(antmp[1]=="Internaluser"){						
							var nHTML = '<option value="internaluser"><?php echo Lang::get('messages.label_internal_user');?></option><option value="admin"><?php echo Lang::get('messages.label_admin');?></option><option value="user"><?php echo Lang::get('messages.label_user');?></option>';
							$('.user-role-dropdown').html(nHTML);	
							
						} else{						
							var nHTML = '<option value="user"><?php echo Lang::get('messages.label_user');?></option><option value="admin"><?php echo Lang::get('messages.label_admin');?></option><option value="Internaluser"><?php echo Lang::get('messages.label_internal_user');?></option>';
							$('.user-role-dropdown').html(nHTML);								
							}
				
				$("#usercard-dataroom-wrapper").html(tmp[2]);    
				$('.user-role-dropdown').attr("style","display:none;");	
				$('.usertype').attr("style","display:block;"); 
				if(antmp[1]!='Internaluser')
					$("#showusertype-"+antmp[0]).html(antmp[1]);   
				else 
					$("#showusertype-"+antmp[0]).html('<?php echo Lang::get('messages.label_internal_user');?>'); 
				
				
				         
            }
        });
    });
	
		$('#usersave').click(function (e) {
		
		var id=$(this).attr('user');
		var role = $('.user-role-dropdown').val();
		var abc = $('#unchecked1').prop('checked');
		var utype='';
		if(abc)
		utype ='internel';
		else
		utype='external';
		
		//alert(id);
        $.ajax({
            type: "POST",
            url: '<?php echo URL::to('/')?>/userssave',
            data: { id: id,role: role,utype: utype },
            dataType: "json",
            success: function (response) {
			console.log('related-----log'+response);									
				   $.ajax({
					type: "POST",
					url: '<?php echo URL::to('/')?>/usersdetails',
					data: { id: id },
					dataType: "json",
					success: function (msg) {
						var tmp = msg.msg.split('--predeep--');	
								
						var antmp =tmp[0].split('--ppp--');
												
						$(".userimage").attr('src',tmp[1]);
						
						if(antmp[1]!='Internaluser') {	
							$(".userrole").html(antmp[1]); 
							$(".usertype").html(antmp[1]);
						} else {
							$(".userrole").html('<?php echo Lang::get('messages.label_internal_user');?>'); 
							$(".usertype").html('<?php echo Lang::get('messages.label_internal_user');?>');	
						}
						
						$(".useremail").html(antmp[3]);
						$(".userfullname").html(antmp[4]);
						$("#usersave").attr('user',antmp[0]);						
						$(".DeleteUser").attr('user',antmp[0]);
						
						if(antmp[2]=="Internel") {
							$("#unchecked1").prop("checked","checked");							
							$(".revokebtn").addClass("hidden");
						} else {
							$("#unchecked1").removeAttr("checked");	
							$(".revokebtn").removeClass("hidden");							
							}							
						
						
						if(antmp[1]=="Admin"){						
							var nHTML = '<option value="admin"><?php echo Lang::get('messages.label_admin');?></option><option value="user"><?php echo Lang::get('messages.label_user');?></option><option value="internaluser"><?php echo Lang::get('messages.label_internal_user');?></option>';
							$('.user-role-dropdown').html(nHTML);													
						} else if(antmp[1]=="Internaluser"){						
							var nHTML = '<option value="internaluser"><?php echo Lang::get('messages.label_internal_user');?></option><option value="admin"><?php echo Lang::get('messages.label_admin');?></option><option value="user"><?php echo Lang::get('messages.label_user');?></option>';
							$('.user-role-dropdown').html(nHTML);													
						} else {						
							var nHTML = '<option value="user"><?php echo Lang::get('messages.label_user');?></option><option value="admin"><?php echo Lang::get('messages.label_admin');?></option><option value="internaluser"><?php echo Lang::get('messages.label_internal_user');?></option>';
							$('.user-role-dropdown').html(nHTML);								
							}
						
						$("#usercard-dataroom-wrapper").html(tmp[2]);
						
						if(antmp[1]!='Internaluser') 
							$("#showusertype-"+antmp[0]).html(antmp[1]);   
						else  
							$("#showusertype-"+antmp[0]).html('<?php echo Lang::get('messages.label_internal_user');?>');
					}
				});
				$('.user-role-dropdown').attr("style","display:none;");	
				$('.usertype').attr("style","display:block;");
				toastr.options = {"positionClass": "toast-top-center"};
				toastr['success'](response.msg);			   
            },
			error: function (response) {
				toastr.options = {"positionClass": "toast-top-center"};
				toastr['error'](response.msg); 
			}
        });
    });
	
		$('.DeleteUser').click(function (e) {
        e.preventDefault();
		var id=$(this).attr('user');
		
			swal({   
				title: "<?php echo Lang::get('messages.msg_are_u_sure');?>",   
				text: "<?php echo Lang::get('messages.msg_no_longer_show');?>",   
				type: "warning",   
				showCancelButton: true,   
				cancelButtonText: "<?php echo Lang::get('messages.label_cancel');?>",
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "<?php echo Lang::get('messages.label_delete');?>" 
			}, 
			function(){			
				
				$.ajax({
					type: "POST",
					url: '<?php echo URL::to('/')?>/userdelete',
					data: { id: id },
					dataType: "json",
					success: function (response) {				
						toastr.options = {"positionClass": "toast-top-center"};
						toastr['success'](response.msg); 
						window.location=URL+'/users';
							 
					},
					error: function (response) {
						toastr.options = {"positionClass": "toast-top-center"};
						toastr['error'](response.msg); 
					}
				});
			});
       
    });
	
	
	$('#selectuser').on('change', function() {
		var URL='<?php echo URL::to('/')?>';
		if(this.value=='asc')
			window.location=URL+'/users?order=asc&sortby=name';
		else
			window.location=URL+'/users?order=desc&sortby=name';		
		});
		
	$('#selectLastUpdated').on('change', function() {
		var URL='<?php echo URL::to('/')?>';
		if(this.value=='asc')
			window.location=URL+'/users?order=asc&sortby=last';
		else
			window.location=URL+'/users?order=desc&sortby=last';		
		});
		
		$('.leavemeproject').click(function (e) {
       
		var did=$(this).attr('d');
		var pid=$(this).attr('p');	
		swal({   
				title: "<?php echo Lang::get('messages.msg_are_u_sure');?>",   
				text: "<?php echo Lang::get('messages.msg_no_longer_show');?>",   
				type: "warning",   
				showCancelButton: true, 
				cancelButtonText: "<?php echo Lang::get('messages.label_cancel');?>",				
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "<?php echo Lang::get('messages.msg_let_me_leave');?>" 
			}, 
			function(){
					
        $.ajax({
            type: "POST",
            url: '<?php echo URL::to('/')?>/leaveproject',
            data: {did:did,pid:pid },
            dataType: "json",
            success: function (response) {
				toastr.options = {"positionClass": "toast-top-center"};
					toastr['success'](response.msg); 
					window.location='<?php echo URL::to('/')?>/users';		         
            },
				error: function (response) {				
					toastr.options = {"positionClass": "toast-top-center"};
					toastr['error'](response.msg); 
				}
		   });
				});
			
		
	    });
	
	$('.leavemedata').click(function (e) {
       
		var did=$(this).attr('d');
		swal({   
				title: "<?php echo Lang::get('messages.msg_are_u_sure');?>",   
				text: "<?php echo Lang::get('messages.msg_no_longer_show');?>",   
				type: "warning",   
				showCancelButton: true,   
				cancelButtonText: "<?php echo Lang::get('messages.label_cancel');?>",	
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "<?php echo Lang::get('messages.msg_let_me_leave');?>" 
			}, 
			function(){
				     $.ajax({
						type: "POST",
						url: '<?php echo URL::to('/')?>/leavedataroom',
						data: {did:did},
						dataType: "json",
						success: function (response) {
							toastr.options = {"positionClass": "toast-top-center"};
								toastr['success'](response.msg); 
								window.location='<?php echo URL::to('/')?>/users';		         
						},
							error: function (response) {				
								toastr.options = {"positionClass": "toast-top-center"};
								toastr['error'](response.msg); 
							}
					});
				
			});	
   
    	});	
		
});
</script>
<script type="text/javascript" src="{{ URL::asset('assets/js/users.js') }}"></script>  
@endsection 