$(document).ready(function() {
	//data room click event
	$(document).on("click", ".dataroomunitwrap", function(ee) {
		alert('sd');
	//$('.dataroomunitwrap').click(function() {
		var screenWidth = $(window).width();
		if (screenWidth >= 1000) {
			$('.dataroomunitwrap').parent().removeClass('active');
			$(this).parent().addClass('active');
			var top = $(this).offset().top + 40;
			var left = $('.project-wrapper').offset().left - 15;
			$('.dataroom-cursor').css({
				'display': 'block',
				'top': top,
				'left': left,
			});
			updateProjectContent();
		} else {
			
			$('.project-wrapper-mobile').addClass('open');
			updateProjectContent();
		}
	});

	//project item hover effect
	$(document).on('mouseover', '.project-unit', function() {
		$('.project-unit').removeClass('hover');
		$(this).addClass('hover');
	});
});

function getProjectFromDataRoom() {
//	(function($) {
//	}(jQuery));
}

// close project mobile dialog when click close button 
function closeProjectListDialog() {
	$('.project-wrapper-mobile').removeClass('open');
}


function updateProjectContent() {
	//get data from api and set content to HTML DOM (class -> project-list)
	var html = [
		'<div class="project-add">',
			'<a class="add-btn" href="javascript:void(0);"><i class="glyphicon glyphicon-plus"></i></a>',
		'</div>',
		
		'<div class="project-unit active clearfix">',
			'<div class="dataroomunitwrap">',
				'<div class="title-wrapper">',
					'<div class="title">DATAROOM</div>',
					'<div class="sub-title">Anka Ariuntsetseg</div>',
				'</div>',
			'<div class="project-qty">5</div>',
			'<div class="update-wrapper">',
				'<div class="title">Last Updated</div>',
				'<div>04/05/2016 | 07:04 AM</div>',
			'</div>',
			'</div>',
			'<div class="testsetting">',
			'<div class="setting-wrapper">',
				'<a href="#"><img src="/assets/img/setting-icon.png" alt=""></a>',
			'</div>',
			'<div class="utility-box">',
								'<ul>',
								'<li class="editutility"><a href="#"> <i class="fa fa-pencil-square-o"></i> Edit</a></li>',
								'<li class="copyutility"><a href="#"> <i class="fa fa-clone"></i> Copy</a></li>',
								'<li class="moveutility"><a href="#"> <i class="fa fa-arrows-alt"></i> Move</a></li>',
								'<li class="shareutility"><a href="#"> <i class="fa fa-share-alt"></i> Share</a></li>',
								'</ul>',
								'</div>',
			
			'</div>',			
				'<div class="utility-popup cutility clearfix">',
						'<div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>',
						'<div class="utility-popup-title">Copy File </div>',
						'<hr>',
						'<div class="fldr-title">Title:</div>',
						'<div class="fldrsubmitTxt">',
							'<div class="submitnameFolder">Contract-china-january.pdf</div>',
						'</div>',
						'<div class="folder-option">Folder:</div>',
						'<div class="folder-name">China </div>',
						'<button class="btn btn-lg btn-primary btn-red pull-right utilitybtn" type="submit">Copy</button>',
				'</div>',
				
				'<div class="utility-popup mutility clearfix">',
								'<div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>',
								'<div class="utility-popup-title">Move File </div>',
								'<hr>',					
								'<div class="folder-option">Folder:</div>',
								'<div class="folder-name">China </div>',						
								'<div class="selFolder">',
									'<select><option>Folder</option><option>Folder</option><option>Folder</option></select>',
								'</div>',
								'<div class="fldrsubmitTxt">',
									'<div class="submitnameFolder">Contract-china-january.pdf</div>',
								'</div>',						
								'<button class="btn btn-lg btn-primary btn-red pull-right utilitybtn" type="submit">Move</button>',
				'</div>',				
				
				'<div class="utility-popup sutility clearfix">',
								'<div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>',
								'<div class="utility-popup-title">Share </div>',
								'<hr>',
								'<div class="fldr-title">Copy Link:</div>',
								'<div class="fldrsubmitTxt">',
		'<div id="selectable" class="submitnameFolder submitautofocus" onclick="this.select()">http://drive.com/loremipsum/</div>',							
									'<p class="member-visible">Private. Only visible to members on the board. </p>',
								'</div>',												
				'</div>',
			
			'</div>',
			
			
			'<div class="project-unit clearfix">',
			'<div class="dataroomunitwrap">',
				'<div class="title-wrapper">',
					'<div class="title">DATAROOM</div>',
					'<div class="sub-title">Anka Ariuntsetseg</div>',
				'</div>',
			'<div class="project-qty">5</div>',
			'<div class="update-wrapper">',
				'<div class="title">Last Updated</div>',
				'<div>04/05/2016 | 07:04 AM</div>',
			'</div>',
			'</div>',
			'<div class="testsetting">',
			'<div class="setting-wrapper">', 
				'<a href="#"><img src="/assets/img/setting-icon.png" alt=""></a>',
			'</div>',
			'<div class="utility-box">',
								'<ul>',
								'<li class="editutility"><a href="#"> <i class="fa fa-pencil-square-o"></i> Edit</a></li>',
								'<li class="copyutility"><a href="#"> <i class="fa fa-clone"></i> Copy</a></li>',
								'<li class="moveutility"><a href="#"> <i class="fa fa-arrows-alt"></i> Move</a></li>',
								'<li class="shareutility"><a href="#"> <i class="fa fa-share-alt"></i> Share</a></li>',
								'</ul>',
								'</div>',
			
			'</div>',			
				'<div class="utility-popup cutility clearfix">',
						'<div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>',
						'<div class="utility-popup-title">Copy File </div>',
						'<hr>',
						'<div class="fldr-title">Title:</div>',
						'<div class="fldrsubmitTxt">',
							'<div class="submitnameFolder">Contract-china-january.pdf</div>',
						'</div>',
						'<div class="folder-option">Folder:</div>',
						'<div class="folder-name">China </div>',
						'<button class="btn btn-lg btn-primary btn-red pull-right utilitybtn" type="submit">Copy</button>',
				'</div>',
				
				'<div class="utility-popup mutility clearfix">',
								'<div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>',
								'<div class="utility-popup-title">Move File </div>',
								'<hr>',					
								'<div class="folder-option">Folder:</div>',
								'<div class="folder-name">China </div>',						
								'<div class="selFolder">',
									'<select><option>Folder</option><option>Folder</option><option>Folder</option></select>',
								'</div>',
								'<div class="fldrsubmitTxt">',
									'<div class="submitnameFolder">Contract-china-january.pdf</div>',
								'</div>',						
								'<button class="btn btn-lg btn-primary btn-red pull-right utilitybtn" type="submit">Move</button>',
				'</div>',				
				
				'<div class="utility-popup sutility clearfix">',
								'<div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>',
								'<div class="utility-popup-title">Share </div>',
								'<hr>',
								'<div class="fldr-title">Copy Link:</div>',
								'<div class="fldrsubmitTxt">',
		'<div id="selectable" class="submitnameFolder submitautofocus" onclick="this.select()">http://drive.com/loremipsum/</div>',							
									'<p class="member-visible">Private. Only visible to members on the board. </p>',
								'</div>',												
				'</div>',
			
			'</div>',
			
			
			'<div class="project-unit clearfix">',
			'<div class="dataroomunitwrap">',
				'<div class="title-wrapper">',
					'<div class="title">DATAROOM</div>',
					'<div class="sub-title">Anka Ariuntsetseg</div>',
				'</div>',
			'<div class="project-qty">5</div>',
			'<div class="update-wrapper">',
				'<div class="title">Last Updated</div>',
				'<div>04/05/2016 | 07:04 AM</div>',
			'</div>',
			'</div>',
			'<div class="testsetting">',
			'<div class="setting-wrapper">',
				'<a href="#"><img src="/assets/img/setting-icon.png" alt=""></a>',
			'</div>',
			'<div class="utility-box">',
								'<ul>',
								'<li class="editutility"><a href="#"> <i class="fa fa-pencil-square-o"></i> Edit</a></li>',
								'<li class="copyutility"><a href="#"> <i class="fa fa-clone"></i> Copy</a></li>',
								'<li class="moveutility"><a href="#"> <i class="fa fa-arrows-alt"></i> Move</a></li>',
								'<li class="shareutility"><a href="#"> <i class="fa fa-share-alt"></i> Share</a></li>',
								'</ul>',
								'</div>',
			
			'</div>',			
				'<div class="utility-popup cutility clearfix">',
						'<div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>',
						'<div class="utility-popup-title">Copy File </div>',
						'<hr>',
						'<div class="fldr-title">Title:</div>',
						'<div class="fldrsubmitTxt">',
							'<div class="submitnameFolder">Contract-china-january.pdf</div>',
						'</div>',
						'<div class="folder-option">Folder:</div>',
						'<div class="folder-name">China </div>',
						'<button class="btn btn-lg btn-primary btn-red pull-right utilitybtn" type="submit">Copy</button>',
				'</div>',
				
				'<div class="utility-popup mutility clearfix">',
								'<div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>',
								'<div class="utility-popup-title">Move File </div>',
								'<hr>',					
								'<div class="folder-option">Folder:</div>',
								'<div class="folder-name">China </div>',						
								'<div class="selFolder">',
									'<select><option>Folder</option><option>Folder</option><option>Folder</option></select>',
								'</div>',
								'<div class="fldrsubmitTxt">',
									'<div class="submitnameFolder">Contract-china-january.pdf</div>',
								'</div>',						
								'<button class="btn btn-lg btn-primary btn-red pull-right utilitybtn" type="submit">Move</button>',
				'</div>',				
				
				'<div class="utility-popup sutility clearfix">',
								'<div class="closeutilityPopup"><a href="#"><i class="fa fa-times"></i></a></div>',
								'<div class="utility-popup-title">Share </div>',
								'<hr>',
								'<div class="fldr-title">Copy Link:</div>',
								'<div class="fldrsubmitTxt">',
		'<div id="selectable" class="submitnameFolder submitautofocus" onclick="this.select()">http://drive.com/loremipsum/</div>',							
									'<p class="member-visible">Private. Only visible to members on the board. </p>',
								'</div>',												
				'</div>',
			
			'</div>',
			
		'<script type="text/javascript" src="js/append-dataroom.js"></script>',
		
	].join("");	

	$('.project-list').html(html);
}






