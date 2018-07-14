var inspinia = angular.module('inspinia');
inspinia.controller('mailChimpEditListCtrl', ['$scope', '$rootScope', '$http',
  '$q',
  '$timeout', '$state', '$stateParams', 'crmconfig', 'API',
  function($scope, $rootScope, $http, $q, $timeout, $state, $stateParams,
    crmconfig, API) {
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
    var listId = $stateParams.listid;
    API.editMailChimpList(listId).then(function(response) {
      console.log("editMailChimpDetails", response);
      if (response.data.result) {
        // alert("Record Deleted Successfully");
        $scope.mailChimpListInfo = response.data.details[0];

        $scope.createListApiKey = $scope.mailChimpListInfo.APIKEY;
        $scope.isEdit = true;
        $scope.createListName = $scope.mailChimpListInfo.listname;
        $scope.createListState = $scope.mailChimpListInfo.state;
        $scope.createListZip = parseInt($scope.mailChimpListInfo.zip);
        $scope.createListCity = $scope.mailChimpListInfo.city;
        $scope.createListAddress1 = $scope.mailChimpListInfo.address1;
        $scope.createListCompany = $scope.mailChimpListInfo.company;
        $scope.createListCountry = $scope.mailChimpListInfo.country;
        $scope.createListPhone = parseInt($scope.mailChimpListInfo.phone);
        $scope.createListPermissionReminder = $scope.mailChimpListInfo.permission_reminder;
        $scope.createListfrom_name = $scope.mailChimpListInfo.from_name;
        $scope.createListfrom_email = $scope.mailChimpListInfo.from_email;
        $scope.createListSubject = $scope.mailChimpListInfo.subject;
        $scope.createListLanguage = $scope.mailChimpListInfo.language;
        $scope.createListemail_type_option = $scope.mailChimpListInfo.email_type_option;

        // $rootScope.config.rootModalShow = true;
        // $rootScope.config.rootModalHeader = "Success";
        // $rootScope.config.responseText =
        //   "Record edited Successfully";
        // $rootScope.config.rootModalAction = function() {
        //   $rootScope.config.rootModalShow = false;
        // };
        // $state.reload()
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
    $scope.updateListBtn = function() {
      // console.log("Edit");
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
      API.updateMailChimpList(listId, {
        userId: userId,
        apiKey: apiKey,
        name: name,
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
            "List updated Successfully";
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
          };
          $state.reload();
          // $scope.getUserMailChimpDetails();
        } else if (response.data.reason) {
          // alert("API Key is invalid");
          $rootScope.config.rootModalShow = true;
          $rootScope.config.rootModalHeader = "Failed";
          $rootScope.config.responseText = response.data.reason;
          $rootScope.config.rootModalAction = function() {
            $rootScope.config.rootModalShow = false;
            $state.reload();
          };
        }
      });
    }
  }
]);
