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
<div class="wrapper"  ng-app="ravabe" ng-controller="DataRoomList" >
  <div class="content">
    <div class="page-header clear">
      <?php if($UserRole=="admin") { ?>
      <div class="wflow-header clearfix">
        <div class="col-lg-10 col-md-12 col-sm-12">
          <div class="create-wflow clearfix">
            <div class="wflow_link"> <a href="{{url('dataroom/add')}}"><span><img alt="" src="{{URL::asset('assets/images/create_newworkflow.png')}}"></span> <span class="titlefw">Create a Dataroom</span></a> </div>
						</div>
        </div>
      </div>
      <?php } ?>
	  {{Form::open(array('url'=> 'dataroom/update','name'=>'dataroomupdate','id'=>'dataroomupdate'))}}
			<input type="hidden" value="" name="_token">
			<input type="hidden" value="" name="varDataRoomId" id="varDataRoomId"> 
			<input type="hidden" value="" name="varDataRoomUserId" id="varDataRoomUserId"> 
			<input type="hidden" value="" name="varDataRoomRole" id="varDataRoomRole">
			{{Form::close()}}
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
                <div class="title-ravabegroup"><a href="{{ url('/project/view?d=') }}<% dataroom.encyptid %>"><% dataroom.name %></a></div>
                <div class="group-middle">
                  <div class="org-groupicons"><img src="{{URL::asset('assets/images/usergroup-organization.png')}}" alt=""></div>
                  <div class="group-people">
                    <% dataroom.user_count %>
                    <span> People</span> </div>
                  <div class="group-people">
                    <div class="group-people-left">
                      <% dataroom.user_name %>
                    </div>
                    <div class="group-people-right">
                      <% dataroom.role %>
                    </div>
                  </div>
                  
                  <!-- <div class="add-groupUser">
							<a href="#"><img src="images/add-groupuser.png" alt=""></a>
							<a href="#"><img src="images/del-groupuser.png" alt=""></a>							
							</div>	 -->
                  <p><strong>Last Updated</strong></p>
                  <p>
                    <% dataroom.updated_at %>
                  </p>
                </div>
                <?php if($UserRole=="admin") { ?>  <div class="settingUtility"><i class="fa fa-cog"></i></div><?php }?>
                <div class="utility-box">
                  <ul>
                    <li class="editutility"> <i class="fa fa-pencil-square-o"></i> Edit</li>
                    <li class="copyutility"> <i class="fa fa-clone"></i> Copy</li>
                    <li class="moveutility"><i class="fa fa-arrows-alt"></i> Move</li>
                    <li class="shareutility"><i class="fa fa-share-alt"></i> Share</li>
                    <li class="delutility"> <i class="fa fa-times-circle"></i> Delete</li>
                  </ul>
                  <div class="info" style="display:none;">
                    <div class="id">
                      <% dataroom.id %>
                    </div>
                    <div class="uid">
                      <% dataroom.user_id %>
                    </div>
                    <div class="datarole">
                      <% dataroom.role %>
                    </div>
                  </div>
									<div class="utility-popup cutility clearfix">
                  <div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>
                  <div class="utility-popup-title">Copy File </div>
                  <hr>                    
                  <div class="fldr-title">Dataroom</div>
                  <div class="fldrsubmitTxt">
                  <input type="text" name="copyDataRoom" class="copyDataRoom submitnameFolder" value="<% dataroom.name %> - 1" />                   
                  </div>    
               <div class="content left">
               <div class="fldr-title">Copy Content with Structure  <input type="checkbox" class="CopyWithfiles cbx cbx1" name="CopyWithfiles"> </div>              
                           
               
               </div>             
                  <button did = "<% dataroom.id %>" type="button" onclick="CopyDRoom(this)" class="btn btn-lg btn-primary btn-red pull-right utilitybtn">Copy</button>
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
                  <div class="utility-popup-title"><b>Share </b></div>
                  <hr>
                  <div class="fldr-title">Copy Link:</div>
                  <div class="fldrsubmitTxt">
                    <div class="submitnameFolder sharelink autofocusbox"></div>
                  </div>
                 
                </div>
                <div class="viewdataroom_uploadfiles">
                  <div class="fileFieldAddimg" style="display:none"> <a href="javascript:;" class=""> <span class="filefieldbrowse"><img alt="" src="{{URL::asset('assets/images/uplod-imageicon.png')}}"></span> Add Image
                    <input type="file" onChange="$(&quot;#upload-file-info&quot;).html($(this).val());" size="40" name="file_source" style="position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:&quot;progid:DXImageTransform.Microsoft.Alpha(Opacity=0)&quot;;opacity:0;background-color:transparent;color:transparent;">
                    </a> &nbsp; <span id="upload-file-info" class="label label-info"></span> </div>
                </div>
                </div>
				 {{Form::open(array('url'=> 'dataroom/delete','name'=>'dataroomdelete','id'=>'dataroomdelete'))}}
			<input type="hidden" value="" name="_token">
			<input type="hidden" value="" name="DataRoomId" id="DataRoomId"> 
			<input type="hidden" value="" name="DataRoomUserId" id="DataRoomUserId"> 
			<input type="hidden" value="" name="DataRoomRole" id="DataRoomRole">
			{{Form::close()}}
    </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--<img class="loader" src="<?php //echo URL::to('/')?>/assets/images/home.gif"  > -->
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
		
		$('.delutility').on("click",function(e){
			e.stopPropagation();
			$(this).parents('.utility-box').find('.cutility').hide();
			$(this).parents('.utility-box').find('.mutility').hide();
			$(this).parents('.utility-box').find('.sutility').hide();	
			
			/*code for edit informations*/
			var DataRoomId = $(this).parents('.utility-box').find('.info').find('.id').html();			
			$("#DataRoomId").val(DataRoomId);
			//alert(varDataRoomId);
			var DataRoomUserId = $(this).parents('.utility-box').find('.info').find('.uid').html();
			$("#DataRoomUserId").val(DataRoomUserId);
			//alert(varDataRoomUserId);
			var DataRoomRole = $(this).parents('.utility-box').find('.info').find('.datarole').html();
			$("#DataRoomRole").val(DataRoomRole);
			//alert(varDataRoomRole);
			$("#dataroomdelete").submit();
			/* end code for edit informations*/
		});
		
		
		$('.copyutility').on("click",function(e){
			e.stopPropagation();
			$(this).parents('.utility-box').find('.cutility').show();
			$(this).parents('.utility-box').find('.mutility').hide();
			$(this).parents('.utility-box').find('.sutility').hide();
			//$(this).parents('.utility-box').find('.sutility').show();			
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
			var link = '';
			e.stopPropagation();		
			$(this).parents('.utility-box').find('.sutility').show();
			$(this).parents('.utility-box').find('.mutility').hide();
			$(this).parents('.utility-box').find('.cutility').hide();	
			var link = $(this).parents('.container_boxgroup').find('.title-ravabegroup').find('.ng-binding').attr('href');	
			$('.sharelink').html(link);
		});
		
		
		
		$('.utility-popup').on("click",function(e){
			utilitybx = 1;
		});
		
		 
		
	});
	
$('body,html').click(function(e) { 	
			//$('.utility-box').animate({height: "0px"});
		//	$(".utility-box").slideDown("slow");
			 //$('.utility-box').fadeOut(800);
			//$('.utility-box').hide();
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
</script> 
<script type="text/javascript" src="{{ URL::asset('assets/js/dataroom.js') }}"></script> 
<script> 
	function CopyDRoom(current) { 
		CopyWithfiles  = 0;	
		$(current).parents('.cutility').find('.dataRoomError').attr("style","display:none");
		var did=$(current).attr('did');
		dName  = $(current).parents('.cutility').find('.copyDataRoom').val();
	
		if($(current).parents('.cutility').find('.CopyWithfiles').prop("checked")) 
			CopyWithfiles  = 1;
		
		
			
		if (did && dName) {
			$.ajax({
				type: "POST",
				url: '<?php echo URL::to('/')?>/copydataroom',
				data: { did: did,dName: dName,CopyWithfiles: CopyWithfiles},
				dataType: "json",
				success: function (response) {									
					toastr.options = {"positionClass": "toast-top-center"};
					toastr['success'](response.msg); 
					window.location=URL+'/dataroom/view';				
				},
				error: function (response) {
					toastr.options = {"positionClass": "toast-top-center"};
					toastr['error'](response.msg); 
										
				}
			});
			} else {				
				toastr.options = {"positionClass": "toast-top-center"};
				toastr['error']('you did some thing is wrong. Please try again..'); 	
			
			}
    }
</script>
@endsection 