var inspinia = angular.module('inspinia');

inspinia.controller("insertBulkDataCtrl", ['$scope', '$rootScope', '$http',
	'$q', 'API', '$state', '$stateParams', '$timeout', 'crmconfig',
	function($scope, $rootScope, $http, $q, API, $state, $stateParams, $timeout,
		crmconfig) {

		var userId = $rootScope.userId || localStorage.getItem("userId");
		$scope.IsVisible = false;
		$scope.LinkVisible = false;
		$scope.read = function(workbook) {
			$scope.LinkVisible = false;

			var headerNames = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[
				0]], {
				header: 1
			})[0];
			var data = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]]);

			console.log(headerNames);
			var tempArr = ["E-mail address"];

			for (var i = headerNames.length - 1; i >= 0; i--) {
				for (var j = 0; j < tempArr.length; j++) {
					if (headerNames[i] == tempArr[j]) {
						tempArr.splice(j, 1);
						break;
					}
				};
			};
			if (tempArr.length > 0) {
				console.log(tempArr.join(', '));
				var err = tempArr.join(', ') +
					" this column are missing in your excel file";
				// alert(err);
				$rootScope.config.rootModalShow = true;
				$rootScope.config.rootModalHeader = "Failed";
				$rootScope.config.responseText = err;
				$rootScope.config.rootModalAction = function() {
					$rootScope.config.rootModalShow = false;
				};
			} else {

				$timeout(function() {
					$scope.IsVisible = true;
				}, 100)

				// $.ajax({
				// 	type: "POST",
				// 	url: 'http://localhost/CRM_19/trunk/Service/insertBulkData.php',
				// 	data: {
				// 		userId, data
				// 	},
				// 	headers: {
				// 		token: localStorage.getItem("token")
				// 	},
				// 	success: (function(response) {
				// 		console.log("insertBulkData", response);
				// 		$scope.tId = response.tId;
				// 		if (response.result) {
				// 			// alert("Records inserted successfully!");
				// 			$rootScope.config.rootModalShow = true;
				// 			$rootScope.config.rootModalHeader = "Success";
				// 			$rootScope.config.responseText =
				// 				"Records inserted successfully";
				// 			$timeout(function() {
				// 				$scope.IsVisible = false;
				// 				$scope.LinkVisible = true;
				// 			}, 100)
				// 		}
				// 	})
				// });
				// return;
				API.insertBulkData(userId, data).then(function(response) {
					console.log("insertBulkData", response);
					console.log("userId", userId);
					$scope.tId = response.data.tId;
					if (response.data.result) {
						$rootScope.config.rootModalShow = true;
						$rootScope.config.rootModalHeader = "Success";
						$rootScope.config.responseText =
							"Records inserted successfully!";
						$rootScope.config.rootModalAction = function() {
							$rootScope.config.rootModalShow = false;
						};
						$scope.IsVisible = false;
						$scope.LinkVisible = true;
					}

				});
			}

			// console.log(data);
			// for (var row in data)
			// 	{
			// console.log(data[row]);
			// Object.keys(data[row]).forEach(function(key) {
			// console.log("Key = >" + key);
			// console.log("Value => " + data[row][key]);
			// console.log("===========================");
			// });
			// }
		}

		$scope.error = function(e) {
			// console.log(e);
			// alert("Unsupported file please choose excel file");
			$rootScope.config.rootModalShow = true;
			$rootScope.config.rootModalHeader = "Failed";
			$rootScope.config.responseText =
				"Unsupported file, please choose excel file";
			$rootScope.config.rootModalAction = function() {
				$rootScope.config.rootModalShow = false;
			};
		}

		$scope.trDetails = function() {
			$state.go('dashboards.transactionDetails', {
				tId: $scope.tId
			});
		}

	}
])
