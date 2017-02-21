var inspinia = angular.module('inspinia');
inspinia.controller('loginCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout', function ($scope,$rootScope,$http,$q,API,$state,$timeout) {
	
	$scope.loginUser = function(){
		var user = { userName: $scope.userEmail ,  userPassword : $scope.userPassword };
		
		API.loginUser(user).then(function(response){
			console.log("registerUser",response);
			if(response.data.responce){
				$rootScope.userEmail = response.data.email;
				$rootScope.userName = response.data.name;
				
				localStorage.setItem("userEmail",response.data.email);
				localStorage.setItem("userName",response.data.name);
				
				//localStorage.setItem("userUUID",response.data.responce);
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


}])