 var app=  angular.module('ravabedata', ['ngResource','ngBootbox','angucomplete-alt'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});
   app.controller("ProjectInfo", function($rootScope,$scope, $http) {
		$scope.remoteUrlRequestFn = function(str) {
			return {term: str};
		};
		$scope.addtableid={};
		$scope.newproData ={};
		$scope.emailSelected='';
		var users;
		var arremail=[];
		var arremailid=[];
		var arremailrole=[];
		$http.get(URL + '/project/edit-project?p='+proId).success(function(data, status) {
				 
				$scope.proData=data.data;		
				$scope.newproData.proid = $scope.proData.encyptid;
				$scope.newproData.name = $scope.proData.name;
				$scope.newproData.description = $scope.proData.description;
				$scope.newproData.company = $scope.proData.company;
				$scope.newproData.domain_restrict = $scope.proData.domain_restrict;
				$scope.newproData.dataroom_id = $scope.proData.dataroom_id;
				$scope.newproData.dataroom_id_encypt = $scope.proData.dataroom_id_encypt;
				if($scope.proData.addedUsersInfo){
					users = $scope.proData.addedUsersInfo
					for(ind in users){
						$scope.addtableid[ind]=users[ind]['addtableid'];
						$scope.addUser(users[ind]['addemail'],users[ind]['addemailid'],'',"internal");
					}
				}
		});
		$scope.updatePro = function(e) {
			var newaddusers =[];
			$('input[name^="userEmail"]').each(function(index) {
				arremail[index]=($(this).val());
			});
			$('input[name^="userId"]').each(function(index) {
				arremailid[index]=($(this).val());
			});
			$('input[name^="userRole"]').each(function(index) {
				arremailrole[index]=($(this).val());
			});
			for(ind in arremail){
				newaddusers [ind] ={
					addemail:arremail[ind],
					addemailid:arremailid[ind],
					addrole:arremailrole[ind],
				};
			}
			
			console.log(newaddusers);
			$scope.newproData.usersList=newaddusers;
			$scope.newproData.addtableid=$scope.addtableid;
			$scope.newproData.internel_user=$('#internel_user').val();
			$scope.newproData.view_only=$('#view_only').val();
			var data=$scope.newproData;
			$http.post(URL + '/project/update-project', data).success(function(data, status) {
				if(data.error==1){
						
					  sweetAlert("Oops...",data.msg, "error");	
					  $('.maincontiner').css('opacity',"1");
						$('.loader').hide();
						$('.maincontiner').css('pointer-events',"all");
					  
					}else if(data.error==3){ 
						toastr.options = {"positionClass": "toast-top-center"};	
					toastr["success"]("Project room has been successfully saved.");
						//$.toaster({ priority : 'success', title : "Success", message : "Organization has been successfully saved" , timeout:5000});
						setTimeout(function()
								{
									window.location.href=URL +"/project/view?d="+$scope.proData.dataroom_id_encypt; 
								}, 3000);
					}else if(data.error==2){ 
						toastr.options = {"positionClass": "toast-top-center"};	
					toastr["success"]("Project room has been successfully saved.");
						//$.toaster({ priority : 'success', title : "Success", message : "Organization has been successfully saved" });
						if(data.invlist.length>0){
							
							$.each(data.invlist, function(i,objn) {
								toastr.options = {"positionClass": "toast-top-center"};	
								toastr["success"]("User has been successfully invited.");
								//$.toaster({ priority : 'success', title : objn, message : "User has been successfully invited"});
								
							});	
						}
						if(data.errorlist.length>0){
							$.each(data.errorlist, function(i,objn) {
								toastr.options = {"positionClass": "toast-top-center"};	
								toastr["error"]("User was not invited. Please add again.");
								//$.toaster({ priority : 'danger', title : objn, message : "User was not invited. Please add again" });
								
							});	
						}
						
						setTimeout(function()
								{
									window.location.href=URL +"/project/view?d="+$scope.proData.dataroom_id_encypt; 
								}, 3000);
						
					}else{
						toastr.options = {"positionClass": "toast-top-center"};	
						toastr["error"]("Something gone wrong. Please try again");
						//$.toaster({ priority : 'danger', title : 'Error', message : "Something gone wrong. Please try again" , timeout:5000});	
						setTimeout(function()
								{
									window.location.href=URL +"/project/view?d="+$scope.proData.dataroom_id_encypt; 
								}, 3000);
						
					}
			});
			console.log($scope.addtableid);
			console.log($scope.newproData.name);
		};
		$scope.inviteuser = function(e) {
			 
			 
			 
			 
			 if($.trim($('#email_value').val())==''){
					   $('#email').next().html('Please enter valid email.<a title="close" aria-label="close" data-dismiss="alert" class="close closegreen" href="#">×</a>');					   					   
					  $('#email').next().show();
					  $('#email_value').focus(); 
					  $('.successvalidation').hide();
					  return false;
			 }
			 
			 
			 if($.trim($('#email_value').val()) == $.trim(currentUserEmail)){
						$('#email').next().html('You can not add yourself !!<a title="close" aria-label="close" data-dismiss="alert" class="close closegreen" href="#">×</a>');
						$('#email').next().show();
						$('#email_value').focus(); 
						$('.successvalidation').hide();
						return false;

					}
			 if($('.nameUserManage').length>0){
				 var flag=true;
				 $('.nameUserManage').each(function( index, value ) {

					 

					if($(this).attr('data-id')==$.trim($('#email_value').val()) && flag){
						  $('#email').next().html('This email was already added<a title="close" aria-label="close" data-dismiss="alert" class="close closegreen" href="#">×</a>');
						  $('#email').next().show();
						  $('#email_value').focus(); 
						  $('.successvalidation').hide();
						  flag=false;
					}
				});
				if(!flag) return false;
		    }
						
		     if(typeof $scope.emailSelected =='object'){
				 
				  $scope.addUser($scope.emailSelected.email,$scope.emailSelected.id,$scope.emailSelected.photo,"internal");
				   $scope.emailSelected={};
				   $('#email_value').val('');
				   if(!$scope.domain_restrict){
						$('.successvalidation').show();
				   }
				 
			 }else{
				 	 
		
					 $('#email').next().html('Only Added User allowed.<a title="close" aria-label="close" data-dismiss="alert" class="close closegreen" href="#">×</a>');
					  $('#email').next().show();
					  $('#email_value').focus(); return false;
			
			}	
			 
		};
		$scope.addUser = function(email,id,photo,utype){
			var addUserFlag = restrictDomain(email, $scope.domain_restrict);
			if(addUserFlag){
				var datas = '<div class="usrControl" id="userid-'+id+'" ieuser="'+utype+'">';
				datas += '<input type="hidden" value="'+email+'" name="userEmail[]" />';
				datas += '<input type="hidden" value="'+id+'" name="userId[]" />';
				if(utype=="internal"){
				datas += '<input id="role'+id+'" type="hidden" value="user" name="userRole[]" />';
				}
				else{
					datas += '<input id="role'+id+'" type="hidden" value="user" name="userRole[]" />';
				}
				datas += '<input id="role'+id+'" type="hidden" value="'+utype+'" name="source[]" />';
				datas += '</div>';
				
				
				$('#invusr').append(datas);
				$('.userplaceholder').append(addInvitedUser(email,id,photo,utype));
				  
			}
			else{
				$('#email').next().html('Domain is restricted.<a title="close" aria-label="close" data-dismiss="alert" class="close closegreen" href="#">×</a>');
				$('#email').next().show();
				$('#email_value').focus(); return false;
			}
		};
		$scope.selectedProject = function (selected) {
			 $('#email').next().hide();
			 $('.successvalidation').hide();
			  
			 if(typeof selected =='object'){ 
				 $scope.emailSelected=selected.originalObject ;
			 
			 }else{
				 $scope.emailSelected='';
			 };
		}
	 
	});	
					
	app.controller("dataroomctrl", function($rootScope,$scope, $http) {
		$scope.remoteUrlRequestFn = function(str) {
			return {term: str};
		};
		$scope.emailSelected='';
		$scope.org = editOrganization;		 
		$scope.setImage = function(e) { 
			$scope.org.image=e;
		},	
	    $scope.inviteuser = function(e) {
		$scope.domain_restrict = $("#domain_restrict").val();	 
			 
			 
			 if($.trim($('#email_value').val())==''){
					   $('#email').next().html('Please enter valid email.<a title="close" aria-label="close" data-dismiss="alert" class="close closegreen" href="#">×</a>');					   					   
					  $('#email').next().show();
					  $('#email_value').focus(); 
					  $('.successvalidation').hide();
					  return false;
			 }
			 
			 
			 if($.trim($('#email_value').val()) == $.trim(currentUserEmail)){
						$('#email').next().html('You can not add yourself !!<a title="close" aria-label="close" data-dismiss="alert" class="close closegreen" href="#">×</a>');
						$('#email').next().show();
						$('#email_value').focus(); 
						$('.successvalidation').hide();
						return false;

					}
			 if($('.nameUserManage').length>0){
				 var flag=true;
				 $('.nameUserManage').each(function( index, value ) {

					 

					if($(this).attr('data-id')==$.trim($('#email_value').val()) && flag){
						  $('#email').next().html('This email was already added<a title="close" aria-label="close" data-dismiss="alert" class="close closegreen" href="#">×</a>');
						  $('#email').next().show();
						  $('#email_value').focus(); 
						  $('.successvalidation').hide();
						  flag=false;
					}
				});
				if(!flag) return false;
		    }
						
		     if(typeof $scope.emailSelected =='object'){
				 
				  $scope.addUser($scope.emailSelected.email,$scope.emailSelected.id,$scope.emailSelected.photo,"internal");
				   $scope.emailSelected={};
				   $('#email_value').val('');
				   if(!$scope.domain_restrict){
						$('.successvalidation').show();
				   }
				 
			 }else{
				 	 
				var pattern= /^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/;				
				if(!pattern.test($.trim($('#email_value').val())) && e!=1){
					  $('#email').next().html('Please enter valid email.<a title="close" aria-label="close" data-dismiss="alert" class="close closegreen" href="#">×</a>');
					  $('#email').next().show();
					  $('#email_value').focus(); return false;
				}
				if($('#internel_user').val()==0){
				var externalid = Math.floor(Math.random()*100000);
				 $scope.addUser($.trim($('#email_value').val()),externalid,'','external');
				 $('#email_value').val('');
				 if(!$scope.domain_restrict){
						$('.successvalidation').show();
				   }
				}
				else {
					 $('#email').next().html('Only Internal User allowed.<a title="close" aria-label="close" data-dismiss="alert" class="close closegreen" href="#">×</a>');
					  $('#email').next().show();
					  $('#email_value').focus(); return false;
				}
			}	
			 
		} ,
		
		$scope.addUser = function(email,id,photo,utype){
			var addUserFlag = restrictDomain(email, $scope.domain_restrict);
			if(addUserFlag){
				var datas = '<div class="usrControl" id="userid-'+id+'" ieuser="'+utype+'">';
				datas += '<input type="hidden" value="'+email+'" name="userEmail[]" />';
				datas += '<input type="hidden" value="'+id+'" name="userId[]" />';
				if(utype=="internal"){
				datas += '<input id="role'+id+'" type="hidden" value="user" name="userRole[]" />';
				}
				else{
					datas += '<input id="role'+id+'" type="hidden" value="user" name="userRole[]" />';
				}
				datas += '<input id="role'+id+'" type="hidden" value="'+utype+'" name="source[]" />';
				datas += '</div>';
				
				
				$('#invusr').append(datas);
				$('.userplaceholder').append(addInvitedUser(email,id,photo,utype));
				$('#email_value').val("");
				  
			}
			else{
				$('#email').next().html('Domain is restricted.<a title="close" aria-label="close" data-dismiss="alert" class="close closegreen" href="#">X</a>');
				$('#email').next().show();
				$('#email_value').focus(); return false;
			}
		},
				
		$scope.selectedProject = function (selected) {
			 $('#email').next().hide();
			 $('.successvalidation').hide();
			  
			 if(typeof selected =='object'){ 
				 $scope.emailSelected=selected.originalObject ;
			 
			 }else{
				 $scope.emailSelected='';
			 };
		},
		
		$scope.saveOrganization =function(frmOrg) { 
			 $scope.org.users={};
		   if(frmOrg.$valid){
			   if($('.mangeuserSelect').length>0){
				   var ctr='';
				   var ctr1='0';
					$('.mangeuserSelect').each(function( index, value ) {
				   
						var val=$(this).val();
						var email=$(this).attr('data-id');
						ctr={emailid:email,roles:val};
						$scope.org.users[ctr1++]=ctr;
						 
					});

			   }
			   flagsite=true;
			   $scope.org.urls={};
			   if($('.siteurl').length>0){
				    
				   var ctr1='0';
					$('.siteurl').each(function( index, value ) {
				   
						var val=$.trim($(this).val());
						if(val!=''){
							if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(val)==false) {
					 
								 flagsite=false;
								 return false;
					 
							}
						}
						$scope.org.urls[ctr1++]=val
						 
					});

			   }	
			   if(!flagsite){
				   sweetAlert("Oops...","Invalid Url!", "error"); return false;
			   }
			   
			   $scope.orgData= angular.copy($scope.org);
			   
			   
			   $('.maincontiner').css('opacity',"0.5");
			   $('.loader').show();
			   $('.maincontiner').css('pointer-events',"none");
			   var data =  $scope.orgData;	
			   var url=	($scope.orgData.isedit==1)? 'update' : 'AddedOrganization';
			    
			    $http.post(URL + '/organization/' + url, data).success(function(data, status) {
				   
					if(data.error==1){
						
					  sweetAlert("Oops...",data.msg, "error");	
					  $('.maincontiner').css('opacity',"1");
						$('.loader').hide();
						$('.maincontiner').css('pointer-events',"all");
					  
					}else if(data.error==3){ 
						$.toaster({ priority : 'success', title : "Success", message : "Organization has been successfully saved" , timeout:5000});
						setTimeout(function()
								{
									window.location.href=URL +"/organization/list" 
								}, 3000);
					}else if(data.error==2){ 
						$.toaster({ priority : 'success', title : "Success", message : "Organization has been successfully saved" });
						if(data.invlist.length>0){
							
							$.each(data.invlist, function(i,objn) {
								$.toaster({ priority : 'success', title : objn, message : "User has been successfully invited"});
								
							});	
						}
						if(data.errorlist.length>0){
							$.each(data.errorlist, function(i,objn) {
								
								$.toaster({ priority : 'danger', title : objn, message : "User was not invited. Please add again" });
								
							});	
						}
						
						setTimeout(function()
								{
									window.location.href=URL +"/organization/list" 
								}, 3000);
						
					}else{
						
						$.toaster({ priority : 'danger', title : 'Error', message : "Something gone wrong. Please try again" , timeout:5000});	
						setTimeout(function()
								{
									window.location.href=URL +"/organization/list" 
								}, 3000);
						
					}
			    });		
		   }else{
			   
			   angular.element("[name='" + frmOrg.$name + 
			   "']").find('.ng-invalid:visible:first').focus();
			   return false;
		   }
		}
		
	} );
function fieldChange(value,id){
		$('#role'+id+'').val(value);
	}
	$(document).on('click','.closegreen',function(){
			$(this).parent().css("display", "none");
		});	
   
function restrictDomain(email, domain_restrict) {
     var domainsplit;
	 var emailsplit = email.split("@");
	 if(domain_restrict){
		domainsplit = domain_restrict.split("@"); 
	 }
     
	 if (domain_restrict) {
         if (emailsplit[1]===(domainsplit[1])) {
			 return addUserFlag = true;
         } else {
             return addUserFlag = false;
         }
     } else {
         return addUserFlag = true;
     }
 }