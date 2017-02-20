var inspinia = angular.module('inspinia');
inspinia.controller('loginCtrl', ['$scope','$http','$q','API','$state','$timeout', function ($scope,$http,$q,API,$state,$timeout) {
	
	$scope.loginUser = function(){
		var user = { userName: $scope.userEmail ,  userPassword : $scope.userPassword };
		
		API.loginUser(user).then(function(response){
			console.log("registerUser",response);
			if(response.data.responce){
				localStorage.setItem("userEmail",response.data.email);
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