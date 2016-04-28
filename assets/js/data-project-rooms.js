
	ravabe.controller("ListofRooms", function($rootScope,$scope, $http) {
		var urlData = window.location.href;
		var tmp = urlData.split('?den=');
        var den = tmp[1];		
		$scope.alerts = [];
		$scope.page = 1;
		$scope.ismore = 0;
		$scope.projectView = 0;
		$http.get(URL + '/dataroom/getroomlist').success(function(data, status) {
				$scope.alerts=data.data;
				$scope.page +=1;
				$scope.ismore=(data.resultcount < 30) ? 0 : 1;
				if(den){
					$scope.showProjectsss(den,dataID);
					
					//$('#data-'+ den).trigger('click');
					
				}
				else if(data.data){
					//$('#data-'+ data.data[0]['encyptid']).trigger('click');
						$scope.showProjectsss(data.data[0]['encyptid'],data.data[0]['id']);
				}
		});
		// dataroom
		$scope.loadmore = function(){
			$http.get(URL + '/dataroom/getroomlist?page='+$scope.page).success(function(data, status) {
			 	for (var i=0; i<data.data.length; i++){
				 $scope.alerts[$scope.alerts.length]=data.data[i];
				}
				$scope.page +=1;
				$scope.ismore=(data.resultcount < 30) ? 0 : 1;
			});
		};

		// dataroom projects
		$scope.showProjectsss = function(did,dataID){
			$scope.projectView = 1;
			$scope.currentdid=0;
			$scope.page = 1;
			$scope.isproject = 0;
			$scope.proInfos={};	
			$http.get(URL + '/project/getprojectlist?d='+did).success(function(data, status) {
				$scope.proInfos=data.data;
				$scope.dataRoomEn = did;
				$scope.page +=1;
				$('#data-'+ dataID + ' .dataroomunitwrap').parent().addClass('active arrow-data');
				$scope.isproject=(data.resultcount < 30) ? 0 : 1;
			});
		};

		$scope.projectload = function(did){				
			$http.get(URL + '/project/getprojectlist?d='+$scope.dataRoomEn+'&page='+$scope.page).success(function(data, status) {
			 	for (var i=0; i<data.data.length; i++){
					$scope.proInfos[$scope.proInfos.length]=data.data[i];
				}
				$scope.page +=1;
				$scope.dataRoomEn = did;
				$scope.isproject=(data.resultcount < 30) ? 0 : 1;
			});
		};

		$scope.delProroom = function(proomiden,droomden){
			$scope.newproData={} ;
			$scope.newproData.dataRoomen=$('.dataroomutilitybtn').attr('diden');
			var data=$scope.newproData;
			swal({   
				title: varAreYouSure,   
				text: varNotAbleToRecoverProject,   
				type: "warning",   
				showCancelButton: true, 
				cancelButtonText: varCancel,				
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: varDeleteIt 
			}, 
			function(){
				$http.post(URL + '/project/delete?p='+proomiden,data).success(function(data, status) {
					if(data.error==1){
					  sweetAlert("Oops...",data.msg, "error");	
					  $('.maincontiner').css('opacity',"1");
						$('.loader').hide();
						$('.maincontiner').css('pointer-events',"all");
					  
					}
					else if(data.error==3){ 
						toastr.options = {"positionClass": "toast-top-center"};	
						toastr["success"](varmsgProjectDeletedSuccessfully);
						setTimeout(function()
								{
									$scope.showProjectsss(droomden);
								}, 1000);
					}
				});
				
			});
		};	
	 
	});
