var inspinia = angular.module('inspinia');

inspinia.controller("insertBulkDataCtrl", ['$scope','$rootScope','$http','$q','API','$state','$timeout','crmconfig', function ($scope,$rootScope,$http,$q,API,$state,$timeout,crmconfig) {
	
	var userId = $rootScope.userId || localStorage.getItem("userId");
	$scope.IsVisible = false;
	$scope.LinkVisible = false;

	$scope.read = function (workbook) {
		$scope.IsVisible = true;

		var headerNames = XLSX.utils.sheet_to_json( workbook.Sheets[workbook.SheetNames[0]], { header: 1 })[0];
		var data = XLSX.utils.sheet_to_json( workbook.Sheets[workbook.SheetNames[0]]);

		// console.log(headerNames);
		// console.log(data);
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
	}

	$scope.trDetails = function() {
		console.log("tid",$tId);
		$state.go('dashboards.transactionDetails', {tId: $tId});
		// $stateProvider.state('dashboards.transactionDetails', {
		//     url: '/dashboards/transactionDetails',
		//     controller: 'transactionDetailsCtrl',
		//     params: {
		//         tId: $tId
		//     }
		// })
	}

}])
