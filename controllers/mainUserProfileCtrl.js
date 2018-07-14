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
        $scope.mainUserInfo = response.data.details;
        $scope.getUserMailChimpDetails();
      }
    });

    $scope.getUserMailChimpDetails = function() {

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



    // $scope.createListBtn = function() {
    //   var apiKey = $scope.createListApiKey;
    //   var listName = $scope.createListName;
    //   API.creatMailChimpList({
    //     userId: userId,
    //     apiKey: apiKey,
    //     listName: listName
    //   }).then(function(response) {
    //     console.log(response);
    //     if (response.data.result) {
    //       // alert("List Created Successfully");
    //       $rootScope.config.rootModalShow = true;
    //       $rootScope.config.rootModalHeader = "Success";
    //       $rootScope.config.responseText =
    //         "List Created Successfully";
    //       $rootScope.config.rootModalAction = function() {
    //         $rootScope.config.rootModalShow = false;
    //       };
    //       $scope.getUserMailChimpDetails();
    //     } else {
    //       // alert("Something Wrong with the server");
    //       $rootScope.config.rootModalShow = true;
    //       $rootScope.config.rootModalHeader = "Failed";
    //       $rootScope.config.responseText =
    //         "Something went Wrong with the Server";
    //       $rootScope.config.rootModalAction = function() {
    //         $rootScope.config.rootModalShow = false;
    //       };
    //     }
    //   });
    //
    // }



  }
]);
