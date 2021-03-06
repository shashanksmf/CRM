var inspinia = angular.module('inspinia');
inspinia.controller("companiesCtrl", ['$scope', '$rootScope', '$http', '$q',
	'API', '$state', '$timeout', 'crmconfig',
	function($scope, $rootScope, $http, $q, API, $state, $timeout, crmconfig) {

		$scope.crmconfig = {
			"serverDomainName": crmconfig.serverDomainName
		};
		//var baseHttpUrl = '/angularphp/template/Angular_Full_Version/Service';
		//var baseHttpUrl = 'http://jaiswaldevelopers.com/CRMV1/Service';
		var baseHttpUrl = crmconfig.serverDomainName + '/Service';

		API.getAllCompanies().then(function(response) {
			if (response.data.result) {
				$scope.companies = response.data.Users;
			}
		})



		// $scope.showautocomplete = false;

		// code for sorting on columnNames
		$scope.sortBy = function(propertyName) {
			console.log("hey", propertyName);
			$scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse :
				false;
			$scope.propertyName = propertyName;
		};


		$scope.deleteCompany = function(companyId) {
			if (!companyId || companyId.length == 0) {
				// alert("Company has not been assigned any Id");
				$rootScope.config.rootModalShow = true;
				$rootScope.config.rootModalHeader = "Failed";
				$rootScope.config.responseText = "Company has not been assigned any Id";
				$rootScope.config.rootModalAction = function() {
					$rootScope.config.rootModalShow = false;
				};
				return;
			}

			API.deleteCompany({
				id: companyId
			}).then(function(response) {
				if (response.data.hasOwnProperty("result") && response.data.result) {
					for (var i = 0; i < $scope.companies.length; i++) {
						if (companyId == $scope.companies[i].id) {
							$scope.companies.splice(i, 1);
							// alert("Company Deleted Successfully");
							$rootScope.config.rootModalShow = true;
							$rootScope.config.rootModalHeader = "Success";
							$rootScope.config.responseText =
								"Company Deleted Successfully";
							$rootScope.config.rootModalAction = function() {
								$rootScope.config.rootModalShow = false;
							};

						}
					}
				} else if (response.data.hasOwnProperty("reason")) {
					// alert(response.data.details);
					$rootScope.config.rootModalShow = true;
					$rootScope.config.rootModalHeader = "Failed";
					$rootScope.config.responseText = response.data.reason;
					$rootScope.config.rootModalAction = function() {
						$rootScope.config.rootModalShow = false;
					};

				} else {
					// alert("Something Wrong with the server");
					$rootScope.config.rootModalShow = true;
					$rootScope.config.rootModalHeader = "Failed";
					$rootScope.config.responseText =
						"Something Wrong with the server";
					$rootScope.config.rootModalAction = function() {
						$rootScope.config.rootModalShow = false;
					};
				}
			})
		}

		//code when user clicks on any Company then modal comes up and show CompanyDetail
		$scope.showCompanyDetail = function(companyId) {

			$state.go('dashboards.companyProfile', {
				id: companyId
			});
			return;

			$scope.config.showUserPopUp = false;
			var companyId = companyId || 1;

			$http({
					method: 'GET',
					dataType: "jsonp",
					url: baseHttpUrl + '/GetCompanyData.php?id=' + companyId
				})
				.then(function successCallback(response) {
					$scope.companyDetails = response.data.Users[0];
				}, function errorCallback(response) {
					// called asynchronously if an error occurs
					// or server returns response with an error status.
				});

			// $scope.config.showCompanyDetailPopUp = true;

		}

	}
])
