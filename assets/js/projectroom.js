
	ravabe.controller("ProjectList", function($rootScope,$scope, $http) {
		$scope.alerts = [];
		$scope.page = 1;
		$scope.ismore = 0;
		$('.loader').show();
		$('#publishing-alerts').css('opacity','0.5');
		$('#publishing-alerts').css('pointer-events','none');
		$scope.newproData={};
		$http.get(URL + '/project/getprojectlist?d='+did).success(function(data, status) {
				 
				$scope.alerts=data.data;
				$scope.ismore=(data.resultcount < 30) ? 0 : 1;
				
				$scope.$watch($scope.alerts);
				$('.loader').hide();
				//$('#publishing-alerts').css('opacity','1');
				//$('#publishing-alerts').css('pointer-events','all');				
		});
		$scope.delProroom = function(proomiden){
			$scope.newproData.dataRoomen=did;
			var data=$scope.newproData;
			$http.post(URL + '/project/delete?p='+proomiden,data).success(function(data, status) {
					if(data.error==1){
					  sweetAlert("Oops...",data.msg, "error");	
					  $('.maincontiner').css('opacity',"1");
						$('.loader').hide();
						$('.maincontiner').css('pointer-events',"all");
					  
					}
					else if(data.error==3){ 
						toastr.options = {"positionClass": "toast-top-center"};	
						toastr["success"]("Project room has been successfully deleted.");
						setTimeout(function()
								{
									window.location.href=URL +"/project/view?d="+did; 
								}, 3000);
					}
			});
		};	
	 
	});	

    