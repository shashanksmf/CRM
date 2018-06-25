var inspinia = angular.module('inspinia');
inspinia.controller('emplInsertProfileCtrl', ['$scope', '$rootScope', '$http',
	'$q', 'API', '$state', '$timeout', '$stateParams',
	function($scope, $rootScope, $http, $q, API, $state, $timeout, $stateParams) {

		var baseHttpUrl = 'http://jaiswaldevelopers.com/CRMV1/Service',
			domainName = 'http://jaiswaldevelopers.com/CRMV1/';
		$scope.imgsrc = 'img/default-avatar.png';
		$scope.hidespinner = true;
		//$("#emplLoadingModal").modal('show');
		API.getAllComapnies().then(function(response) {
			if (response.data.result) {
				$scope.companies = response.data.reason;
			}
		})
		$scope.emplProfileInfo = {};
		$scope.emplProfile = new FormData();


		$scope.browseEmplProfilePicAttach = function() {
			document.getElementsByClassName("emplInsertProfilePic")[0].value = '';
			document.getElementsByClassName("emplInsertProfilePic")[0].click();
		}

		$scope.attachEmplProfilePic = function(event) {

			var files = event.target.files;
			$scope.emplProfile.append("image", files[0]);
			var reader = new FileReader();
			reader.onload = $scope.imageIsLoaded;
			reader.readAsDataURL(files[0]);

		}

		$scope.saveEmpl = function() {
			$scope.errorMsg = "";
			isValid = checkEmplFields($scope.emplProfileInfo);
			if (isValid) {
				$("#emplLoadingModal").modal('show');
				try {
					$scope.companies.forEach(function(company) {
						if (company.id == $scope.emplProfileInfo.companyId) {
							$scope.userProfileInfo.companyName = company.name;
						}
					})
				} catch (ex) {
					console.log(ex);
				}
				$scope.emplProfile.append("data", JSON.stringify($scope.emplProfileInfo));

				API.insertEmplProfile($scope.emplProfile).then(function(response) {
					if (response.data.result) {
						//alert("data uploaded");
						$scope.imgsrc = 'img/default-avatar.png';
						$scope.errorMsg = "data uploaded";
						$scope.hasError = false;
						$scope.emplProfileInfo = {};
					} else {
						$scope.hasError = true;
						$timeout(function() {
								$scope.errorMsg = response.data.reason;
							}, 100)
							//alert(response.data.details);
					}
					$scope.hidespinner = true;
				})

			}
		}

		$scope.imageIsLoaded = function(e) {
			$scope.$apply(function() {
				$scope.imgsrc = e.target.result;
			});
		}

		function checkEmplFields(info) {
			//var info = $scope.emplProfileInfo;

			if (!info.name || !info.email || !info.gender) {
				if (!info.name) {
					// alert("please enter Your Name ");
					$rootScope.config.rootModalShow = true;
					$rootScope.config.rootModalHeader = "Failed";
					$rootScope.config.responseText =
						"please enter Your Name ";
					$rootScope.config.rootModalAction = function() {
						$rootScope.config.rootModalShow = false;
					};
					return false;
				} else if (!info.email) {
					// alert("please enter email address");
					$rootScope.config.rootModalShow = true;
					$rootScope.config.rootModalHeader = "Failed";
					$rootScope.config.responseText =
						"please enter email address ";
					$rootScope.config.rootModalAction = function() {
						$rootScope.config.rootModalShow = false;
					};
					return false;
				} else if (!info.gender) {
					// alert('please select gender');
					$rootScope.config.rootModalShow = true;
					$rootScope.config.rootModalHeader = "Failed";
					$rootScope.config.responseText =
						"please select gender ";
					$rootScope.config.rootModalAction = function() {
						$rootScope.config.rootModalShow = false;
					};
					return false;
				}
				// else if(!info.company) {
				// 	alert('please select company');
				// 	return false
				// }
			} else if (!validateEmail(info.email)) {
				// alert('Please enter valid email Id');
				$rootScope.config.rootModalShow = true;
				$rootScope.config.rootModalHeader = "Failed";
				$rootScope.config.responseText =
					"please enter valid email address ";
				$rootScope.config.rootModalAction = function() {
					$rootScope.config.rootModalShow = false;
				};
			} else {
				return true;
			}

		}

		function validateEmail(email) {
			var re =
				/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}

	}
]);
