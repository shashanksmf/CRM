var inspinia = angular.module('inspinia');
inspinia.controller('mailChimpViewListCtrl', ['$scope', '$rootScope', '$http',
  '$q',
  '$timeout', '$state', '$stateParams', 'crmconfig', 'API',
  function($scope, $rootScope, $http, $q, $timeout, $state, $stateParams,
    crmconfig, API) {
    // console.log("mailchimpveiw controller");
    // $scope.isUserProfileEdit = false;
    var userId = localStorage.getItem("userId");

    // $scope.apiKey = "apikey";
    API.viewMailChimpList(userId).then(function(response) {
      if (response.data.result) {
        $scope.mailChimpDetails = response.data.details;
        $scope.select = function(i) {
          $scope.listId = $scope.mailChimpDetails[i].listid;
          $state.go('dashboards.mailChimpEditList', {
            listid: $scope.listId,
          });
        };
      } else if (response.data.reason) {
        // alert("API Key is invalid");
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

    });



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
          $state.reload()
            // $scope.getUserMailChimpDetails();
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

  }
]);
