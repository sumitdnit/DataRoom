@extends('layouts.protected')
@section('content')
<style>
.showhide{display:none;}
.show{display:block;}
</style>
 <!-- Second Header -->
    <div class="second-header">

        <div class="breadcrumb-header">
            <ul>
                <li><a href="#">Rooms</a></li>
                <li><a href="#">Subrooms</a></li>
                <li><a href="#">Folders</a></li>
            </ul>
        </div>
				
				
				

        <div class="content-header">
           
            <section>
                <p>A-Z</p>
                <select class="form-control">
                    <option value="Select">Select</option>
                </select>
            </section>
            
            <section>
                <p>Last Update</p>
                <select class="form-control">
                    <option value="Select">Select</option>
                </select>
            </section>
            
        </div>

    </div>

    <!-- End of Second Header -->

    <div id="create-folders" class="main main-config main-drag">

       <!-- <div class="calendar">
            <div class="month-nav">
                <div class="previous">
                    <a href="">
                        <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                        <h1><strong>Dez</strong> 2015</h1>
                    </a>
                </div>
                <div class="next">
                    <a href="">
                        <h1><strong>Jan</strong> 2016</h1>
                        <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="calendar-days">
            <div class="calendar-data">
                <div class="date">
                    <h1 class="actual-day">sun<span>3</span></h1>
                </div>
                <div class="events ravabe-skin scroll">
                    <ul>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label compose-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label review-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="calendar-data">
                <div class="date">
                    <h1>mon<span>4</span></h1>
                </div>
                <div class="events ravabe-skin scroll">
                    <ul>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label compose-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label review-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="calendar-data">
                <div class="date">
                    <h1>tue<span>5</span></h1>
                </div>
                <div class="events ravabe-skin scroll">
                    <ul>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label compose-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label review-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="calendar-data">
                <div class="date">
                    <h1>wed<span>6</span></h1>
                </div>
                <div class="events ravabe-skin scroll">
                    <ul>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label compose-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label review-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="calendar-data">
                <div class="date">
                    <h1>thu<span>7</span></h1>
                </div>
                <div class="events ravabe-skin scroll">
                    <ul>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label compose-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label review-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="calendar-data">
                <div class="date">
                    <h1>fri<span>8</span></h1>
                </div>
                <div class="events ravabe-skin scroll">
                    <ul>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label compose-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label review-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="calendar-data">
                <div class="date">
                    <h1>sat<span>9</span></h1>
                </div>
                <div class="events ravabe-skin scroll">
                    <ul>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label compose-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label review-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="calendar-data">
                <div class="date">
                    <h1>sun<span>10</span></h1>
                </div>
                <div class="events ravabe-skin scroll">
                    <ul>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label compose-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label review-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="calendar-data">
                <div class="date">
                    <h1>mon<span>11</span></h1>
                </div>
                <div class="events ravabe-skin scroll">
                    <ul>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label compose-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label review-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="calendar-data">
                <div class="date">
                    <h1>tue<span>12</span></h1>
                </div>
                <div class="events ravabe-skin scroll">
                    <ul>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label compose-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label review-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="calendar-data">
                <div class="date">
                    <h1>wed<span>13</span></h1>
                </div>
                <div class="events ravabe-skin scroll">
                    <ul>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label compose-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label review-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="calendar-data">
                <div class="date">
                    <h1>thu<span>14</span></h1>
                </div>
                <div class="events ravabe-skin scroll">
                    <ul>
                        <li>
                            <div class="label capture-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label compose-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                        <li>
                            <div class="label review-label">
                                <span></span>
                            </div>
                            <p>Lorem Ipsum Dolor sit Amet.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div> -->

    
	<!-- Dashbord Draggable Menu -->
<div id="create-folder-file">
    <div class="dashboard-draggable-menu dashboard-draggable-menu-open">
        <a href="#" class="draggable-menu-action-dashboard">
            <!-- <div class="feed-btn">
                <img src="img/icon-feed.png" alt="Feed">
            </div> -->
        </a>
        <a href="#" class="draggable-menu-action-dashboard-mobile">
            <!-- <div class="feed-btn">
                <img src="img/icon-feed.png" alt="Feed">
            </div> -->
        </a>
        <div class="container-fluid content dashboard-draggable-menu-content dashboard-draggable-content-open">
            <div class="content-header">
                <div class="file-upload">
                    <div class="btn-box">
                        <button type="button" data-toggle="modal" id="OpenmyModal" data-target="#myModal">New Folder</button>
                    </div>
						
          <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content idea-detail-modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
										<div style="display:block;" class="output alert alert-dismissible">
											
											<div class="message-list"></div>
										</div>
										
                    <div class="idea-detail-header">

                        <div class="left">
                            <h4>Create new folder</h4>
                            
                        </div>
												<div class="left clear" >
                            <h6 class="error showhide dataroomerror">Please select Data Room first!!</h6>
														<h6 class="error showhide projecterror">Please select Project Room!! </h6>
														<h6 class="error showhide foldererror">Please enter folder name!! </h6>
                            
                        </div>
												<input type="hidden" name="projectId" id ="projectid" value="" >
												<input type="hidden" name="dataRoomId" id ="dataRoomId" value=""  >
                        <input type="text" name="projectfolder" id ="projectfolder" placeholder="Name Folder" required>
                        
                        <div class="clear"></div>
                        <button class="btn create-folder" >Create</button>
                        

                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
				
				
				
				
				
				

                    <div class="search-area">
                        <div class="search">
                            <input type="text" placeholder="Search">
                            <!-- Generator: Adobe Illustrator 18.0.0, SVG Export Plug-In  -->
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="20.2px" height="20.2px" viewBox="0 0 20.2 20.2" enable-background="new 0 0 20.2 20.2" xml:space="preserve">
                                <defs>
                                </defs>
                                <path fill="#C5C3C4" d="M11.7,0C7.1,0,3.3,3.8,3.3,8.4c0,1.8,0.6,3.5,1.6,4.9L0.1,18c-0.2,0.2-0.2,0.4,0,0.6l1.5,1.5
	c0.2,0.2,0.4,0.2,0.6,0l4.8-4.8c1.4,1,3,1.5,4.8,1.5c4.7,0,8.4-3.8,8.4-8.4S16.4,0,11.7,0z M11.7,14.4c-3.3,0-5.9-2.7-5.9-5.9
	s2.7-5.9,5.9-5.9s5.9,2.7,5.9,5.9S15,14.4,11.7,14.4z"></path>
                            </svg>


                        </div>
                    </div>



                </div>
            </div>
						
						<div class="select-dataroomList clearfix">
						<div class="col-lg-12 col-md-12 col-sm-12">
							
								<div class="addDropdown clearfix">
									<section>
								<p>Select Dataroom</p>
								<select class="form-control" id="userDataRoom">
										<option value="" >Select Dataroom</option>
										@if($data['dataroom']!=null)
											@foreach($data['dataroom'] as $key=>$alert)
										<option value="{{$alert->roomid}}">{{ $alert->name }}</option>
										  @endforeach
										@endif	
								</select>
								</section>

								<section>
								<p>Select Project</p>
								<select class="form-control" id="userProject" name="userProject">
										<option value="Select">Select</option>
								</select>
								</section>
								</div>
								
								
							
								
								
							</div>
						</div>
						
            <div class="activity-cards ravabe-skin-sm scroll">
									<?php if(sizeof($data['drfolders']) > 0){?>

                <ul id="tree2" class="navigatin-folders">
								<?php foreach($data['drfolders'] as $datatoomKey=>$dataroom){	?>
                    <li id="<?php echo $datatoomKey;?>" class="selectfolder"><a href="#"><?php echo $dataroom['dataroom']['name'];?></a> <small>Update: <?php echo date('m/d/Y | H:i A',strtotime($dataroom['dataroom']['drcreate']));?></small>
											<?php if (array_key_exists('projectroom', $dataroom['dataroom'])) { ?>
												<?php if(sizeof($dataroom['dataroom']['projectroom']) > 0){?>
												<ul>
												<?php foreach($dataroom['dataroom']['projectroom'] as $projectroomkey=>$projectroom){ ?>
												<li id="<?php echo $projectroomkey;?>" class="selectfolder"><a href="#"><?php echo $projectroom['name'];?></a> <small>Update: <?php echo date('m/d/Y | H:i A',strtotime($projectroom['prupdated']));?></small>
													<?php if (array_key_exists('folders', $projectroom)) { ?>
																	<?php if(sizeof($projectroom['folders']) > 0){	?>
																		<ul>
																				<?php foreach($projectroom['folders'] as $folderkey => $fold){?>
																				<li id="<?php echo $folderkey;?>" class="selectfolder"><a href="#"><?php echo $fold['name']; ?></a> <small>Update: <?php echo date('m/d/Y | H:i A',strtotime($fold['folderupdated']));?></small></li>
																				<?php } ?>
																		</ul>
																	<?php } ?>
																<?php } ?>	
															</li>
												<?php } ?>
												</ul>
												 <?php } ?>
                      <?php } else {?> 
											<ul>
                            <li>No folder available</li>
                        </ul>
											<?php }?>
                    </li>

                 
									<?php }
									
									?>
                    

                  
                </ul>
									<?php } ?>

            </div>
        </div>
        <!-- End of Dashbord Draggable Menu -->
    </div>
</div>
	
	
	
        <script type="text/javascript">
				var URL='<?php echo URL::to('/')?>';
  $(document).ready(function() {
    
			
			
    $('#lightSlider').lightSlider({
    });
    
      jQuery(".tm-input").tagsManager();
      $.fn.extend({
			treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews

$('#tree1').treed();

$('#tree2').treed({openedClass:'open-folder-icon', closedClass:'close-folder-icon'});

$('#tree3').treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});

     
			
  });
    
    
  	$('#userDataRoom').on('change', function() {
				var id = $(this).val();
				$("#dataRoomId").val(id);
				var userProject = $("#userProject").val();
				if( (userProject*1) == userProject)
					$("#projectid").val(userProject);
				else 
					$("#projectid").val();
				$.ajax({
					method: "GET",
					url: URL+"/project/getUserProject",
					data: { drId: id}
				})
				.done(function( arrProject ) {
					$.each(arrProject,function(i,proj){
						$("#userProject").append('<option value="'+proj.projid+'">'+proj.name+'</option>');
					});
					
				});
				
				
				
		});  
    $('#userProject').on('change', function() {
			var id = $(this).val();
			$("#projectid").val(id);
			var userDataRoom = $("#userDataRoom").val();
			if( (userDataRoom*1) == userDataRoom)
					$("#dataRoomId").val(userDataRoom);
				else 
					$("#dataRoomId").val();
			
			
		});
    $('.create-folder').on('click', function() {
			var $output = $(".output");
			var projectId = $('#projectid').val();
			var dataRoomId = $('#dataRoomId').val();
			var folderval = $('#projectfolder').val();
			console.log('folderval---'+folderval);
			if(!dataRoomId){
				$('.dataroomerror').removeClass('showhide');
				$('.dataroomerror').addClass('show');
				return false;
			}
			
			if(!projectId){
				$('.projecterror').removeClass('showhide');
				$('.projecterror').addClass('show');
				return false;
			}
			
			if(!folderval){
				$('.foldererror').removeClass('showhide');
				$('.foldererror').addClass('show');
				return false;
			}
			
			
				$.ajax({
					method: "GET",
					url: URL+"/project/savefolder",
					data: { dataRoomId:dataRoomId,projectId: projectId,foldername:folderval}
				})
				.done(function( result ) {
					var res = result.split("::");
					$(".output").show();
					if(res[0]=='error'){				
						if ($($output).hasClass('alert-success')){
							$output.removeClass("alert-success");
						}
						
						$output.addClass("alert-warning");
						$output.find(".message-list").html( res[1] );
						$output.fadeIn();
						console.log( res[1]);
						setTimeout( function(){	$('#myModal').modal('hide');	}  , 2000 );
					}
					else {
						if ($($output).hasClass('alert-warning')){
							$output.removeClass("alert-warning");
						}
						$output.addClass("alert-success");
						$output.find(".message-list").html( res[1] );
						$output.fadeIn();
						setTimeout( function(){	$('#myModal').modal('hide');	}  , 5000 );
					}
					
					//if(res[0]=='success'){
					//	$('#messageModal').modal('show');
					//	$('#success').html(res[1]);
				//}
					
				//	$('#myModal').modal('hide');
					
					
					
									
				});
			
				
			
			
			
		});
		
		$('#OpenmyModal').on('click',function (){
			$('.foldererror').removeClass('show');
				$('.projecterror').removeClass('show');
				$('.dataroomerror').removeClass('show');
				$('.foldererror').addClass('showhide');
				$('.projecterror').addClass('showhide');
				$('.dataroomerror').addClass('showhide');
			
		});
		
		$('#myModal').on('hidden.bs.modal', function (e) {
			$(".output").hide();
		  $('#projectfolder').val('');
	});
</script>
 
@endsection