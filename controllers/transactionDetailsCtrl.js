var inspinia = angular.module('inspinia');
inspinia.controller("transactionDetailsCtrl", ['$scope','$rootScope','$http','$q','API','$state','$stateParams','$timeout', function ($scope,$rootScope,$http,$q,API,$state,$stateParams,$timeout) {
	// console.log("$stateParams",$stateParams);
	tId = $stateParams.tId;
	API.getTransactionDetails(tId).then(function(response){
		console.log(response);
		if(response.data.result){
			$scope.transactionDetails = response.data.details;
		}
		else if(response.data.errorType && response.data.errorType == "token"){
			$('#tokenErrorModalLabel').html(response.data.details);
			$('#tokenErrorModal').modal("show");
			$('#tokenErrorModalBtn').click(function(){
				$('#tokenErrorModal').modal("hide");
			})
		}    
	})

	// code for sorting on columnNames
    $scope.sortBy = function(propertyName) {
		$scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
        $scope.propertyName = propertyName;
    };

}])
