var inspinia = angular.module('inspinia');
inspinia.controller('companyProfileCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout','$stateParams', function ($scope,$rootScope,$http,$q,API,$state,$timeout,$stateParams) {
	
    $scope.tabs = { summary:"summary" , attachment : "attachment" };
	$scope.activeTab = $scope.tabs.summary;
	$scope.profileEdit = false;
    
    var companyId = $stateParams.id;
     
    API.getCompanyDetails(companyId).then(function(response){
        $scope.companyData = response.data.Users[0];
        $scope.companyData.id = companyId;
    })
    
    
    $scope.changeProfileEdit = function(){
        $scope.profileEdit = true;
    }
    
    $scope.saveProfile = function(){
        //console.log("saveProfile clicked ",companyId);
        if(companyId){
            API.updateCompanyDetails($scope.companyData).then(function(response){
                //console.log("response API", response.data.responce);
                if(response.data.responce){
                    alert("company data saved successfully");
                     $scope.profileEdit = false;
                }
                else{
                    alert("server is down");
                }
            })
        }
        
    }
    
}]);