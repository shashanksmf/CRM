var inspinia = angular.module('inspinia');
inspinia.factory('API', ['$http',function($http){
	
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


	callAPI.createGroup = function(group) {
		
		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/AddGroups.php?name='+group.newGroup+'&details='+group.details+'&admin='+group.groupadmin+'&members='+group.members+'&membersCount='+group.membersCount+'&createdOn='+group.createdOn

	    })
	
	}

	callAPI.addMembersInGroup = function(group){
		//?id=1&members=2,3
		return $http({

	        method: 'GET',
	        dataType: "jsonp",
	        url: baseHttpUrl + '/UpdateGroup.php?id='+group.id+'&members='+group.members

	    })
	} 
	
	return callAPI;

}]);