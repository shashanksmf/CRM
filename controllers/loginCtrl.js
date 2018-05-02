var inspinia = angular.module('inspinia');
inspinia.controller('loginCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout','crmconfig', function ($scope,$rootScope,$http,$q,API,$state,$timeout,crmconfig) {

	//console.log("crmConfig ",crmconfig);	
	$scope.loginUser = function(){
		var user = { userName: $scope.userEmail ,  userPassword : $scope.userPassword };
		
		API.loginUser(user).then(function(response){
			//console.log("registerUser",response);
			if(response.data.responce){
				localStorage.clear();
				$rootScope.userEmail = response.data.email;
				$rootScope.userName = response.data.name;
				$rootScope.userId = response.data.id;
				$rootScope.token = response.data.token;
				localStorage.setItem("userEmail",response.data.email);
				localStorage.setItem("userName",response.data.name);
				localStorage.setItem("userId",response.data.id);
				localStorage.setItem("token",response.data.token);
				//localStorage.setItem("userUUID",response.data.responce);
				$rootScope.userProfilePic = crmconfig.serverDomainName +"/"+ response.data.profilePic;
				$scope.$emit('initialiseChat', { initChat : true });
				

				API.setAuth(response.data);
				$state.go("dashboards.home");

		
			}
			else{
				$scope.error = response.data;
				$timeout(function(){
					$scope.error.responce = true;
				},10000)
			}
		})
		

	}


	$scope.googleLogIn = function(){
		API.googleLogIn().then(function(response){
			console.log(response);
			// if(response.data.responce){
			// 	localStorage.clear();
			// 	$rootScope.userEmail = response.data.email;
			// 	$rootScope.userName = response.data.name;
			// 	$rootScope.userId = response.data.id;
			// 	$rootScope.token = response.data.token;
			// 	localStorage.setItem("userEmail",response.data.email);
			// 	localStorage.setItem("userName",response.data.name);
			// 	localStorage.setItem("userId",response.data.id);
			// 	localStorage.setItem("token",response.data.token);
			// 	//localStorage.setItem("userUUID",response.data.responce);
			// 	$rootScope.userProfilePic = crmconfig.serverDomainName +"/"+ response.data.profilePic;
			// 	$scope.$emit('initialiseChat', { initChat : true });
				

			// 	API.setAuth(response.data);
			// 	$state.go("dashboards.home");

		
			// }
			// else{
			// 	$scope.error = response.data;
			// 	$timeout(function(){
			// 		$scope.error.responce = true;
			// 	},10000)
			// }
		});
	}

	$scope.facebookLogIn = function(){
		API.facebookLogIn().then(function(response){
			console.log(response);
		});
	}


}])