var inspinia = angular.module('inspinia');
inspinia.controller('mailChimpCreateListCtrl', ['$scope', '$rootScope', '$http',
  '$q',
  '$timeout', '$state', '$stateParams', 'crmconfig', 'API',
  function($scope, $rootScope, $http, $q, $timeout, $state, $stateParams,
    crmconfig, API) {
    $scope.createListApiKey = '';
    $scope.activeTab = 1;
    $scope.prevclick = function() {
      if ($scope.activeTab > 1) {
        $scope.activeTab--;
      } else {
        $scope.activeTab = 1;
      }
    }
    $scope.nextclick = function() {
      if ($scope.activeTab < 3) {
        $scope.activeTab++;
      } else {
        $scope.activeTab = 3;
      }
    }

    $scope.createCustomListBtn = function(typeofList) {
      var type = typeofList;
      var userId = localStorage.getItem("userId");
      var name = $scope.createListName;
      API.createCustomList({
        userId: userId,
        type: type,
        name: name
      }).then(function(response) {
        if (response.data.result) {
          // alert("API Key Addedd Successfully");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Success";
          $rootScope.config.responseText =
            "List created Successfully";
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
          };
          // $scope.getUserMailChimpDetails();
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

    }


    $scope.createListBtn = function(typeofList) {
      var type = typeofList;
      $scope.isEdit = false;
      var userId = localStorage.getItem("userId");
      var apiKey = $scope.createListApiKey;
      var name = $scope.createListName;
      var company = $scope.createListCompany;
      var address1 = $scope.createListAddress1;
      var address2 = $scope.createListAddress2;
      var city = $scope.createListCity;
      var state = $scope.createListState;
      var zip = $scope.createListZip;
      var country = $scope.createListCountry;
      var phone = $scope.createListPhone;
      var permission_reminder = $scope.createListPermissionReminder;
      var from_name = $scope.createListfrom_name;
      var from_email = $scope.createListfrom_email;
      var subject = $scope.createListSubject;
      var language = $scope.createListLanguage;
      var email_type_option = $scope.createListemail_type_option;
      API.creatMailChimpList({
        userId: userId,
        apiKey: apiKey,
        name: name,
        type: type,
        company: company,
        address1: address1,
        address2: address2,
        city: city,
        state: state,
        zip: zip,
        country: country,
        phone: phone,
        permission_reminder: permission_reminder,
        from_name: from_name,
        from_email: from_email,
        subject: subject,
        language: language,
        email_type_option: email_type_option
      }).then(function(response) {
        // console.log("Here I am REsponse");
        console.log(response);
        if (response.data.result) {
          // alert("API Key Addedd Successfully");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Success";
          $rootScope.config.responseText =
            "List created Successfully";
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
          };
          // $scope.getUserMailChimpDetails();
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

    }


  }
]);
