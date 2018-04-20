var inspinia = angular.module('inspinia');

inspinia.controller("insertBulkDataCtrl", ['$scope','$rootScope','$http','$q','API','$state','$stateParams','$timeout','crmconfig', function ($scope,$rootScope,$http,$q,API,$state,$stateParams,$timeout,crmconfig) {
	
	var userId = $rootScope.userId || localStorage.getItem("userId");
	$scope.IsVisible = false;
	$scope.LinkVisible = false;

	$scope.read = function (workbook) {
		$scope.LinkVisible = false;

		var headerNames = XLSX.utils.sheet_to_json( workbook.Sheets[workbook.SheetNames[0]], { header: 1 })[0];
		var data = XLSX.utils.sheet_to_json( workbook.Sheets[workbook.SheetNames[0]]);

		console.log(headerNames);
		// console.log(data);
		if(headerNames.indexOf("Firstname" && "Surname" && "E-mail address" && "Company" 
			&& "Job Role" && "Office Address" && "Company Website" 
			&& "Industry" && "Country") !== -1){
			console.log("true");
			$scope.IsVisible = true;
			API.insertBulkData(userId,data).then(function(response){
				console.log("insertBulkData",response);
				$tId = response.data.tId;
				if(response.data.result) {
		            alert("Records inserted");
		            $scope.IsVisible = false;
		            $scope.LinkVisible = true;
		        }
		        else if(response.data.errorType && response.data.errorType == "token"){
	                $('#tokenErrorModalLabel').html(response.data.details);
	                $('#tokenErrorModal').modal("show");
	                $('#tokenErrorModalBtn').click(function(){
	                    $('#tokenErrorModal').modal("hide");
	            	})
	         	}
				
			});
		}
		else {
			$scope.LinkVisible = false;
			console.log("false");
			alert("Please add data in file in following column format: Firstname, Surname, E-mail address, Company, Job Role, Office Address, Company Website, Industry, Country.");
		}
		
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

	$scope.error = function (e) {
		console.log(e);
		alert("Unsupported file please choose excel file");
	}

	$scope.trDetails = function() {
		$state.go('dashboards.transactionDetails', {tId: $tId});
	}

}])
