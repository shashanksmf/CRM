var inspinia = angular.module('inspinia');
inspinia.factory('API', ['$http','$q',function($http,$q){

	var callAPI = {};
	// var baseHttpUrl = "/CRM.git/trunk/Service";
	var baseHttpUrl = 'https://upsailgroup.herokuapp.com/Service';

	callAPI.getAllEmpl = function(){
		return  $http({
			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			url: baseHttpUrl+'/GetEmplData.php',

		})

	}

	callAPI.registerUser = function(user) {

		return $http({

			method: 'GET',
			dataType: "jsonp",
			url: baseHttpUrl+'/Signup.php?name='+ user.userName + '&password='+ user.userPassword + '&email='+user.userEmail

		})

	}


	callAPI.loginUser = function(user) {

		return $http({

			method: 'GET',
			dataType: "jsonp",
			url: baseHttpUrl+'/Login.php?userName='+ user.userName + '&password='+ user.userPassword

		})

	}

	callAPI.googleLogIn = function() {
		console.log("google");
		// return $http({
		//
		// 	method: 'GET',
		// 	dataType: "jsonp",
		// 	url: baseHttpUrl+'/googleLogIn.php'
		//
		// })
		$http({
        method : "GET",
				dataType: "jsonp",
				url: baseHttpUrl+'/googleLogIn.php'
    }).success(function(response) {
			console.log("url===>",response.url);
			 window.location.href = response.url;
			return googleLogInReturnRes();
		})
		.error(function(response, status) {
		  console.error('Repos error', status, response);
		})
	}
	function googleLogInReturnRes() {
		console.log("googleLogInReturnRes");
		$http({
			method: 'GET',
			dataType: "jsonp",
			url: baseHttpUrl+'/googleLogIn.php'
		}).success(function(response) {
			// if(!response.data.token){
			// 	googleLogInReturnRes();
			// }
			return response;
		})
		.error(function(response, status) {
		  console.error('Repos error', status, response);
		})
	}

	callAPI.facebookLogIn = function() {
		console.log("facebook");
		return $http({

			method: 'GET',
			dataType: "jsonp",
			url: baseHttpUrl+'/facebookLogIn.php'

		})

	}

	callAPI.setAuth = function(user){
		this.userEmail = user.email;
		this.isUserAuth = true;
	}

	callAPI.getAllGroups = function() {

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl+'/GetGroups.php'

		})

	}

	callAPI.getAllCompanies = function() {

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl+'/GetCompanyData.php'

		})

	}

	callAPI.getTransactionDetails = function(tId) {

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl+'/GetTransactionDetails.php?tId='+tId

		})

	}


	callAPI.getGroupById = function(id) {

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl+'/GetGroups.php?id'+id

		})

	}

	callAPI.getEmployesNames = function(){

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl+'/GetEmplNameData.php'

		})

	}

	callAPI.searchEmployesNames = function(term){

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl+'/GetENSearch.php?term='+term

		})

	}

	callAPI.createGroup = function(group) {

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/AddGroups.php?name='+group.name+'&details='+group.details+'&admin='+group.groupadmin+'&members='+group.members+'&membersCount='+group.membersCount+'&createdOn='+group.createdOn

		})

	}

	callAPI.deleteGroup = function(group) {

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/DeleteGroup.php?id='+group.id

		})

	}

	callAPI.deleteContact = function(emplData) {
		console.log(emplData);
		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/DeleteContact.php?id='+emplData.id+'&name='+emplData.name+'&email='+emplData.email

		})

	}

	callAPI.deleteCampaign = function(campaignID) {

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/DeleteCampaign.php?id='+campaignID.id

		})

	}

	callAPI.deleteCompany = function(companyId) {

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/DeleteCompany.php?id='+companyId.id

		})

	}

	callAPI.updateMembersInGroup = function(group){
		//?id=1&members=2,3
		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/UpdateGroup.php?id='+group.id+'&members='+group.members

		})
	}


	callAPI.getAllNewChatDetails = function(userId){

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/chat/newChatDetails.php?userId='+userId

		})

	}


	callAPI.getChatDetails = function(chat){
		//?id=1&members=2,3
		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetChatMessages.php?from='+chat.from+'&to='+chat.to

		})
	}

	callAPI.getAllLatestMsg = function(userId) {

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/chat/allLatestMsg.php?userId='+userId

		})

	}

	callAPI.getUserProfile = function(user){

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "text",
			url: baseHttpUrl + '/GetProfiles.php?id='+user.userId

		})

	}

	callAPI.updateUserProfile = function(user){

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			url: baseHttpUrl + '/UpdateEmployees.php?name='+user.name+'&title='+user.title+'&industry='+user.industry+'&location='+user.location+'&ratings='+user.ratings+'&skype='+user.skype+'&age='+user.age+'&gender='+user.gender+'&officePhone='+user.officePhone+'&jobRole='+user.jobRole+'&phone='+user.phone+'&email='+user.email+'&linkedin='+user.linkedin+'&twitter='+user.twitter+'&facebook='+user.facebook+'&notes='+user.notes+'&id='+user.id+'&companyId='+user.companyId+'&companyName='+user.Company.name+'&imgUrl='+user.imgUrl+'&extra='+user.extra

		})

	}

	callAPI.uploadUserProfilePic = function(file){

		return $http.post(baseHttpUrl + '/uploadUserProfilePic.php', file,
		{

			withCredentials: false,
			transformRequest: angular.identity,
			headers: {'Content-Type': undefined, 'token': localStorage.getItem('token')},

		});

	}

	callAPI.getUserInfo = function(userId) {

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/getUserInfo.php?id='+userId

		})
	}

	callAPI.getUserMailChimpDetails = function(userId) {
		console.log("id",userId);
		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/getUserMailChimpDetails.php?id='+userId

		})
	}


	callAPI.uploadFileAttach = function(file){



    	// return $http.post(baseHttpUrl + '/ImageUploads.php', file,
	    // {

	    // 	withCredentials: false,
	    //     transformRequest: angular.identity,
	    //     headers: {'Content-Type': undefined} ,
	    //      uploadEventHandlers: {
		   //      progress: function (e) {
		   //                if (e.lengthComputable) {
		   //                   $scope.progressBar = (e.loaded / e.total) * 100;
		   //                   console.log($scope.progressBar);
		   //                   $scope.progressCounter = $scope.progressBar;
		   //                }
		   //      }
		   //  }

	    // });

	}


	callAPI.sendMessage = function(chat){
		//?id=1&members=2,3
		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/AddMessage.php?from='+chat.from+'&to='+chat.to+'&msg='+chat.msg

		})
	}

	callAPI.readMsg = function(chatId,fromId) {

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/chat/messageRead.php?chatId='+chatId+'&fromId='+fromId

		})

	}


	callAPI.getAttachedFiles = function(user){

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetAtt.php?id='+user.userId,


		})


	}

	callAPI.deleteEmplFile = function(empl) {

		return $http({

			method: 'GET',
			headers: {'token': localStorage.getItem('token')},
			dataType: "jsonp",
			url: baseHttpUrl + '/deleteEmplFile.php?emplId='+empl.emplId+'&fileId='+empl.fileId

		})

	}


	callAPI.uploadEmplProfilePic = function(file) {


		return $http.post(baseHttpUrl + '/uploadEmplProfilePic.php', file,  {

			withCredentials: false,
			transformRequest: angular.identity,
			headers: {'Content-Type': undefined, 'token': localStorage.getItem('token')},

		});

	}

	callAPI.sendSMS = function (data) {
		console.log("smsData", data);

	// return $http({

	//         method: 'GET',
	//         headers: {'token': localStorage.getItem('token')},
	//         dataType: "jsonp",
	//         url: baseHttpUrl + '/TwilioSMS/sendSMSTwilio.php?to='+data.to+'&text='+data.text

	//     })

}

callAPI.insertEmplBulkData = function(output) {

	//console.log("API file",output);
	var output = output;
	return $http({

		method: 'POST',
		data: {"data":output},
		url: "http://jaiswaldevelopers.com/CRMV1/sampleService.php",

	})

}

callAPI.insertBulkData = function(userId, bulkData) {
	var bulkData = bulkData;
	var userId = userId;
	return $http({

		method: 'POST',
		data: {'bulkData':bulkData, 'userId' :userId},
		url: baseHttpUrl + '/insertBulkData.php',
		headers: {'content-type': 'application/json',
		'accept': 'application/json',
		'token': localStorage.getItem('token'),
	},


})

}


callAPI.sendMail = function(users){

	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl + '/TestMail.php?to='+users.to+'&toName='+users.toName+'&subject='+users.subject

	})

}


callAPI.getTemplate = function(){

	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl + '/GetTemplates.php'

	})

}


callAPI.addCampaign = function(formData){

	return $http.post(baseHttpUrl + '/AddCampaign.php', formData,
	{

		withCredentials: false,
		transformRequest: angular.identity,
		headers: {'Content-Type': undefined, 'token': localStorage.getItem('token')},

	});

}


callAPI.runCampaign = function(campaignId){

	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl + '/RunCampaign.php?id='+campaignId

	})

}

callAPI.getAllCampaigns = function(formData){

	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl + '/GetCampiagn.php'

	})

}

callAPI.getUsersList = function(id) {
	//	http://jaiswaldevelopers.com/CRMV1/Service/getUsersList.php?id=1
	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl + '/getUsersList.php?id='+id

	})

}


callAPI.updateCompanyDetails = function(company){
	console.log("company",company);

	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl + '/UpdateCompany.php?id='+company.id+'&name='+company.name+'&areaOfWork='+company.areaOfWork+'&establised='+company.establised+'&employees='+company.employees+'&revenue='+company.revenue+'&ofcAddress='+company.ofcAddress+'&email='+company.email+'&google='+company.google+'&phone='+company.phone+'&fb='+company.fb+'&twitter='+company.twitter+'&ln='+company.linkedin+'&extra='+company.extra

	})

}

callAPI.getCompanyDetails = function(comapnyId){


	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl +'/GetCompanyData.php?id='+comapnyId
	})

}


callAPI.companyProfilePic = function(file){

	return $http.post(baseHttpUrl + '/CompanyProfilePic.php', file,  {

		withCredentials: false,
		transformRequest: angular.identity,
		headers: {'Content-Type': undefined, 'token': localStorage.getItem('token')},

	});

}

callAPI.updateMainUserProfile = function(userObj){

	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl +'/updateUser.php?id='+userObj.id+'&department='+userObj.department+'&dob='+userObj.dob+'&email='+userObj.email+'&gender='+userObj.gender+'&hireDate='+userObj.hireDate+'&homeAddress='+userObj.homeAddress+'&name='+userObj.name+'&phone='+userObj.phone

	})

}

callAPI.saveMailChimpDetails = function(mailchimpDetails){
	console.log("list",mailchimpDetails.dt);

	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl +'/saveMailChimpDetails.php?id='+mailchimpDetails.dt.id+'&userId='+mailchimpDetails.dt.userId+'&apiKey='+mailchimpDetails.dt.apiKey+'&listId='+mailchimpDetails.dt.listId+'&listName='+mailchimpDetails.dt.listName
	})

}

callAPI.deleteMailChimpDetails = function(mailchimpDetails){
	console.log("list",mailchimpDetails.dt);

	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl +'/deleteMailChimpDetails.php?id='+mailchimpDetails.dt.id+'&userId='+mailchimpDetails.dt.userId+'&apiKey='+mailchimpDetails.dt.apiKey+'&listId='+mailchimpDetails.dt.listId+'&listName='+mailchimpDetails.dt.listName
	})

}

callAPI.insertEmplProfile = function(file) {

	return $http.post(baseHttpUrl + '/insertUserProfile.php', file,  {

		withCredentials: false,
		transformRequest: angular.identity,
		headers: {'Content-Type': undefined, 'token': localStorage.getItem('token')},

	});

}

callAPI.insertCompanyProfile = function(file) {

	return $http.post(baseHttpUrl + '/insertCompanyProfile.php', file,  {

		withCredentials: false,
		transformRequest: angular.identity,
		headers: {'Content-Type': undefined, 'token': localStorage.getItem('token')},

	});

}

callAPI.addMailChimpId = function(apiKeyData){

	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl + '/addMailChimpId.php?userId='+apiKeyData.userId+'&apiKey='+apiKeyData.apiKey
	})

}

callAPI.addMailChimpList = function(listData){

	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl + '/addMailChimpList.php?userId='+listData.userId+'&apiKey='+listData.apiKey+'&listId='+listData.listId+'&listName='+listData.listName,

	})

}

callAPI.creatMailChimpList = function(listData){

	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl + '/creatMailChimpList.php?userId='+listData.userId+'&apiKey='+listData.apiKey+'&listName='+listData.listName,

	})

}

callAPI.getAllComapnies = function(){

	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl + '/getAllComapnies.php'

	})

}

callAPI.getCompanyAttachedFiles = function (company) {

	return $http({

		method: 'GET',
		headers: {'token': localStorage.getItem('token')},
		dataType: "jsonp",
		url: baseHttpUrl + '/GetCmpyAttachedFiles.php?id='+company.companyId,

	})

}

callAPI.saveSmsCampaign = function (smsData) {

	return $http.post(baseHttpUrl + "/insertSmsCampaign.php", 	smsData, {headers: {'Content-Type': 'application/json'} } )

     //   return $http({

	    //     method: 'POST',
	    //     data: smsData,
	    //     url: baseHttpUrl + "/insertSmsCampaign.php",
	    //     headers: {
		   //      "content-type": "application/json",
		   //      "accept": "application/json"
	    //     }

	    // })

	}



	//http://jaiswaldevelopers.com/CRMV1/Service/GetCampiagn.php
	return callAPI;

}]);
