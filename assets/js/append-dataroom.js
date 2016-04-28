$(document).ready(function(){	
$(document).on("click", ".project-unit .testsetting", function(e) {
	
	//$('.project-unit .testsetting').on("click",function(e){		
		$('.utility-box').css({"display":"none"});
		$('.utility-box').animate({height: "0px"});
		
		//$('.project-unit').removeClass('active');
		
		$(this).find('.utility-box').animate({height: "100%"});
		$(this).find('.utility-box').css({"display":"block"});
		//$(this).parent().addClass('active');
		$('.copyutility').on("click",function(e){			
			e.stopPropagation();
			//$(this).parent('.utility-box').siblings('.cutility').show();
			$(this).parent('ul').parent('.utility-box').siblings('.CopyFile').show();
			$('.mutility').hide();
			$('.sutility').hide();			
		});
		$('.closeutilityPopup a').on("click",function(e){
			e.stopPropagation();
			$('.cutility').hide();			
		});

		$('.moveutility').on("click",function(e){			
			e.stopPropagation();			
			$(this).parents('.project-unit').find('.mutility').show();			
			$('.cutility').hide();			
			$('.sutility').hide();			
		});
		$('.closeutilityPopup a').on("click",function(e){
			e.stopPropagation();
			$('.mutility').hide();			
		});
		$('.closeCopyFile a').on("click",function(e){
			e.stopPropagation();
			$(this).parent('.closeCopyFile').parent('.CopyFile').hide();					
		});
		
		
		$('.shareutility').on("click",function(e){
			e.stopPropagation();		
			$(this).parents('.project-unit').find('.sutility').show();			
			$('.mutility').hide();
			$('.cutility').hide();
			$('.CopyFile').hide();								
		});
		$('.closeutilityPopup a').on("click",function(e){
			e.stopPropagation();
			$('.sutility').hide();			
		});
		
		$('.utility-popup').on("click",function(e){				
			utilitybx = 1;
		});
	});
	
$(document).on("click", ".dataroom-unit .dataroomunitwrap", function(e) {
	//$('.dataroomunitwrap').click(function() {
		var screenWidth = $(window).width();
		if (screenWidth >= 1000) {
			$('.dataroomunitwrap').parent().removeClass('active arrow-data');
			$(this).parent().addClass('active arrow-data');
			var top = $(this).offset().top + 40;
			var left = $('.project-wrapper').offset().left - 15;
			$('.dataroom-cursor').css({
				'display': 'block',
				'top': '50%',
				'left': left,
			});
		} else {
			
			$('.project-wrapper-mobile').addClass('open');
		}
	});
	$(document).on("click", ".project-unit .dataroomunitwrap", function(e) {
		var roomId=$(this).attr('room-en');
		setTimeout(function() {
                     window.location.href = URL + "/users/folder?p="+roomId;
                 }, 1000);
	});
	//project item hover effect
	$(document).on('mouseover', '.project-unit', function() {
		$('.project-unit').removeClass('hover');
		$(this).addClass('hover');
	});
		
	function closeProjectListDialog() {
		$('.project-wrapper-mobile').removeClass('open');
	}

$('body,html').click(function(e) { 	
//$('.utility-box').animate({height: "0px"});
$('.cutility').hide();
$('.mutility').hide();
$('.sutility').hide();
//$('.utility-box').hide();
});
	
});
	
