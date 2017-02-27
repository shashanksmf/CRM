var inspinia = angular.module('inspinia');
inspinia.controller('groupCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout', function ($scope,$rootScope,$http,$q,API,$state,$timeout) {
	
  API.getAllGroups().then(function(groupData){
    $scope.groups = groupData.data;    
  })



	$scope.emplNames = [
		'yves Tankwe',
		'Justin oblava',
		'Gillet gael',
		'fracois LECUYER',
		'Meti mabanza',
		'Pascal Muteb-a-Kal',
		'Costa BasuaKuamba',
		'Jereme KABUYA KALUMBA',
		'Jean-pierre Melice',
		'Job Anderson Kalamba Malenge',
		'Ngolo Mufite'
	]


	$scope.createGroup = function(groupName,groupDetail) {

		if(groupName && groupName.length > 0){

      var createGroupObj = {
        "name": groupName,
        "details": groupDetail,
        "admin": $rootScope.userName || localStorage.getItem("userName"),
        "Members":[],
        "membersCount": "0"
      }
      
      API.addGroup()
			$scope.groups.Groups.push(createGroupObj)
		}
		else{
			alert("please enter group Name");
		}	

	}


	$scope.editGroup = function(groupIndex) {
			$scope.groupIndex = groupIndex;
	}

	$scope.addEmpl = function(emplName) {

			var isNameFound = false, isNameFoundIndex=null;
		
				for(var i =0;i<$scope.groups.Groups[$scope.groupIndex].Members.length;i++) {
					if($scope.groups.Groups[$scope.groupIndex].Members[i].name == emplName) {
						isNameFound = true;
						isNameFoundIndex = i;
						break;
					}
				}
			

			if(!isNameFound) {
				$scope.groups.Groups[$scope.groupIndex].Members.push({"name":emplName});
				$scope.groups.Groups[$scope.groupIndex].membersCount = $scope.groups.Groups[$scope.groupIndex].Members.length;
			}

			else {
				$scope.groups.Groups[$scope.groupIndex].Members.splice(isNameFoundIndex, 1);
				$scope.groups.Groups[$scope.groupIndex].membersCount = $scope.groups.Groups[$scope.groupIndex].Members.length;	
			}
			

	}	

}])