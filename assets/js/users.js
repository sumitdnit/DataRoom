
	ravabe.controller("ListofUsers", function($rootScope,$scope, $http) {
		$scope.revoke = function(){
			var usrid={'userId':$('.revokebtn').attr('revokeusr-id')};
			$http.post(URL + '/users/revokeuser',usrid).success(function(data, status) {
			 	if(data.flag=="error"){
					  sweetAlert("Oops...",data.msg, "error");	
					  $('.maincontiner').css('opacity',"1");
						$('.loader').hide();
						$('.maincontiner').css('pointer-events',"all");
					  
				}
				else if(data.flag=="success"){
					sweetAlert("Nice.",data.msg, "success");	
					  $('.maincontiner').css('opacity',"1");
						$('.loader').hide();
						$('.maincontiner').css('pointer-events',"all");
				}
			});
		};
	
	 
	});
