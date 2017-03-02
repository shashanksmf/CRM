var inspinia = angular.module('inspinia');
inspinia.controller('groupCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout', function ($scope,$rootScope,$http,$q,API,$state,$timeout) {
	
	API.getAllGroups().then(function(groupData){
		$scope.groups = groupData.data;    
	})

	API.getEmployesNames().then(function(response){
		$scope.emplNames =  response.data.Employees;	
	})




	$scope.createGroup = function(groupName,groupDetail) {

		if(groupName && groupName.length > 0){

		    var createGroupObj = {
		        "name": groupName,
		        "details": groupDetail,
		        "admin": $rootScope.userName || localStorage.getItem("userName"),
		        "Members":0,
		        "membersCount": "0"
		    }

		    API.createGroup(createGroupObj).then(function(response){
		    	//check if group already exists
		    	if(response.data.responce){
		    		$scope.groups.Groups.push(createGroupObj)
		    	}
		    	else if(!response.data.responce)
		    	{
		    		alert(response.data.message)
		    	}
		    })

			
		}

		else{

			alert("please enter group Name");
		
		}	

	}


	$scope.editGroup = function(groupIndex) {
			$scope.groupIndex = groupIndex;
	}

	$scope.addEmpl = function(emplName,memberIndex,emplId) {

			//memberIndex is the index of member array in which the emplyee is found


			if($scope.groups.Groups[$scope.groupIndex].Members[memberIndex].id == emplId) {
			
				$scope.groups.Groups[$scope.groupIndex].Members.splice(memberIndex, 1);
				$scope.groups.Groups[$scope.groupIndex].membersCount = $scope.groups.Groups[$scope.groupIndex].Members.length;
			
			}

			else{
			
			 	$scope.groups.Groups[$scope.groupIndex].Members.push({"name":emplName,"id":emplId});
			 	$scope.groups.Groups[$scope.groupIndex].membersCount = $scope.groups.Groups[$scope.groupIndex].Members.length;
			
			}
			// for(var i =0;i<$scope.groups.Groups[$scope.groupIndex].Members.length;i++) {
			// 	if($scope.groups.Groups[$scope.groupIndex].Members[i].name == emplName) {
			// 		isNameFound = true;
			// 		isNameFoundIndex = i;
			// 		break;
			// 	}
			// }
			

			// if(!isNameFound) {
			// 	$scope.groups.Groups[$scope.groupIndex].Members.push({"name":emplName});
			// 	$scope.groups.Groups[$scope.groupIndex].membersCount = $scope.groups.Groups[$scope.groupIndex].Members.length;
			// }

			// else {
			// 	$scope.groups.Groups[$scope.groupIndex].Members.splice(isNameFoundIndex, 1);
			// 	$scope.groups.Groups[$scope.groupIndex].membersCount = $scope.groups.Groups[$scope.groupIndex].Members.length;	
			// }
			

	}	

}])