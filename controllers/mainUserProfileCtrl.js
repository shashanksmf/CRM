var inspinia = angular.module('inspinia');
inspinia.controller('mainUserProfileCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout','$stateParams', function ($scope,$rootScope,$http,$q,API,$state,$timeout,$stateParams) {

$scope.isUserProfileEdit = false;    
    
var userId = $rootScope.userId || localStorage.getItem("userId");
     API.getUserInfo(userId).then(function(response) {
        console.log("123",response.data.details);
         if(response.data.result) {
             $scope.mainUserInfo = response.data.details;
         }
         else if(response.data.errorType == "token"){
                $('#tokenErrorModalLabel').html(response.data.details);
                $('#tokenErrorModal').modal("show");
                $('#tokenErrorModalBtn').click(function(){
                    $('#tokenErrorModal').modal("hide");
                })
         }
    });

     API.getUserMailChimpDetails({id: userId}).then(function(response) {
        console.log("123",response.data.details);
             $scope.mailChimpDetails = response.data.details;
             console.log("444",$scope.mailChimpDetails);
         if(response.data.result) {
         }
         else if(response.data.errorType == "token"){
                $('#tokenErrorModalLabel').html(response.data.details);
                $('#tokenErrorModal').modal("show");
                $('#tokenErrorModalBtn').click(function(){
                    $('#tokenErrorModal').modal("hide");
                })
         }
    });

// $scope.mailChimpDetails = function(){
//     API.saveMailChimpDetails({userId: userId, apiKey: apiKey, listId: listId, listName: listName}).then(function(response){
//         console.log("saveMailChimpDetails",response);
//         if(response.data.result) {
//             alert("MailChimp Details Saved Successfully");
//          }
//          else if(response.data.errorType == "token"){
//                 $('#tokenErrorModalLabel').html(response.data.details);
//                 $('#tokenErrorModal').modal("show");
//                 $('#tokenErrorModalBtn').click(function(){
//                     $('#tokenErrorModal').modal("hide");
//                 })
//          }
//     });
// }

$scope.saveMainUserProfile = function() {
    $scope.isUserProfileEdit = false;
    var userInfoObj = $scope.mainUserInfo;
    API.updateMainUserProfile(userInfoObj).then(function(response){
        console.log("update main user profile response",response);
        if(response.data.result) {
            
         }
         else if(response.data.errorType == "token"){
                $('#tokenErrorModalLabel').html(response.data.details);
                $('#tokenErrorModal').modal("show");
                $('#tokenErrorModalBtn').click(function(){
                    $('#tokenErrorModal').modal("hide");
                })
         }
    });
}

$scope.allowEditProfile = function(){
 $scope.isUserProfileEdit = true;   
}

$scope.addMailChimpIdBtn= function(){
    var apiKey = $scope.addMailChimpIdApiKey;
    API.addMailChimpId({userId: userId, apiKey: apiKey}).then(function(response){
        console.log(response);
         if(response.data.result) {
            alert("API Key Addedd Successfully");
         }
         else if(response.data.errorType == "token"){
                $('#tokenErrorModalLabel').html(response.data.details);
                $('#tokenErrorModal').modal("show");
                $('#tokenErrorModalBtn').click(function(){
                    $('#tokenErrorModal').modal("hide");
                })
         }
         else{
            alert("API Key is invalid");
         }
    });
  
}

$scope.addListBtn = function(){
    var apiKey = $scope.addListApiKey;
    var listId = $scope.addListId;
    var listName = $scope.addListName;
    API.addMailChimpList({userId: userId, apiKey: apiKey, listId: listId, listName: listName}).then(function(response){
        console.log(response);
        if(response.data.result) {
            alert("List Addedd Successfully");
         }
         else if(response.data.errorType == "token"){
                $('#tokenErrorModalLabel').html(response.data.details);
                $('#tokenErrorModal').modal("show");
                $('#tokenErrorModalBtn').click(function(){
                    $('#tokenErrorModal').modal("hide");
                })
         }
         else{
            alert("Invalid List Details");
         }
    });
  
}

$scope.createListBtn = function(){
    var apiKey = $scope.createListApiKey;
    var listName = $scope.createListName;
    API.creatMailChimpList({userId: userId, apiKey: apiKey, listName: listName}).then(function(response){
        console.log(response);
        if(response.data.result) {
             alert("List Created Successfully");
         }
         else if(response.data.errorType == "token"){
                $('#tokenErrorModalLabel').html(response.data.details);
                $('#tokenErrorModal').modal("show");
                $('#tokenErrorModalBtn').click(function(){
                    $('#tokenErrorModal').modal("hide");
                })
         }
         else{
            alert("Invalid API Key");
         }
    });
  
}



}]);	
