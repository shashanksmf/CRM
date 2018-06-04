const XLSX = require('jsxls');
const $ = require('$');
const $err = require('$err');
const $tId = require('$tId');
const angular = require('angular');

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
				$err = tempArr.join(', ') +
					" this column are missing in your excel file";
				alert($err);
			} else {
				$scope.IsVisible = true;
				API.insertBulkData(userId, data).then(function(response) {
					console.log("insertBulkData", response);
					$tId = response.data.tId;
					if (response.data.result) {
						alert("Records inserted successfully!");
						$scope.IsVisible = false;
						$scope.LinkVisible = true;
					} else if (response.data.errorType && response.data.errorType ==
						"token") {
						$('#tokenErrorModalLabel').html(response.data.details);
						$('#tokenErrorModal').modal("show");
						$('#tokenErrorModalBtn').click(function() {
							$('#tokenErrorModal').modal("hide");
						})
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
			console.log(e);
			alert("Unsupported file please choose excel file");
		}

		$scope.trDetails = function() {
			$state.go('dashboards.transactionDetails', {
				tId: $tId
			});
		}

	}
])
