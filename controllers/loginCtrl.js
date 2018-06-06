var inspinia = angular.module('inspinia');
inspinia.controller('loginCtrl', ['$scope', '$rootScope', '$location', '$http',
	'$q', 'API', '$state', '$timeout', 'crmconfig',
	function($scope, $rootScope, $location,$locationProvider, $http, $q, API, $state, $timeout,
		crmconfig) {
		//data from url
		$locationProvider.html5Mode(true);
		var userUrlData = $location.search();
		console.log("userUrlData", userUrlData);
		if (userUrlData.login) {
			localStorage.clear();
			$rootScope.userEmail = userUrlData.email;
			$rootScope.userName = userUrlData.name;
			$rootScope.userId = userUrlData.id;
			$rootScope.token = userUrlData.token;
			$rootScope.userProfilePic = crmconfig.serverDomainName + "/" + userUrlData
				.profilePic;
			localStorage.setItem("userEmail", userUrlData.email);
			localStorage.setItem("userName", userUrlData.name);
			localStorage.setItem("userId", userUrlData.id);
			localStorage.setItem("token", userUrlData.token);
			//localStorage.setItem("userUUID",userUrlData.responce);
			$state.go("dashboards.home");
		}


		//console.log("crmConfig ",crmconfig);
		$scope.loginUser = function() {
			var user = {
				userName: $scope.userEmail,
				userPassword: $scope.userPassword
			};

			API.loginUser(user).then(function(response) {
				//console.log("registerUser",response);
				if (response.data.responce) {
					localStorage.clear();
					$rootScope.userEmail = response.data.email;
					$rootScope.userName = response.data.name;
					$rootScope.userId = response.data.id;
					$rootScope.token = response.data.token;
					localStorage.setItem("userEmail", response.data.email);
					localStorage.setItem("userName", response.data.name);
					localStorage.setItem("userId", response.data.id);
					localStorage.setItem("token", response.data.token);
					//localStorage.setItem("userUUID",response.data.responce);
					$rootScope.userProfilePic = crmconfig.serverDomainName + "/" +
						response.data.profilePic;
					$scope.$emit('initialiseChat', {
						initChat: true
					});


					API.setAuth(response.data);
					$state.go("dashboards.home");


				} else {
					$scope.error = response.data;
					$timeout(function() {
						$scope.error.responce = true;
					}, 10000)
				}
			})


		}


		$scope.googleLogIn = function() {
			window.location =
				'https://upsailgroup.herokuapp.com/Service/googleLogIn.php';
			// API.googleLogIn().then(function(response){
			// 	console.log(response);
			// 	if (response.data.result) {
			// 		window.location = response.data.url;
			// 	}
			// 	else if(response.data.token){
			//           localStorage.clear();
			// 		$rootScope.userEmail = response.data.userEmail;
			// 		$rootScope.userName = response.data.userName;
			// 		$rootScope.userId = response.data.userId;
			// 		$rootScope.token = response.data.token;
			// 		localStorage.setItem("userEmail",response.data.userEmail);
			// 		localStorage.setItem("userName",response.data.userName);
			// 		localStorage.setItem("userId",response.data.userId);
			// 		localStorage.setItem("token",response.data.token);
			// 		//localStorage.setItem("userUUID",response.data.responce);
			// 		$rootScope.userProfilePic = crmconfig.serverDomainName +"/"+ response.data.profilePic;
			// 		$scope.$emit('initialiseChat', { initChat : true });
			//
			//
			// 		// API.setAuth(response.data);
			// 		$state.go("dashboards.home");
			// 		// window.location = response.data.url;
			// 	}
			// 	else{
			// 		$scope.error = response.data;
			// 		$timeout(function(){
			// 			$scope.error.responce = true;
			// 		},10000)
			// 	}
			// });
		}

		$scope.facebookLogIn = function() {
			window.location =
				'https://upsailgroup.herokuapp.com/Service/facebookLogIn.php';
			// API.facebookLogIn().then(function(response){
			// 	console.log(response);
			// 	if (response.data.result) {
			// 		window.location = response.data.url;
			// 	}
			// 	else if(response.data.token){
			//           localStorage.clear();
			// 		$rootScope.userEmail = response.data.userEmail;
			// 		$rootScope.userName = response.data.userName;
			// 		$rootScope.userId = response.data.userId;
			// 		$rootScope.token = response.data.token;
			// 		localStorage.setItem("userEmail",response.data.userEmail);
			// 		localStorage.setItem("userName",response.data.userName);
			// 		localStorage.setItem("userId",response.data.userId);
			// 		localStorage.setItem("token",response.data.token);
			// 		//localStorage.setItem("userUUID",response.data.responce);
			// 		$rootScope.userProfilePic = crmconfig.serverDomainName +"/"+ response.data.profilePic;
			// 		$scope.$emit('initialiseChat', { initChat : true });
			//
			//
			// 		// API.setAuth(response.data);
			// 		$state.go("dashboards.home");
			// 		// window.location = response.data.url;
			// 	}
			// 	else{
			// 		$scope.error = response.data;
			// 		$timeout(function(){
			// 			$scope.error.responce = true;
			// 		},10000)
			// 	}
			// });
		}


	}
])
