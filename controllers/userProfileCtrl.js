var inspinia = angular.module('inspinia');
inspinia.controller('userProfileCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout','$stateParams', function ($scope,$rootScope,$http,$q,API,$state,$timeout,$stateParams) {

	$scope.tabs = { summary:"summary" , attachment : "attachment" };
	$scope.activeTab = $scope.tabs.summary;
	$scope.profileEdit = false;
	$scope.userProfileInfo = {};
	$scope.formData = {};

	//console.log("$stateParams",$stateParams)
	$scope.userId = $stateParams.id;
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


	
    
    var userObj = { userId : $scope.userId };
    API.getUserProfile(userObj).then(function(response){
        $scope.userProfileInfo = response.data.Employees[0];
    })


	$scope.browseFileAttach = function() {

		document.getElementsByClassName("fileAttachmentInput")[0].click();
	}


	$scope.fileAttach = function(files){

		$scope.fileAttach = new FormData();
		$scope.fileAttach.append("image", files[0]);
		$scope.fileAttach.append("id", $scope.userId);
		
		$("#fileNameModal").modal("show");


	}


	$scope.uploadNewFileAttach = function (fileName) {

		if(!fileName || fileName.length < 0 ){
			alert("Please Enter FileName");
			return false;
		}

		$scope.fileAttach.append("fileName",fileName);
		
	    API.uploadFileAttach($scope.fileAttach).then(function(response) {
	    	
	    	//alert("file successFully Uploaded")
	    	 if(response.data.responce) {
	    		alert("file successFully Uploaded")
	    	 }
	    	 else {
	    	 	alert("something Went Wrong");
	    	 }

	    	$timeout(function() {
				$scope.files.push({checked:false,"name":fileName,"date":new Date().toISOString().slice(0,10)})
			}, 500);	

	    })


	} 


	$scope.files = [];
	API.getAttachedFiles({userId: $scope.userId}).then(function(response){

		if(response.data.responce){ 
			if(response.data.links.length > 0) {
				response.data.links.forEach(function(file){
					$scope.files.push({ date: file.uploadedOn, checked :false ,name: file.url })	
				})
			}
		} 
		else {

		}

	});
	


	// $scope.files = [
	// 	{
	// 		"id":"1",
	// 		"name":"x-man pdf",
	// 		"date":"02/05/2012",
	// 		"checked":false
	// 	},
	// 	{
	// 		"id":"2",
	// 		"name":"The Economic Policy pdf",
	// 		"date":"02/05/2012",
	// 		"checked":false
	// 	},
	// 	{
	// 		"id":"3",
	// 		"name":"tail Head Png",
	// 		"date":"02/05/2012",
	// 		"checked":false
	// 	}
	// ]


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