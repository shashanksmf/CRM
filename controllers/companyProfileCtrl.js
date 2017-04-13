var inspinia = angular.module('inspinia');
inspinia.controller('companyProfileCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout','$stateParams', function ($scope,$rootScope,$http,$q,API,$state,$timeout,$stateParams) {
	
    $scope.tabs = { summary:"summary" , attachment : "attachment" };
	$scope.activeTab = $scope.tabs.summary;
	$scope.profileEdit = false;
    
    var companyId = $stateParams.id;
     
    $scope.newUploadPic = false;

    API.getCompanyDetails(companyId).then(function(response){
        $scope.companyData = response.data.Users[0];
        $scope.companyData.id = companyId;
    })


      
    $scope.fileSelected = function (files) {

        var file = new FormData();
        file.append("image", files[0]);
     //   file.append("fileName",files[0].name);
        file.append("id", companyId);
        
        var reader = new FileReader();
        reader.onload = $scope.imageIsLoaded; 
        reader.readAsDataURL(files[0]);

        API.companyProfilePic(file).then(function(response) {
            console.log(response.data.responce);
            if(response.data.responce){
                alert("Picture successFully Uploaded")
                return;    
            }

            alert("server is down");
            
        })
    };


    $scope.imageIsLoaded = function(e){
            $scope.newUploadPic = true;
            $scope.$apply(function() {  
                $scope.imgsrc= e.target.result;
            });
    }

    
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