var inspinia = angular.module('inspinia');
inspinia.controller('mainUserProfileCtrl', ['$scope', '$rootScope', '$http',
  '$q', 'API', '$state', '$timeout', '$stateParams',
  function($scope, $rootScope, $http, $q, API, $state, $timeout,
    $stateParams) {

    $scope.isUserProfileEdit = false;
    $scope.editRow = null;

    var userId = $rootScope.userId || localStorage.getItem("userId");
    API.getUserInfo(userId).then(function(response) {
      if (response.data.result) {
        $scope.mainUserInfo = response.data.reason;
        $scope.getUserMailChimpDetails();
      }
    });

    $scope.getUserMailChimpDetails = function() {
      API.getUserMailChimpDetails(userId).then(function(response) {
        console.log("DATA", response.data.reason);
        if (response.data.result) {
          $scope.mailChimpDetails = response.data.reason;
        }
      });
    }

    $scope.saveMailChimpDetails = function(index, dt) {
      $scope.editRow = false;
      API.saveMailChimpDetails({
        dt
      }).then(function(response) {
        console.log("saveMailChimpDetails", response);
        if (response.data.result) {
          // alert("MailChimp Details Saved Successfully");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Success";
          $rootScope.config.responseText =
            "MailChimp Details Saved Successfully";
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
          };
          $scope.getUserMailChimpDetails();
        } else if (response.data.errorType && response.data.errorType ==
          "listId") {
          // alert("List Id is invalid");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Failed";
          $rootScope.config.responseText =
            "List Id is invalid";
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
      });
    }

    $scope.deleteMailChimpDetails = function(dt) {
      API.deleteMailChimpDetails({
        dt
      }).then(function(response) {
        console.log("deleteMailChimpDetails", response);
        if (response.data.result) {
          // alert("Record Deleted Successfully");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Success";
          $rootScope.config.responseText =
            "Record deleted Successfully";
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
          };
          $scope.getUserMailChimpDetails();
        } else {
          // alert("Something Wrong with the server");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Failed";
          $rootScope.config.responseText =
            "Something Wrong with the Server";
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
          };
        }
      });
    }

    $scope.saveMainUserProfile = function() {
      $scope.isUserProfileEdit = false;
      var userInfoObj = $scope.mainUserInfo;
      API.updateMainUserProfile(userInfoObj).then(function(response) {
        console.log("update main user profile response", response);
        if (response.data.result) {

        }
      });
    }

    $scope.allowEditProfile = function() {
      $scope.isUserProfileEdit = true;
    }

    $scope.allowEditMailChimpDetails = function(index) {
      $scope.editRow = index;
    }

    $scope.addMailChimpIdBtn = function() {
      var apiKey = $scope.addMailChimpIdApiKey;
      API.addMailChimpId({
        userId: userId,
        apiKey: apiKey
      }).then(function(response) {
        console.log(response);
        if (response.data.result) {
          // alert("API Key Addedd Successfully");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Success";
          $rootScope.config.responseText =
            "API key Added Successfully";
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
          };
          $scope.getUserMailChimpDetails();
        } else if (response.data.errorType && response.data.errorType ==
          "apiKey") {
          // alert("API Key is invalid");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Failed";
          $rootScope.config.responseText =
            "API key is invalid";
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
      });

    }

    $scope.addListBtn = function() {
      var apiKey = $scope.addListApiKey;
      var listId = $scope.addListId;
      var listName = $scope.addListName;
      API.addMailChimpList({
        userId: userId,
        apiKey: apiKey,
        listId: listId,
        listName: listName
      }).then(function(response) {
        console.log(response);
        if (response.data.result) {
          // alert("List Addedd Successfully");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Success";
          $rootScope.config.responseText =
            "List added Successfully";
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
          };
          $scope.getUserMailChimpDetails();
        } else if (response.data.errorType && response.data.errorType ==
          "listId") {
          // alert("Invalid List Details");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Failed";
          $rootScope.config.responseText = "Invalid List Details";
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
          };
        } else {
          // alert("Something Wrong with the server");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Failed";
          $rootScope.config.responseText =
            "Something Wrong with the Server";
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
          };
        }
      });

    }

    $scope.createListBtn = function() {
      var apiKey = $scope.createListApiKey;
      var listName = $scope.createListName;
      API.creatMailChimpList({
        userId: userId,
        apiKey: apiKey,
        listName: listName
      }).then(function(response) {
        console.log(response);
        if (response.data.result) {
          // alert("List Created Successfully");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Success";
          $rootScope.config.responseText =
            "List Created Successfully";
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
          };
          $scope.getUserMailChimpDetails();
        } else {
          // alert("Something Wrong with the server");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Failed";
          $rootScope.config.responseText =
            "Something went Wrong with the Server";
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
          };
        }
      });

    }



  }
]);
