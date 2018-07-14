var inspinia = angular.module('inspinia');
inspinia.controller("groupCtrl", ['$scope', '$rootScope', '$http', '$q', 'API',
	'$state', '$timeout',
	function($scope, $rootScope, $http, $q, API, $state, $timeout) {
		$scope.myNumber = 0;
		API.getAllGroups().then(function(response) {
			if (response.data.result) {
				$scope.groups = response.data;
			}
		})

		$scope.searchEmpl = function(term) {
			$scope.showautocomplete = true;
			API.searchEmployesNames(term).then(function(response) {
				if (response.data.result) {
					$scope.emplNames = response.data.Employees;
				}
			})

		}


		$scope.showautocomplete = false;


		$scope.createGroup = function(groupName, groupDetail) {

			if (groupName && groupName.length > 0) {

				var createGroupObj = {
					"id": parseInt($scope.groups.Groups[$scope.groups.Groups.length - 1].id) +
						1,
					"name": groupName,
					"details": groupDetail,
					"admin": $rootScope.userName || localStorage.getItem("userName"),
					"Members": [],
					"membersCount": "0"
				}

				API.createGroup(createGroupObj).then(function(response) {
					//check if group already exists
					if (response.data.responce) {
						if (responce.data.responce.hasOwnProperty("groupid") && responce.data
							.responce.length > 0) {
							createGroupObj.id = responce.data.responce.groupid;
							// alert("Group Added Successfully!");
							$rootScope.config.rootModalShow = true;
							$rootScope.config.rootModalHeader = "Success";
							$rootScope.config.responseText =
								"Group Added Successfully";
							$rootScope.config.rootModalAction = function() {
								$rootScope.config.rootModalShow = false;
							};
						}
						$scope.groups.Groups.push(createGroupObj)
					} else if (!response.data.responce) {
						// alert(response.data.message)
						$rootScope.config.rootModalShow = true;
						$rootScope.config.rootModalHeader = "Failed";
						$rootScope.config.responseText = response.data.message;
						$rootScope.config.rootModalAction = function() {
							$rootScope.config.rootModalShow = false;
						};
					}

				});


			} else {
				// alert("please enter group Name");
				$rootScope.config.rootModalShow = true;
				$rootScope.config.rootModalHeader = "Failed";
				$rootScope.config.responseText =
					"please enter group Name ";
				$rootScope.config.rootModalAction = function() {
					$rootScope.config.rootModalShow = false;
				};
			}

		}

		$scope.editGroup = function(groupIndex) {
			$scope.groupIndex = groupIndex;
			// $("#addEmplmModal").modal("show");
			$scope.myNumber = 1;
		}

		$scope.addEmpl = function(emplName, emplId) {
			$scope.showautocomplete = false;
			var isMemberFound = false,
				memberIndex = null;

			for (var i = 0; i < $scope.groups.Groups[$scope.groupIndex].Members.length; i++) {
				if ($scope.groups.Groups[$scope.groupIndex].Members[i].id == emplId) {
					memberIndex = i;
					isMemberFound = true;
					break;
				}
			}

			if (isMemberFound) {
				// alert("Member Already Added");
				//$scope.groups.Groups[$scope.groupIndex].Members.splice(memberIndex, 1);
				//$scope.groups.Groups[$scope.groupIndex].membersCount = $scope.groups.Groups[$scope.groupIndex].Members.length;
				$scope.myNumber = 0;
				$rootScope.config.rootModalShow = true;
				$rootScope.config.rootModalHeader = "Failed";
				$rootScope.config.responseText =
					"Member Already added ";
				$rootScope.config.rootModalAction = function() {
					$rootScope.config.rootModalShow = false;
				};
			} else {

				if (!$scope.groups.Groups[$scope.groupIndex].hasOwnProperty("Members")) {
					$scope.groups.Groups[$scope.groupIndex].Members = [];
				}

				$scope.groups.Groups[$scope.groupIndex].Members.push({
					"name": emplName,
					"id": emplId
				});
				$scope.groups.Groups[$scope.groupIndex].membersCount = $scope.groups.Groups[
					$scope.groupIndex].Members.length;

			}

		}

		$scope.removeEmplFromGroup = function(emplId) {

			var isMemberFound = false,
				memberIndex = null;

			for (var i = 0; i < $scope.groups.Groups[$scope.groupIndex].Members.length; i++) {
				if ($scope.groups.Groups[$scope.groupIndex].Members[i].id == emplId) {
					memberIndex = i;
					isMemberFound = true;
					break;
				}
			}

			if (isMemberFound) {

				$scope.groups.Groups[$scope.groupIndex].Members.splice(memberIndex, 1);
				$scope.groups.Groups[$scope.groupIndex].membersCount = $scope.groups.Groups[
					$scope.groupIndex].Members.length;

			}

		}

		setTimeout(function() {
			$scope.saveGroupEmpl = function() {

				var groupId = $scope.groups.Groups[$scope.groupIndex].id;
				var memberIds = '';

				$scope.groups.Groups[$scope.groupIndex].Members.forEach(function(items) {
					memberIds += items.id + ','
				})

				if (memberIds.substr(memberIds.length - 1, 1) == ",") {
					memberIds = memberIds.substr(0, memberIds.length - 1);
				}

				if (memberIds.length > 0) {

					API.updateMembersInGroup({
						id: groupId,
						members: memberIds
					}).then(function(response) {
						if (response.data.responce) {
							// alert("Group Successfully Saved");
							$rootScope.config.rootModalShow = true;
							$rootScope.config.rootModalHeader = "Success";
							$rootScope.config.responseText =
								"Group Successfully Saved";
							$rootScope.config.rootModalAction = function() {
								$rootScope.config.rootModalShow = false;
							};
						} else {
							// alert("Something Went Wrong !");
							$rootScope.config.rootModalShow = true;
							$rootScope.config.rootModalHeader = "Failed";
							$rootScope.config.responseText =
								"Something Went Wrong";
							$rootScope.config.rootModalAction = function() {
								$rootScope.config.rootModalShow = false;
							};
						}

						// $("#addEmplmModal").modal("hide");
						$scope.myNumber = 0;
					})

				}


			}
		}, 1000);


		$scope.deleteGroup = function(groupId) {
			if (!groupId || groupId.length == 0) {
				alert("Group has not been assigned any Id");
				return;
			}

			API.deleteGroup({
				id: groupId
			}).then(function(response) {
				if (response.data.hasOwnProperty("result") && response.data.result) {
					for (var i = 0; i < $scope.groups.Groups.length; i++) {
						if (groupId == $scope.groups.Groups[i].id) {
							$scope.groups.Groups.splice(i, 1);
							// alert("group Deleted Successfully");
							$rootScope.config.rootModalShow = true;
							$rootScope.config.rootModalHeader = "Success";
							$rootScope.config.responseText =
								"group Deleted Successfully";
							$rootScope.config.rootModalAction = function() {
								$rootScope.config.rootModalShow = false;
							};
						}
					}
				} else if (response.data.hasOwnProperty("reason")) {
					// alert(response.data.details);
					$rootScope.config.rootModalShow = true;
					$rootScope.config.rootModalHeader = "Failed";
					$rootScope.config.responseText = response.data.reason;
					$rootScope.config.rootModalAction = function() {
						$rootScope.config.rootModalShow = false;
					};
				} else {
					// alert("Something Wrong with the server");
					$rootScope.config.rootModalShow = true;
					$rootScope.config.rootModalHeader = "Failed";
					$rootScope.config.responseText =
						"Something Wrong with the server";
					$rootScope.config.rootModalAction = function() {
						$rootScope.config.rootModalShow = false;
					};
				}
			})
		}

	}
])
