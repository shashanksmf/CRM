var inspinia = angular.module('inspinia');
inspinia.controller('transactionListCtrl', ['$scope', '$rootScope', '$http',
  '$q',
  '$timeout', '$state', '$stateParams', 'crmconfig', 'API',
  function($scope, $rootScope, $http, $q, $timeout, $state, $stateParams,
    crmconfig, API) {
    var userId = localStorage.getItem("userId");
    $state.go('dashboards.transactions', {
      userid: userId,
    });
    $scope.viewTransaction = false;

    $scope.goBack = function() {
      $state.reload();
    }
    API.transactionList(userId).then(function(response) {
      if (response.data.result) {
        $scope.transactionDetails = response.data.details;

      } else if (response.data.reason) {
        // alert("API Key is invalid");
        $rootScope.config.rootModalShow = true;
        $rootScope.config.rootModalHeader = "Failed";
        $rootScope.config.responseText = "No Records Found";
        $rootScope.config.rootModalAction = function() {
          $rootScope.config.rootModalShow = false;
        };
      }


    });

    $scope.viewTransactionDetails = function(dt) {
      var tId = dt.id;
      var userId = dt.userId;
      API.viewTransactionDetails(tId, userId).then(function(response) {
        $scope.viewTransaction = true;
        if (response.data.result) {

          $scope.transactionDetails = response.data.details;

        } else if (response.data.reason) {
          $scope.viewTransaction = false;
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Failed";
          $rootScope.config.responseText = "No Records Found";
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
          };
        }

      });
    }
  }
]);
