var inspinia = angular.module('inspinia');
inspinia.controller('userProfileCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout', function ($scope,$rootScope,$http,$q,API,$state,$timeout) {
	$scope.tabs = { summary:"summary" , attachment : "attachment" };
	$scope.activeTab = $scope.tabs.summary;
	$scope.profileEdit = false;
	$scope.userProfileInfo = {};
	$scope.formData = {};

	$scope.changeProfileEdit = function (){
		
		console.log("$scope.userProfileInfo",$scope.userProfileInfo)
		$scope.profileEdit = !$scope.profileEdit;
	}
	
	$scope.submit = function() {

    API.updateUserProfile($scope.userProfileInfo).then(function(response){
    	if(response.data.responce){
    		alert("profileUpdated");
    		$scope.profileEdit = !$scope.profileEdit;
    	}
    	else{
    		alert("Network Problem");	
    	}
    	
    })

   
	};


	$scope.imageIsLoaded = function(e){
        $scope.$apply(function() {
	        $scope.imgsrc= e.target.result;
	    });
    }
    
    var userObj = { userId : $rootScope.userId || localStorage.getItem("userId")  };
    API.getUserProfile(userObj).then(function(response){
        $scope.userProfileInfo = response.data.Employees[0];
    })

    $scope.fileSelected = function (files) {
  //  var myFileSelected = element.files[0];

		var file = new FormData();
		file.append("image", files[0]);
		file.append("fileName",files[0].name);
		file.append("userId",$rootScope.userId || localStorage.getItem("userId"));
		
		var reader = new FileReader();
		reader.onload = $scope.imageIsLoaded; 
		reader.readAsDataURL(files[0]);

	    var url = "http://jaiswaldevelopers.com/CRMV1/files/index.php";
	    $http.post(url, file,  
	    {   
	    	
	    	 withCredentials: false,
	        transformRequest: angular.identity,  
	        headers: {'Content-Type': undefined}  
	    }).success(function(response){  
        alert("Image Uploaded successFully"); 
       }); 
  };

	$scope.browseFileAttach = function(){
		document.getElementsByClassName("fileAttachmentInput")[0].click();
	}


	$scope.fileAttach = function(files){
		$timeout(function() {
			$scope.files.push({"id":$scope.files.length+1,"name":files[0].name,"date":new Date()})
		}, 1000);
		
	}


	$scope.files = [
		{
			"id":"1",
			"name":"x-man pdf",
			"date":"02/05/2012",
			"checked":false
		},
		{
			"id":"2",
			"name":"The Economic Policy pdf",
			"date":"02/05/2012",
			"checked":false
		},
		{
			"id":"3",
			"name":"tail Head Png",
			"date":"02/05/2012",
			"checked":false
		}
	]


}]);	



// inspinia.directive('myDirective', function (httpPostFactory) {
//     return {
//         restrict: 'A',
//         scope: true,
//         link: function (scope, element, attr) {

//             element.bind('change', function () {
//                 var formData = new FormData();
//                 formData.append('file', element[0].files[0]);
//                 httpPostFactory('upload_image.php', formData, function (callback) {
//                    // recieve image name to use in a ng-src 
//                     console.log(callback);
//                 });
//             });

//         }
//     };
// });