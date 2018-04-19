var inspinia = angular.module('inspinia');
inspinia.controller("transactionDetailsCtrl", ['$scope','$rootScope','$http','$q','API','$state','$timeout', function ($scope,$rootScope,$http,$q,API,$state,$timeout) {
	// console.log($state.params.tId);
	// $tId = $state.params.tId;
	
	API.getTransactionDetails(tId).then(function(response){
		if(response.data.result){
			$scope.transactionDetails = response.data;
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
		console.log("hey",propertyName);  
        $scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
        $scope.propertyName = propertyName;
    };

}])
