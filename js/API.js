var inspinia = angular.module('inspinia');
inspinia.factory('API', ['$http','$q',function($http,$q){
	
	var callAPI = {}; 
  //  var baseHttpUrl = "/angularphp/template/Angular_Full_Version/Service";
	var baseHttpUrl = 'http://jaiswaldevelopers.com/CRMV1/Service';
    
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

	callAPI.setAuth = function(user){
		this.userEmail = user.email;
		this.isUserAuth = true;
	}

	callAPI.getAllGroups = function() {
		
		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl+'/GetGroups.php' 

	    })
	
	}


	callAPI.getGroupById = function(id) {
		
		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl+'/GetGroups.php?id'+id

	    })
	
	}

	callAPI.getEmployesNames = function(){

		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl+'/GetEmplNameData.php'

	    })

	}

	callAPI.searchEmployesNames = function(term){

		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl+'/GetENSearch.php?term='+term

	    })

	}

	callAPI.createGroup = function(group) {
		
		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/AddGroups.php?name='+group.name+'&details='+group.details+'&admin='+group.groupadmin+'&members='+group.members+'&membersCount='+group.membersCount+'&createdOn='+group.createdOn

	    })
	
	}

	callAPI.updateMembersInGroup = function(group){
		//?id=1&members=2,3
		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/UpdateGroup.php?id='+group.id+'&members='+group.members

	    })
	}


	callAPI.getAllNewChatDetails = function(user){
		
		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/chat/newChatDetails.php?userId='+user.userId

	    })

	}


	callAPI.getChatDetails = function(chat){
		//?id=1&members=2,3
		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/GetChatMessages.php?from='+chat.from+'&to='+chat.to

	    })
	}

	callAPI.getAllLatestMsg = function(user) {

		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/chat/allLatestMsg.php?userId='+user.userId

	    })

	}
    
    callAPI.getUserProfile = function(user){ 
    
        return $http({

	        method: 'GET',
	        dataType: "text",
	        url: baseHttpUrl + '/GetProfiles.php?id='+user.userId

	    })
        
    }

    callAPI.updateUserProfile = function(user){ 
    
        return $http({

	        method: 'GET',
	        url: baseHttpUrl + '/UpdateEmployees.php?name='+user.name+'&title='+user.title+'&industry='+user.industry+'&location='+user.location+'&ratings='+user.ratings+'&skype='+user.skype+'&age='+user.age+'&gender='+user.gender+'&officePhone='+user.officePhone+'&jobRole='+user.jobRole+'&phone='+user.phone+'&email='+user.email+'&linkedin='+user.linkedin+'&twitter='+user.twitter+'&facebook='+user.facebook+'&notes='+user.notes+'&id='+user.id

	    })
        
    }

    callAPI.uploadUserProfilePic = function(file){

    	return $http.post(baseHttpUrl + '/uploadUserProfilePic.php', file,  
	    {   
	    	
	    	withCredentials: false,
	        transformRequest: angular.identity,  
	        headers: {'Content-Type': undefined}  
	    
	    });

    }

    callAPI.getUserInfo = function(userId) {

     return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/getUserInfo.php?id='+userId

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
	        dataType: "jsonp",
	        url: baseHttpUrl + '/AddMessage.php?from='+chat.from+'&to='+chat.to+'&msg='+chat.msg

	    })
	}

	callAPI.readMsg = function(chatId,fromId) {

		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/chat/messageRead.php?chatId='+chatId+'&fromId='+fromId

	    })

	}


	callAPI.getAttachedFiles = function(user){

		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/GetAtt.php?id='+user.userId,


	    })
		

	}

	callAPI.deleteEmplFile = function(empl) {

		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/deleteEmplFile.php?emplId='+empl.emplId+'&fileId='+empl.fileId

	    })

	}


	callAPI.uploadEmplProfilePic = function(file) {


    	return $http.post(baseHttpUrl + '/uploadEmplProfilePic.php', file,  {   
	    	
	    	withCredentials: false,
	        transformRequest: angular.identity,  
	        headers: {'Content-Type': undefined}  
	    
	    });

	}

	callAPI.sendSMS = function (group) {

	return $http({

        method: 'POST',
        data: JSON.stringify({  
		   "from":"InfoSMS",
		   "to":"+918983485655",
		   "text":"My first Infobip SMS"
		}),
        url: "https://api.infobip.com/sms/1/text/single",
        headers: {
        "content-type": "application/json",
        "authorization": "Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==",
        "accept": "application/json"
        },
    	
        
    })

	}


	callAPI.sendMail = function(users){

		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/TestMail.php?to='+users.to+'&toName='+users.toName+'&subject='+users.subject

	    })

	}


	callAPI.getTemplate = function(){

		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/GetTemplates.php'

	    })

	}


	callAPI.addCampaign = function(formData){

			return $http.post(baseHttpUrl + '/AddCampaign.php', formData,  
	    {   
	    	
	    	withCredentials: false,
	        transformRequest: angular.identity,  
	        headers: {'Content-Type': undefined}  
	    
	    });

	}
	

	callAPI.runCampaign = function(campaignId){

		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/RunCampaign.php?id='+campaignId

	    })

	}

	callAPI.getAllCampaigns = function(formData){

		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/GetCampiagn.php'

	    })

	}

	callAPI.getUsersList = function(id) {
	//	http://jaiswaldevelopers.com/CRMV1/Service/getUsersList.php?id=1
		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/getUsersList.php?id='+id

	    })
        
	}
    

    callAPI.updateCompanyDetails = function(company){
        console.log("company",company);
        
        return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/UpdateCompany.php?id='+company.id+'&name='+company.name+'&areaOfWork='+company.areaOfWork+'&establised='+company.establised+'&employees='+company.employees+'&revenue='+company.revenue+'&ofcAddress='+company.ofcAddress+'&email='+company.email+'&google='+company.google+'&phone='+company.phone

	    })
        
    }
    
    callAPI.getCompanyDetails = function(comapnyId){
        
          
       return $http({
                method: 'GET',
                dataType: "jsonp",
                url: baseHttpUrl +'/GetCompanyData.php?id='+comapnyId
        })

    }


    callAPI.companyProfilePic = function(file){

	 	return $http.post(baseHttpUrl + '/CompanyProfilePic.php', file,  {   
	    	
	    	withCredentials: false,
	        transformRequest: angular.identity,  
	        headers: {'Content-Type': undefined}  
	    
	    });

    }



	

	//http://jaiswaldevelopers.com/CRMV1/Service/GetCampiagn.php
	return callAPI;

}]);