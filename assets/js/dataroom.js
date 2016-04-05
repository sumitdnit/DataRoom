
	ravabe.controller("DataRoomList", function($rootScope,$scope, $http) {
		$scope.alerts = [];
		$scope.page = 1;
		$scope.ismore = 0;
		$('.loader').show();
		//$('#publishing-alerts').css('opacity','0.5');
		//$('#publishing-alerts').css('pointer-events','none');
		
		$http.get(URL + '/dataroom/getroomlist').success(function(data, status) {
				 
				$scope.alerts=data.data;
			
				$scope.ismore=(data.resultcount < 30) ? 0 : 1;
				
				$scope.$watch($scope.alerts);
				$('.loader').hide();
				//$('#publishing-alerts').css('opacity','1');
				//$('#publishing-alerts').css('pointer-events','all');				
		});
	 
	});	
    