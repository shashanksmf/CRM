//var inspinia = angular.module('inspinia');
inspinia.controller('mailCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout','$sce', function ($scope,$rootScope,$http,$q,API,$state,$timeout,$sce) {
	
	$scope.isShowTemplate = false;




	API.getAllCampaigns().then(function(response){
		$scope.campaigns = response.data.camp;
	})

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



var data = JSON.stringify({
  "from": "InfoSMS",
  "to": "+918983485655",
  "text": "Test SMS."
});

var xhr = new XMLHttpRequest();
xhr.withCredentials = false;

xhr.addEventListener("readystatechange", function () {
  if (this.readyState === this.DONE) {
    console.log(this.responseText);
  }
});

xhr.open("POST", "https://api.infobip.com/sms/1/text/single");
xhr.setRequestHeader("authorization", "Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==");
xhr.setRequestHeader("content-type", "application/json");
xhr.setRequestHeader("accept", "application/json");

xhr.send(data);
	alert("Please wait until we provide you API key");
	}

	var mailData = {to:"shankie1990@gmail.com" , toName:"shashank Jaiswal" , subject : "testing MailChimp" };	

	$scope.sendMail = function () {

		API.sendMail(mailData).then(function(response){
			console.log(response);

		})

	}


	API.getTemplate().then(function(response){
		var templateStr = JSON.stringify(response.data).replace(/\r?\n|\r/g,'');
		var str = ((JSON.parse(templateStr)).replace(/\r?\n|\r/g,''));
		$scope.templateObj =JSON.parse(str);

		//var html = decodeHtml(htmlObj.templ[0].html);
		//$(html).children().find("#changeContent table > tbody > tr > td > p ").eq(1).html($scope.campaignMessage);
		//$scope.htmlTemplate = $sce.trustAsHtml(html);
		//console.log($scope.htmlTemplate);
	})


	$scope.previewTemplate = function(){
		
		$scope.isShowTemplate = true;
		//alert($scope.campaignMessage);
		var html = decodeHtml($scope.templateObj.templ[0].html);
		$scope.htmlTemplate = $sce.trustAsHtml(html);
		setTimeout(function() {
		document.querySelectorAll("#changeContent table tr td")[0].children[1].innerHTML = $scope.campaignMessage;
		document.querySelectorAll("#changeContent table tr td")[0].children[2].remove();
		document.querySelectorAll("#changeContent table tr td")[0].children[3].innerHTML = '';
				//	console.log(document.querySelectorAll("#changeContent table tr td")[0].children[1].innerHTML)
		}, 10);
		

	}

	$scope.hideTemplatePreview = function(){
		$scope.isShowTemplate = false;
	}
	
	function decodeHtml(html) {
	    var txt = document.createElement("textarea");
	    txt.innerHTML = html;
	    return txt.value;
	}

//	$scope.addCampaignSubmit();
	$scope.addCampaignSubmit = function(){
	
		$scope.formData = new FormData();
		$scope.formData.append("name", $scope.campaignName);
		$scope.formData.append("createdBy",$rootScope.userName || localStorage.getItem("userName") || "Admin");
		$scope.formData.append("emails", $rootScope.userEmail || localStorage.getItem("userName") || "shashanksmf@outlook.com" );
		$scope.formData.append("subject", $scope.campaignEmailSubject);
		$scope.formData.append("body", $scope.campaignMessage);
		$scope.formData.append("templateId", "2");
		$scope.formData.append("dates", new Date());

		API.addCampaign($scope.formData).then(function(response){
			console.log(response);
			$scope.campaignId = response.data.id;

			console.log("run campaign")
			API.runCampaign($scope.campaignId).then(function(response){
				console.log(response);

				alert("campaign Successfully started");
//				location.reload();
			},
			    function(data) {
			  	alert("campaign Successfully started");
			        // Handle error here
//			  	location.reload();
			    })
		})
	
	}

}])
