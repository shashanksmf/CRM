var inspinia = angular.module('inspinia');
inspinia.controller('groupCtrl', ['$scope','$rootScope','$http','$q','API','$state','$timeout', function ($scope,$rootScope,$http,$q,API,$state,$timeout) {
	$scope.groups = {
  "Groups": [
    {
      "id": "1",
      "name": "Kinhasa Office Contacts",
      "details": "contacts from Kinhasa Office",
      "admin": "Andreas",
      "Members": [
        {
          "name": "Sherlocks J",
          "department": "Comp",
          "hireDate": "12-10-2014",
          "dob": "10-12-1988",
          "gender": "Male",
          "homeAddress": "New homes.404, Drive Throu",
          "email": "sherlocks@gmail.com",
          "profilePic": "cdn/images/user_1.jpg",
          "phone": "899889895"
        },
        {
          "name": "diana@gmail.com",
          "department": "U2@1234",
          "hireDate": "a",
          "dob": "a",
          "gender": "a",
          "homeAddress": "a",
          "email": "a",
          "profilePic": "a",
          "phone": "a"
        }
      ],
      "membersCount": "2",
      "createdOn": "14-02-2017"
    },
    {
      "id": "2",
      "name": "Back Office",
      "details": "Just USD",
      "admin": "Andreas",
      "Members": [
        {
          "name": "Sherlocks J",
          "department": "Comp",
          "hireDate": "12-10-2014",
          "dob": "10-12-1988",
          "gender": "Male",
          "homeAddress": "New homes.404, Drive Throu",
          "email": "sherlocks@gmail.com",
          "profilePic": "cdn/images/user_1.jpg",
          "phone": "899889895"
        },
        {
          "name": "Diana P",
          "department": "Engineering",
          "hireDate": "12-05-2015",
          "dob": "10-12-1978",
          "gender": "Female",
          "homeAddress": "Drives D-420, New York",
          "email": "diana@gmail.com",
          "profilePic": "cdn/images/user_2.jpg",
          "phone": "8985858696"
        },
        {
          "name": "diana@gmail.com",
          "department": "U2@1234",
          "hireDate": "a",
          "dob": "a",
          "gender": "a",
          "homeAddress": "a",
          "email": "a",
          "profilePic": "a",
          "phone": "a"
        }
      ],
      "membersCount": "2",
      "createdOn": "14-02-2017"
    }
  ]
}

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

		if(groupName.length > 0){
			$scope.groups.Groups.push({
				"name": groupName,
     			"details": groupDetail,
      			"admin": $rootScope.userName,
  				"membersCount": "0"
			})
		}
		else{
			alert("please enter group Name");
		}	

	}


	$scope.editGroup = function(groupIndex) {
			$scope.groupIndex = groupIndex;
	}

	$scope.addEmpl = function(emplName) {

			if(!$scope.groups.Groups[$scope.groupIndex].checked) {
				$scope.groups.Groups[$scope.groupIndex].checked = true;
				$scope.groups.Groups[$scope.groupIndex].Members.push({"name":emplName});
				$scope.groups.Groups[$scope.groupIndex].membersCount = $scope.groups.Groups[$scope.groupIndex].Members.length; 	
			}

			else {
				$scope.groups.Groups[$scope.groupIndex].checked = false;
				var isEmplFound = false;
				var emplFoundIndex;	
				$scope.groups.Groups[$scope.groupIndex].Members.forEach(function(empl,index){
					if(empl.name == emplName){
						isEmplFound = true;
						emplFoundIndex = index;
					}
				})
				$scope.groups.Groups[$scope.groupIndex].Members.splice(emplFoundIndex, 1);
				$scope.groups.Groups[$scope.groupIndex].membersCount = $scope.groups.Groups[$scope.groupIndex].Members.length;	
				
			}
			

	}	

}])