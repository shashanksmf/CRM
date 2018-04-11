var inspinia = angular.module('inspinia');
inspinia.controller('personalMsgCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout', function ($scope,$rootScope,$http,$q,API,$state,$timeout) {
	//console.log("personalMsgCtrl called");

	var userId = $rootScope.userId || localStorage.getItem("userId");
	API.getUsersList(userId).then(function(response){
		 if(response.data.result) {
             $scope.UsersList = response.data.details;
         }
         else if(response.data.errorType && response.data.errorType == "token"){
                $('#tokenErrorModalLabel').html(response.data.details);
                $('#tokenErrorModal').modal("show");
                $('#tokenErrorModalBtn').click(function(){
                    $('#tokenErrorModal').modal("hide");
                })
         }
	})

	$scope.sendPersonalMsg = function(userId,msg){

		$scope.remoteUserId = userId;
		console.log(userId,msg);
		if(!$scope.remoteUserId || $scope.remoteUserId.length < 1) {
			alert("please select User");
			return false;
		}
		else if(!msg || msg.length < 1){
			alert("please type message");
			return false;
		}
		else{
			// '/AddMessage.php?from='+chat.from+'&to='+chat.to+'&msg='+chat.msg
			var chat = { 
				from : $rootScope.userId || localStorage.getItem("userId") ,
				to : $scope.remoteUserId,
				msg : msg
			}

			API.sendMessage(chat).then(function(response){
				//console.log("response",response.data.responce);
				if(response.data.responce){
					alert("message successfully send");
					$scope.personalMessageTxt = '';
				}
				else if(response.data.errorType && response.data.errorType == "token"){
	                $('#tokenErrorModalLabel').html(response.data.details);
	                $('#tokenErrorModal').modal("show");
	                $('#tokenErrorModalBtn').click(function(){
	                    $('#tokenErrorModal').modal("hide");
	                })
         		}else{
					alert("please try again");
				}
			});

		}
	}

	$scope.selectDropDownUser = function(username,userId){
		$scope.selectUser = username;
		$scope.remoteUserId = userId;
	}

}])