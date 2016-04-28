@extends('layouts.protected')
@section('content')
<div class="second-header">
  <div class="breadcrumb-header">
    <ul>
      <li><a href="{{url('dataroom/view')}}">Dataroom</a></li>
      <li><a href="{{url('userdetail')}}">User</a></li>
    </ul>
  </div>
  <div class="content-header">
    <!--<section>
      <p>A-Z</p>
      <?php $firstUser = $Users[0];
	  //echo'<pre>';
	  //print_r($currentUser['id']);
	  //die;
	  
	  ?>
      <select class="form-control" name="selectuser" id="selectuser" >
        <option value="asc" <?php if($sortby=='profiles.firstname' && $ascdsc=='asc' ) { ?> selected="selected" <?php } ?> >Ascending</option>
        <option value="desc" <?php if($sortby=='profiles.firstname' && $ascdsc=='desc' ) { ?> selected="selected" <?php } ?>>Descending</option>
      </select>
    </section>
    <section>
      <p>Last Update</p>
      <select class="form-control" name="selectLastUpdated" id="selectLastUpdated">
        <option value="asc" <?php if($sortby=='users.updated_at' && $ascdsc=='asc' ) { ?> selected="selected" <?php } ?>>Ascending</option>
        <option value="desc" <?php if($sortby=='users.updated_at' && $ascdsc=='desc' ) { ?> selected="selected" <?php } ?>>Descending</option>
      </select>
    </section>-->
  </div>
</div>
<!-- End of Second Header -->
<!-- Draggagle Menu -->
<div class="workflow-draggable-menu swipe-area"> <a href="#" class="draggable-menu-action">
  <div class="label capture-label">
    <!--span></span-->
    <img src="<?php echo URL::to('/')?>/assets/images/user.png" alt=""> </div>
  </a> <a href="#" class="draggable-menu-action">
  <div class="menu-dots"> <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> </div>
  </a>
  <div class="container-fluid content workflow-draggable-menu-content swipe-area-content">
    <div class="menu-header">
      <div class="title">
        <h2>Datarooms/Projects</h2>
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
		
          <span class="leavemedata" d="<?php echo $dr->roomid;?>">Leave</span>
			
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
              
				<span class="leavemeproject" d="<?php echo $dr->roomid;?>" p="<?php echo $pr->projid;?>">Leave</span>
				
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
<div style="display:none;">
{{Form::open(array('url'=> 'dataroom/update','name'=>'dataroomupdate','id'=>'dataroomupdate'))}}
<input type="hidden" value="" name="_token">
<input type="hidden" value="" name="varDataRoomId" id="varDataRoomId">
<input type="hidden" value="" name="varDataRoomUserId" id="varDataRoomUserId">
<input type="hidden" value="" name="varDataRoomRole" id="varDataRoomRole">
{{Form::close()}}
</div>
<!-- End of Draggagle Menu -->
<div id="manager-user" class="main main-config main-drag">
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
            <p class="userrole"><?php echo ucfirst($firstUser->usertype)?></p>
          </div>
          <div class="col-md-3 col-xs-3">
            <?php 	
			
			
			if($currentUser['role']=="admin"){ 
			
			//die;
			if($firstUser->userid!=$currentUser['id']){
			?>
            <div class="user-tools"> <a href="javascript:editUserCard();"><img src="<?php echo URL::to('/')?>/assets/images/icon-pencil.png"></a>
              <!--<a href="#"><img src="<?php echo URL::to('/')?>/assets/images/icon-user-.png"></a>-->
              <a href="javascript::void(0);" class="DeleteUser" user="<?php echo $firstUser->userid ?>"><img src="<?php echo URL::to('/')?>/assets/images/delete.png"></a> </div>
            <?php }} ?>
          </div>
        </div>
      </div>
      <div class="content-body room">
        <ul class="double">
          <li><span class="small-text"><strong>E-mail</strong></span></li>
          <li><span class="small-text"><strong>Roles</strong> </span></li>
          <li><span class="small-text useremail"><?php echo $firstUser->email ?></span></li>
          <li> <span class="small-text user-card-role usertype"><?php echo ucfirst($firstUser->usertype) ?></span>
            <select class="user-role-dropdown" name="">
              <option value="user">User</option>
              <option value="admin">Admin</option>
              
            </select>
          </li>
          <li style="margin-top:15px;"> <span class="small-text"><strong>Internal User</strong> </span> <span class="small-text" style="margin-top:10px;">
            <?php if($firstUser->source=="internel"){?>
            <input type="checkbox" id="unchecked1" class="cbx cbx1 hidden" checked="checked">
            <?php } else {?>
            <input type="checkbox" id="unchecked1" class="cbx cbx1 hidden">
            <?php }?>
            <label for="unchecked1" class="lbl lbl1"></label>
            </span> </li>
        </ul>
        <ul class="double">
          <button class="btn-red" onclick="javascript:userDetailPopup();">See Details</button>
          <button class="btn-blue" style="display:none;" id="usersave" user="<?php echo $firstUser->userid ?>">Save</button>
        </ul>
      </div>
    </div>
  </div>
  
  
</div>
<div id="manager-user-menu">
  <div class="dashboard-draggable-menu dashboard-draggable-menu-open"> <a href="#" class="draggable-menu-action-dashboard">
    <!-- <div class="feed-btn">
                <img src="<?php echo URL::to('/')?>/assets/images/icon-feed.png" alt="Feed">
            </div> -->
    </a> <a href="#" class="draggable-menu-action-dashboard-mobile">
    <!-- <div class="feed-btn">
                <img src="<?php echo URL::to('/')?>/assets/images/icon-feed.png" alt="Feed">
            </div> -->
    </a>
    <div class="container-fluid content dashboard-draggable-menu-content dashboard-draggable-content-open">
      <div class="content-header ravabe-skin-sm scroll">
        <div class="scroller-friends">
          <?php foreach($Users as $user) { 
		  //print_r($user);
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
            <h4><span id="link"><?php if($user->firstname!=''){ ?><?php echo ucfirst(strtolower($user->firstname))." ".ucfirst(strtolower($user->lastname)) ?> <?php }else {?> 
			<?php echo $user->email; } ?>
			</span></h4>
            <p id="showusertype-<?php echo $user->userid?>"><?php echo ucfirst($user->usertype)?></p>
            </a> </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <!-- End of Dashbord Draggable Menu -->
  </div>
</div>
<script>

$(document).ready(function() {

	var URL='<?php echo URL::to('/')?>';
	
	$('.leavemeproject').click(function (e) {
       
		var did=$(this).attr('d');
		var pid=$(this).attr('p');	
		swal({   
				title: "<?php echo Lang::get('messages.msg_are_u_sure');?>",   
				text: "You will no longer see this!",   
				type: "warning",   
				showCancelButton: true,   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "Yes. Let me leave." 
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
					window.location='<?php echo URL::to('/')?>/userdetail';		         
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
				text: "You will no longer see this!",   
				type: "warning",   
				showCancelButton: true,   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "Yes. Let me leave." 
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
								window.location='<?php echo URL::to('/')?>/userdetail';		         
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
@endsection
