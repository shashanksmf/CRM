var inspinia = angular.module('inspinia');
inspinia.factory('API', ['$http', '$q', function($http, $q) {

	var callAPI = {};
	// var baseHttpUrl = "Service";
	var baseHttpUrl = 'https://upsailgroup.herokuapp.com/Service';

	callAPI.getAllEmpl = function() {
		return $http({
			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			url: baseHttpUrl + '/GetEmplData.php',
		})
	}

	callAPI.registerUser = function(user) {

		return $http({

			method: 'GET',
			dataType: "jsonp",
			url: baseHttpUrl + '/Signup.php?name=' + user.userName + '&password=' +
				user.userPassword + '&email=' + user.userEmail

		})

	}


	callAPI.loginUser = function(user) {

		return $http({

			method: 'GET',
			dataType: "jsonp",
			url: baseHttpUrl + '/Login.php?userName=' + user.userName +
				'&password=' + user.userPassword

		})

	}

	callAPI.googleLogIn = function() {
		console.log("google");
		return $http({

			method: 'GET',
			dataType: "jsonp",
			url: baseHttpUrl + '/googleLogIn.php'

		})
	}

	callAPI.facebookLogIn = function() {
		console.log("facebook");
		return $http({

			method: 'GET',
			dataType: "jsonp",
			url: baseHttpUrl + '/facebookLogIn.php'

		})

	}

	callAPI.setAuth = function(user) {
		this.userEmail = user.email;
		this.isUserAuth = true;
	}

	callAPI.getAllGroups = function() {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetGroups.php'

		})

	}

	callAPI.getAllCompanies = function() {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetCompanyData.php'

		})

	}

	callAPI.getTransactionDetails = function(tId) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetTransactionDetails.php?tId=' + tId

		})

	}


	callAPI.getGroupById = function(id) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetGroups.php?id' + id

		})

	}

	callAPI.getEmployesNames = function() {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetEmplNameData.php'

		})

	}

	callAPI.searchEmployesNames = function(term) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetENSearch.php?term=' + term

		})

	}

	callAPI.createGroup = function(group) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/AddGroups.php?name=' + group.name + '&details=' +
				group.details + '&admin=' + group.groupadmin + '&members=' + group.members +
				'&membersCount=' + group.membersCount + '&createdOn=' + group.createdOn

		})

	}

	callAPI.deleteGroup = function(group) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/DeleteGroup.php?id=' + group.id

		})

	}

	callAPI.changeSub = function() {
		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/changeSub.php'
		})
	}

	callAPI.deleteContact = function(emplData) {
		console.log(emplData);
		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/DeleteContact.php?id=' + emplData.id +
				'&name=' +
				emplData.name + '&email=' + emplData.email

		})

	}

	callAPI.deleteCampaign = function(campaignID) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/DeleteCampaign.php?id=' + campaignID.id

		})

	}

	callAPI.deleteCompany = function(companyId) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/DeleteCompany.php?id=' + companyId.id

		})

	}

	callAPI.updateMembersInGroup = function(group) {
		//?id=1&members=2,3
		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/UpdateGroup.php?id=' + group.id + '&members=' +
				group.members

		})
	}


	callAPI.getAllNewChatDetails = function(userId) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/chat/newChatDetails.php?userId=' + userId

		})

	}


	callAPI.getChatDetails = function(chat) {
		//?id=1&members=2,3
		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetChatMessages.php?from=' + chat.from +
				'&to=' +
				chat.to

		})
	}

	callAPI.getAllLatestMsg = function(userId) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/chat/allLatestMsg.php?userId=' + userId

		})

	}

	callAPI.getUserProfile = function(user) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "text",
			url: baseHttpUrl + '/GetProfiles.php?id=' + user.userId

		})

	}

	callAPI.updateUserProfile = function(user) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			url: baseHttpUrl + '/UpdateEmployees.php?name=' + user.name +
				'&title=' + user.title + '&industry=' + user.industry +
				'&location=' +
				user.location + '&ratings=' + user.ratings + '&skype=' + user.skype +
				'&age=' + user.age + '&gender=' + user.gender + '&officePhone=' +
				user.officePhone + '&jobRole=' + user.jobRole + '&phone=' + user.phone +
				'&email=' + user.email + '&linkedin=' + user.linkedin +
				'&twitter=' +
				user.twitter + '&facebook=' + user.facebook + '&notes=' + user.notes +
				'&id=' + user.id + '&companyId=' + user.companyId +
				'&companyName=' +
				user.Company.name + '&imgUrl=' + user.imgUrl + '&extra=' + user.extra

		})

	}

	callAPI.uploadUserProfilePic = function(file) {

		return $http.post(baseHttpUrl + '/uploadUserProfilePic.php', file, {

			withCredentials: false,
			transformRequest: angular.identity,
			headers: {
				'Content-Type': undefined,
				'token': localStorage.getItem('token')
			},

		});

	}

	callAPI.getUserInfo = function(userId) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/getUserInfo.php?id=' + userId

		})
	}

	callAPI.getUserMailChimpDetails = function(userId) {
		console.log("id", userId);
		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/getUserMailChimpDetails.php?id=' + userId

		})
	}


	callAPI.uploadFileAttach = function(file) {



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


	callAPI.sendMessage = function(chat) {
		//?id=1&members=2,3
		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/AddMessage.php?from=' + chat.from + '&to=' +
				chat
				.to + '&msg=' + chat.msg

		})
	}

	callAPI.readMsg = function(chatId, fromId) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/chat/messageRead.php?chatId=' + chatId +
				'&fromId=' + fromId

		})

	}


	callAPI.getAttachedFiles = function(user) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetAtt.php?id=' + user.userId,

		})


	}

	callAPI.deleteEmplFile = function(empl) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/deleteEmplFile.php?emplId=' + empl.emplId +
				'&fileId=' + empl.fileId

		})

	}


	callAPI.uploadEmplProfilePic = function(file) {


		return $http.post(baseHttpUrl + '/uploadEmplProfilePic.php', file, {

			withCredentials: false,
			transformRequest: angular.identity,
			headers: {
				'Content-Type': undefined,
				'token': localStorage.getItem('token')
			},

		});

	}

	callAPI.sendSMS = function(data) {
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
			data: {
				"data": output
			},
			url: "http://jaiswaldevelopers.com/CRMV1/sampleService.php",

		})

	}

	callAPI.insertBulkData = function(userId, bulkData) {
		// console.log("bulkData", bulkData);
		var bulkData = bulkData;
		var userId = userId;
		return $http({
			method: 'POST',
			headers: {
				transformRequest: angular.identity,
				'token': localStorage.getItem('token'),
			},
			data: {
				'bulkData': bulkData,
				'userId': userId
			},
			url: baseHttpUrl + '/insertBulkData.php',
		})
	}


	callAPI.sendMail = function(users) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/TestMail.php?to=' + users.to + '&toName=' +
				users
				.toName + '&subject=' + users.subject

		})

	}


	callAPI.getTemplate = function() {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetTemplates.php'

		})

	}


	callAPI.addCampaign = function(formData) {

		return $http.post(baseHttpUrl + '/AddCampaign.php', formData, {

			withCredentials: false,
			transformRequest: angular.identity,
			headers: {
				'Content-Type': undefined,
				'token': localStorage.getItem('token')
			},

		});

	}


	callAPI.runCampaign = function(campaignId) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/RunCampaign.php?id=' + campaignId

		})

	}

	callAPI.getAllCampaigns = function(formData) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetCampiagn.php'

		})

	}

	callAPI.getUsersList = function(id) {
		//	http://jaiswaldevelopers.com/CRMV1/Service/getUsersList.php?id=1
		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/getUsersList.php?id=' + id

		})

	}


	callAPI.updateCompanyDetails = function(company) {
		console.log("company", company);

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/UpdateCompany.php?id=' + company.id + '&name=' +
				company.name + '&areaOfWork=' + company.areaOfWork +
				'&establised=' +
				company.establised + '&employees=' + company.employees +
				'&revenue=' +
				company.revenue + '&ofcAddress=' + company.ofcAddress + '&email=' +
				company.email + '&google=' + company.google + '&phone=' + company.phone +
				'&fb=' + company.fb + '&twitter=' + company.twitter + '&ln=' +
				company.linkedin + '&extra=' + company.extra

		})

	}

	callAPI.getCompanyDetails = function(comapnyId) {


		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetCompanyData.php?id=' + comapnyId
		})

	}


	callAPI.companyProfilePic = function(file) {

		return $http.post(baseHttpUrl + '/CompanyProfilePic.php', file, {

			withCredentials: false,
			transformRequest: angular.identity,
			headers: {
				'Content-Type': undefined,
				'token': localStorage.getItem('token')
			},

		});

	}

	callAPI.updateMainUserProfile = function(userObj) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/updateUser.php?id=' + userObj.id +
				'&department=' +
				userObj.department + '&dob=' + userObj.dob + '&email=' + userObj.email +
				'&gender=' + userObj.gender + '&hireDate=' + userObj.hireDate +
				'&homeAddress=' + userObj.homeAddress + '&name=' + userObj.name +
				'&phone=' + userObj.phone

		})

	}

	callAPI.saveMailChimpDetails = function(mailchimpDetails) {
		console.log("list", mailchimpDetails.dt);

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/saveMailChimpDetails.php?id=' +
				mailchimpDetails.dt
				.id + '&userId=' + mailchimpDetails.dt.userId + '&apiKey=' +
				mailchimpDetails.dt.apiKey + '&listId=' + mailchimpDetails.dt.listId +
				'&listName=' + mailchimpDetails.dt.listName
		})

	}

	callAPI.deleteMailChimpDetails = function(mailChimpDetails) {
		console.log("list", mailChimpDetails.dt.listid);

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/deleteMailChimpDetails.php?&listId=' +
				mailChimpDetails.dt.listid
		})

	}

	callAPI.insertEmplProfile = function(file) {

		return $http.post(baseHttpUrl + '/insertUserProfile.php', file, {

			withCredentials: false,
			transformRequest: angular.identity,
			headers: {
				'Content-Type': undefined,
				'token': localStorage.getItem('token')
			},

		});

	}

	callAPI.insertCompanyProfile = function(file) {

		return $http.post(baseHttpUrl + '/insertCompanyProfile.php', file, {

			withCredentials: false,
			transformRequest: angular.identity,
			headers: {
				'Content-Type': undefined,
				'token': localStorage.getItem('token')
			},

		});

	}

	callAPI.addMailChimpId = function(apiKeyData) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/addMailChimpId.php?userId=' + apiKeyData.userId +
				'&apiKey=' + apiKeyData.apiKey
		})

	}

	callAPI.addMailChimpList = function(listData) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/addMailChimpList.php?userId=' + listData.userId +
				'&apiKey=' + listData.apiKey + '&listId=' + listData.listId +
				'&listName=' + listData.listName,

		})

	}


	callAPI.createCustomList = function(listData) {
		// console.log(listData);
		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/createCustomList.php?&userId=' + listData.userId +
				'&name=' + listData.name + '&type=' + listData.type
		})

	}


	callAPI.creatMailChimpList = function(listData) {
		// console.log(listData);
		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/createMailChimpList.php?&userId=' + listData.userId +
				'&apiKey=' + listData.apiKey +
				'&name=' + listData.name + '&type=' + listData.type +
				'&company=' + listData.company + '&address1=' + listData.address1 +
				'&address2=' + listData.address2 + '&city=' + listData.city +
				'&state=' +
				listData.state + '&zip=' + listData.zip + '&country=' + listData.country +
				'&phone=' +
				listData.phone +
				'&permission_reminder=' + listData.permission_reminder +
				'&from_name=' +
				listData.from_name + '&from_email=' + listData.from_email +
				'&subject=' +
				listData.subject + '&language=' + listData.language +
				'&email_type_option=' + listData.email_type_option,

		})

	}

	callAPI.updateMailChimpList = function(listId, listData) {
		// console.log(listId);
		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/updateMailChimpList.php?listId=' + listId +
				'&userId=' +
				listData.userId +
				'&apiKey=' + listData.apiKey +
				'&name=' + listData.name + '&company=' + listData.company +
				'&address1=' + listData.address1 +
				'&address2=' + listData.address2 + '&city=' + listData.city +
				'&state=' +
				listData.state + '&zip=' + listData.zip + '&country=' + listData.country +
				'&phone=' +
				listData.phone +
				'&permission_reminder=' + listData.permission_reminder +
				'&from_name=' +
				listData.from_name + '&from_email=' + listData.from_email +
				'&subject=' +
				listData.subject + '&language=' + listData.language +
				'&email_type_option=' + listData.email_type_option,

		})

	}

	callAPI.viewMailChimpList = function(userId) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/viewMailChimpList.php?userId=' + userId
		})

	}

	callAPI.transactionList = function(userId) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/transactionList.php?userId=' + userId
		})

	}
	callAPI.viewTransactionDetails = function(tId, userId) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/viewTransactionDetails.php?userId=' + userId +
				'&tId=' + tId
		})

	}

	callAPI.editMailChimpList = function(listId) {
		console.log(listId);
		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/editMailChimpList.php?listId=' + listId
		})

	}


	callAPI.getAllComapnies = function() {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/getAllCompanies.php'

		})

	}

	callAPI.getCompanyAttachedFiles = function(company) {

		return $http({

			method: 'GET',
			headers: {
				'token': localStorage.getItem('token')
			},
			dataType: "jsonp",
			url: baseHttpUrl + '/GetCmpyAttachedFiles.php?id=' + company.companyId,

		})

	}

	callAPI.saveSmsCampaign = function(smsData) {

		return $http.post(baseHttpUrl + "/insertSmsCampaign.php", smsData, {
			headers: {
				'Content-Type': 'application/json'
			}
		})

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
