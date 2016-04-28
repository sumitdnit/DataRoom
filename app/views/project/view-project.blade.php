@extends('layouts.protected')
@section('content')
<style>
.setbtn .btn-default.btn-xs {float: left;margin: 0 5px;}
.autofocusbox {
	border-color :#298fca;
	box-shadow:0 0 2px #298fca;
	background:#fff;
}
</style>

<div class="wrapper"  ng-app="ravabe" ng-controller="ProjectList" >
  <div class="content">
  
    <div class="page-header clear">
    <div class="row"> 
   <div class="col-lg-12 col-md-12 col-sm-12" > 
   <?php 
   $Dataroom 	  = Dataroom::where('id', $did)->first();
   $dname = '';
   $varGetDataRoomId = base64_encode($did);
   if(sizeof($Dataroom)>0) {   
   	$dname = ucfirst($Dataroom->name);
   }
    ?>
   <div class="breadcrumb-header clearfix">
           <ul style="float:left">
               <li><a href="{{url('dataroom/view')}}">Dataroom</a></li>
               <?php if($dname ){ ?>
               <li><a href="{{url('project/view')}}?d=<?php echo $varGetDataRoomId?>">{{$dname}}</a></li>
               <?php } else { ?>
               <li><a href="{{url('project/view')}}">Project</a></li>
               <?php } ?>
           </ul>
		   
		   
		   <div class="dropFilter clearfix">
			<div class="addDropdown">	
           
			<select id="userProject" class="form-control ng-pristine ng-untouched ng-valid">
			<?php $fristdataRoomid = ''; 
			if(sizeof($arrDataRoom)>0) { ?>
               	<?php foreach($arrDataRoom as $dkey => $dr) { 
				 	if(trim($dr->name)) {
				?>
               <option value="<?php echo $dr->roomid?>" <?php if($did==$dr->roomid){ ?> selected="selected" <?php } ?>><?php echo ucfirst($dr->name); ?></option>
              	 <?php } }?>
               <?php } else {  ?> 
			<option>Select Dataroom</option>
                <?php } ?>
			
			</select>	
               <?php
			if(sizeof($arrDataRoom)>0) { ?>
               	<?php foreach($arrDataRoom as $dkey => $dr) { 
				 	if(trim($dr->name)) {
				?>
                    <a href="{{url('project/view')}}?d=<?php echo base64_encode($dr->roomid)?>" id="<?php echo $dr->roomid?>" style="display:none;">text </a>
                    
                 <?php } } } ?>   
			</div>
			<button class="btn btn-red btn-login btn-primary filterBtn">Filter</button>               
                 </div>
		   
       </div>
   </div>
  </div>
		 <?php if($UserRole=="admin") { ?>
      <div class="wflow-header clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="create-wflow clearfix">
          <div class="wflow_link">         	
					{{Form::open(array('url'=> 'project/add-project','name'=>'add-project','method'=>'GET','id'=>'add-project'))}}
						<input type="hidden" value="<?php if(base64_decode($encyid) > 0) echo $encyid;?>" name="d" id="varPostDataRoomId">
             				<span><img alt="" src="{{URL::asset('assets/images/create_newworkflow.png')}}"></span> 
						<input type="submit" value="Create a Project" class="titlefw"/>
					{{Form::close()}}
                 
                            
                   
			</div>
          </div>
        </div>
        
        
       
					
			<!--<div class="wflow_link">
			<div class="col-lg-12 col-md-12 col-sm-12">		
			<a href="#"><span><img alt="" src="img/create_newworkflow.png"></span> <span class="titlefw">Create a Data Room</span></a>		
			<div class="dropFilter clearfix">
			<div class="addDropdown">		
			<select ng-change="showFolders()" ng-model="org.project_id" id="userProject" class="form-control ng-pristine ng-untouched ng-valid">
			<option value="0">-Select Project-</option>
			<option>Project A</option>
			<option>Project B</option>
			<option>Project C</option>
			</select>	
			</div>
			<button class="btn btn-red btn-login btn-primary filterBtn">Filter</button>
			</div>
			</div>
			</div>-->
			
		
		
        
        
      </div>
			<?php } ?>
    </div>
    <div> @if (Session::has('message'))
      <div class="alert alert-info">{{ Session::get('message') }}</div>
      @endif </div>
    <!-- Dataroom Grid view Section start -->
    <div class="row" >
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="ravabe-organization">
          <div class="row" >
            <div class="col-md-15 col-sm-3" ng-repeat="(index,dataroom) in alerts">
              <div class="container_boxgroup" >
                <div class="title-ravabegroup"><a href="{{ url('users/folder?p=<% dataroom.encyptid %>') }}"><% dataroom.name %></a></div>
               
                <div class="group-middle">
                  <div class="org-groupicons"><img src="{{URL::asset('assets/images/usergroup-organization.png')}}" alt=""></div>
                  <div class="group-people"><% dataroom.user_count %> <span> People</span> </div>
				  <div class="group-people"><div class="group-people-left"><% dataroom.user_name %> </div> <div class="group-people-right"><% dataroom.role %> </div> </div>
                     
                  <!-- <div class="add-groupUser">
							<a href="#"><img src="images/add-groupuser.png" alt=""></a>
							<a href="#"><img src="images/del-groupuser.png" alt=""></a>							
							</div>	 -->
                  <p><strong>Last Updated</strong></p>
                  <p><% dataroom.updated_at %></p>
                </div>
                
               <?php if($UserRole=="admin") { ?> <div class="settingUtility"><i class="fa fa-cog"></i></div>	<?php }?>					
						<div class="utility-box">
							<ul>
								<li class="editutility"> <a href="{{ url('project/edit?p=') }}<% dataroom.encyptid %>"><i class="fa fa-pencil-square-o"></i>Edit</a></li>
								<li class="copyutility"> <i class="fa fa-clone"></i> Copy</li>
								<li class="moveutility"><i class="fa fa-arrows-alt"></i> Move</li>
								<li class="shareutility"><i class="fa fa-share-alt"></i> Share</li>
                                <li class="delutility" ng-click="delProroom(dataroom.encyptid)" id="delProject" proj-id="<% dataroom.encyptid %>"><i class="fa fa-times-circle"></i>Delete</li>
							</ul>
						<div class="info" style="display:none;">
							<div class="id"><% dataroom.id %></div>
							<div class="uid"><% dataroom.user_id %></div>
							<div class="datarole"><% dataroom.role %></div>
						</div>
						<div class="utility-popup cutility clearfix">
							<div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>
							<div class="utility-popup-title">Copy File </div>
							<hr>
							<div class="fldr-title">Title:</div>
							<div class="fldrsubmitTxt">
								<div class="submitnameFolder">Contract-china-january.pdf</div>
							</div>
							<div class="folder-option">Folder:</div>
							<div class="folder-name">China </div>
							<button type="submit" class="btn btn-lg btn-primary btn-red pull-right utilitybtn">Copy</button>
						</div>
                              
            <div class="utility-popup mutility clearfix">
							<div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>
							<div class="utility-popup-title">Move File </div>
							<hr>					
							<div class="folder-option">Folder:</div>
							<div class="folder-name">China </div>						
							<div class="selFolder">
								<select>
									<option>Folder</option>
									<option>Folder</option>
									<option>Folder</option>
								</select>
							</div>
							<div class="fldrsubmitTxt">
								<div class="submitnameFolder">Contract-china-january.pdf</div>
							</div>						
							<button type="submit" class="btn btn-lg btn-primary btn-red pull-right utilitybtn">Move</button>
						</div>
                              
            <div class="utility-popup sutility clearfix">
							<div class="closeutilityPopup"><a href="javascript:void(0);"><i class="fa fa-times"></i></a></div>
							<div class="utility-popup-title"><b>Share</b> </div>
							<div class="fldr-title">Copy Link:</div>
							<div class="fldrsubmitTxt">
								<div class="submitnameFolder sharelink autofocusbox" >&nbsp;</div>
							</div>						
						</div>
                              
            <div class="viewdataroom_uploadfiles">	
					<!--<div class="fileFieldAddimg">
								<a href="javascript:;" class=""> 
									<span class="filefieldbrowse"><img alt="" src="{{URL::asset('assets/images/uplod-imageicon.png')}}"></span>
									Add Image
									<input type="file" onChange="$(&quot;#upload-file-info&quot;).html($(this).val());" size="40" name="file_source" style="position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:&quot;progid:DXImageTransform.Microsoft.Alpha(Opacity=0)&quot;;opacity:0;background-color:transparent;color:transparent;">
									</a>
									&nbsp;
									<span id="upload-file-info" class="label label-info"></span>
							</div>
					-->
					</div> 
						</div>
                              
                 
                  
              </div>
            </div>
			
			
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--<img class="loader" src="<?php //echo URL::to('/')?>/assets/images/home.gif"  >-->
<script>

$(document).ready(function(){

$(document).on("click", ".settingUtility", function(ee) {
	  $('.utility-box').hide();
		$('.sutility').hide();
		$(this).find('.utility-box').animate({height:"0"});
		$(this).siblings('.utility-box').css({display: "block"});;
		$(this).siblings('.utility-box').animate({height: "130px"});		
		ee.stopPropagation();
		
		$('.editutility').on("click",function(e){
			e.stopPropagation();
			$(this).parents('.utility-box').find('.cutility').hide();
			$(this).parents('.utility-box').find('.mutility').hide();
			$(this).parents('.utility-box').find('.sutility').hide();	
			
			/*code for edit informations*/
			var varDataRoomId = $(this).parents('.utility-box').find('.info').find('.id').html();			
			$("#varDataRoomId").val(varDataRoomId);
			var varDataRoomUserId = $(this).parents('.utility-box').find('.info').find('.uid').html();
			$("#varDataRoomUserId").val(varDataRoomUserId);
			var varDataRoomRole = $(this).parents('.utility-box').find('.info').find('.datarole').html();
			$("#varDataRoomRole").val(varDataRoomRole);
			$("#dataroomupdate").submit();
			/* end code for edit informations*/
		});
		
		
		$('.copyutility').on("click",function(e){
			e.stopPropagation();
			$(this).parents('.utility-box').find('.cutility').hide();
			$(this).parents('.utility-box').find('.mutility').hide();
			$(this).parents('.utility-box').find('.sutility').hide();			
		});
		
		
		$('.closeutilityPopup').on("click",function(e){
			e.stopPropagation();
			$('.utility-box').fadeOut(800);
			$(this).parents('.utility-box').find('.cutility').hide();	
			$('.utility-box').animate({height: "0px"});
			$(this).parents('.utility-box').find('.sutility').hide();
			$(this).parents('.utility-box').find('.mutility').hide();
			$(this).parents('.utility-box').find('.cutility').hide();				
		});

  
		$('.moveutility').on("click",function(e){
			e.stopPropagation();			
			$(this).parents('.utility-box').find('.mutility').hide();
			$(this).parents('.utility-box').find('.cutility').hide();			
			$(this).parents('.utility-box').find('.sutility').hide();			
		});
		
		
		
		
		
		$('.shareutility').on("click",function(e){
			e.stopPropagation();			
			$(this).parents('.utility-box').find('.sutility').show();
			$(this).parents('.utility-box').find('.mutility').hide();
			$(this).parents('.utility-box').find('.cutility').hide();	
			var link = $(this).parents('.container_boxgroup').find('.title-ravabegroup').find('.ng-binding').attr('href');	
			$('.sharelink').html(link);
			//$('.sharelink').select();						
		});
		
		$('.closeutilityPopup').on("click",function(e){
			e.stopPropagation();
			$(this).parents('.utility-box').find('.sutility').hide();			
		});
		
		
		$('.utility-popup').on("click",function(e){
			//alert("HI");			
			utilitybx = 1;
		});
		
		 
		
	});
	
	$('body,html').click(function(e) { 	
			 //$('.utility-box').fadeOut(800);
	});
	
	$('.settingUtility').click(function(e) { 	
	$('.utility-box').animate({height: "0px"});
	$('.cutility').hide();
	$('.mutility').hide();
	$('.sutility').hide();
	$('.utility-box').hide();
	});	
	
});
</script>


<script>	
var URL='<?php echo URL::to('/')?>';
var did ='<?php echo base64_encode($did); ?>';

</script>
<script type="text/javascript" src="{{ URL::asset('assets/js/projectroom.js') }}"></script>
<script> 
$(document).ready(function(){
	$( ".filterBtn" ).click(function() {
		 var pro = $( "#userProject" ).val();
		  var Dpro = $( "#"+pro).attr('href');
		 window.location = Dpro;
	});
});
</script>

@endsection 
