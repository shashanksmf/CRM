var inspinia = angular.module('inspinia');
inspinia.controller('mainUserProfileCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout','$stateParams', function ($scope,$rootScope,$http,$q,API,$state,$timeout,$stateParams) {

$scope.isUserProfileEdit = false;
$scope.editRow = null; 
    
var userId = $rootScope.userId || localStorage.getItem("userId");
     API.getUserInfo(userId).then(function(response) {
         if(response.data.result) {
             $scope.mainUserInfo = response.data.details;
             $scope.getUserMailChimpDetails();
         }
         else if("errorType" in response.data && response.data.errorType && response.data.errorType == "token"){
                $('#tokenErrorModalLabel').html(response.data.details);
                $('#tokenErrorModal').modal("show");
                $('#tokenErrorModalBtn').click(function(){
                    $('#tokenErrorModal').modal("hide");
                })
         }
    });

$scope.getUserMailChimpDetails = function(){
     API.getUserMailChimpDetails(userId).then(function(response) {
        console.log("DATA",response.data.details);
         if(response.data.result) {
             $scope.mailChimpDetails = response.data.details;
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

$scope.saveMailChimpDetails = function(index, dt){
    $scope.editRow = false;
    API.saveMailChimpDetails({dt}).then(function(response){
        console.log("saveMailChimpDetails",response);
        if(response.data.result) {
            alert("MailChimp Details Saved Successfully");
         }
         else if(response.data.errorType && response.data.errorType == "token"){
                $('#tokenErrorModalLabel').html(response.data.details);
                $('#tokenErrorModal').modal("show");
                $('#tokenErrorModalBtn').click(function(){
                    $('#tokenErrorModal').modal("hide");
                })
         }
         else if("errorType" in response.data && response.data.errorType == "listId"){
            alert("List Id is invalid");
         }
         else {
            alert("Something Wrong with the server");
         }
    });
}

$scope.saveMainUserProfile = function() {
    $scope.isUserProfileEdit = false;
    var userInfoObj = $scope.mainUserInfo;
    API.updateMainUserProfile(userInfoObj).then(function(response){
        console.log("update main user profile response",response);
        if(response.data.result) {
            
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

$scope.allowEditProfile = function(){
 $scope.isUserProfileEdit = true;   
}

$scope.allowEditMailChimpDetails = function(index){
 $scope.editRow = index;   
}

$scope.addMailChimpIdBtn= function(){
    var apiKey = $scope.addMailChimpIdApiKey;
    API.addMailChimpId({userId: userId, apiKey: apiKey}).then(function(response){
        console.log(response);
         if(response.data.result) {
            alert("API Key Addedd Successfully");
         }
         else if(response.data.errorType && response.data.errorType == "token"){
                $('#tokenErrorModalLabel').html(response.data.details);
                $('#tokenErrorModal').modal("show");
                $('#tokenErrorModalBtn').click(function(){
                    $('#tokenErrorModal').modal("hide");
                })
         }
         else if("errorType" in response.data && response.data.errorType == "apiKey"){
            alert("API Key is invalid");
         }
         else {
            alert("Something Wrong with the server");
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
         else if(response.data.errorType && response.data.errorType == "token"){
                $('#tokenErrorModalLabel').html(response.data.details);
                $('#tokenErrorModal').modal("show");
                $('#tokenErrorModalBtn').click(function(){
                    $('#tokenErrorModal').modal("hide");
                })
         }
         else if("errorType" in response.data && response.data.errorType == "listId"){
            alert("Invalid List Details");
         }
         else {
            alert("Something Wrong with the server");
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
         else if(response.data.errorType && response.data.errorType == "token"){
                $('#tokenErrorModalLabel').html(response.data.details);
                $('#tokenErrorModal').modal("show");
                $('#tokenErrorModalBtn').click(function(){
                    $('#tokenErrorModal').modal("hide");
                })
         }
         else{
            alert("Something Wrong with the server");
         }
    });
  
}



}]);	
