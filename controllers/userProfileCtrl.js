var inspinia = angular.module('inspinia');
inspinia.controller('userProfileCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout', function ($scope,$rootScope,$http,$q,API,$state,$timeout) {
	$scope.tabs = { summary:"summary" , attachment : "attachment" };
	$scope.activeTab = $scope.tabs.summary;
	$scope.profileEdit = false;
	$scope.userProfileInfo = {};
	$scope.changeProfileEdit = function (){
		
		console.log("$scope.userProfileInfo",$scope.userProfileInfo)
		$scope.profileEdit = !$scope.profileEdit;
	}
	
	$scope.uploadFile = function(files) {
		console.log("files",files)
		var reader = new FileReader();
		reader.onload = $scope.imageIsLoaded; 
		 reader.readAsDataURL(files[0]);

		 var file = new FormData();
		  file.append("file", files[0]);
		  console.log("fd",file);
		  var url =  'Controller' + '/fileUpload.php';
		  // $http.post(url, file,  
    //        {  	
    //        		data: {name:"shashank"},
    //             transformRequest: angular.identity,  
    //             headers: {'Content-Type': undefined,'Process-Data': false}  
    //        }).success(function(response){  
    //             alert(response); 
    //        });  
	};


	$scope.imageIsLoaded = function(e){
            $scope.$apply(function() {
        $scope.imgsrc= e.target.result;
        console.log("$scope.imgsrc",$scope.imgsrc)
        });
}

}]);	