var inspinia = angular.module('inspinia');
inspinia.controller('mailCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout', function ($scope,$rootScope,$http,$q,API,$state,$timeout) {
	
	API.getAllGroups().then(function(groupData){
		$scope.groups = groupData.data;    
		console.log("$scope.groups : ",$scope.groups)
	})


   var SMSdata =  {  
		   "from":"InfoSMS",
		   "to":"+918983485655",
		   "text":"My first Infobip SMS"
		}

	$scope.sendSMS = function(){	

		API.sendSMS(SMSdata).then(function(response){
			console.log(response);

		})	

	}

	var mailData = {to:"shankie1990@gmail.com" , toName:"shashank Jaiswal" , subject : "testing MailChimp" };	

	$scope.sendMail = function () {

		API.sendMail(mailData).then(function(response){
			console.log(response);

		})

	}

}])