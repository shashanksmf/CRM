var inspinia = angular.module('inspinia');
inspinia.controller('homeCtrl', ['$scope','$http','$q', function ($scope,$http,$q) {
  
    $scope.config={showUserPopUp:false,showCompanyDetailPopUp:false};
    $scope.tags =[];
    $scope.tagSearchedItems = [];
    $scope.propertyName = '';
    $scope.reverse = true;
    $scope.showAutoComplete = false;
    var autoComplete=[];
    $scope.searchInput = '';
    $scope.emplId = [];
    $scope.tagSearchedDetails = [];
    var baseHttpUrl = '/angularphp/template/Angular_Full_Version/Service';
        
    
    
    // code to load employee tabel
    $http({
        method: 'GET',
        dataType: "jsonp",
        url: baseHttpUrl+'/GetEmplData.php'
    })
        .then(function successCallback(response) {
            response.data.Employees.forEach(function (empl) {
                    var splitRating = empl.ratings.split(".");
                    var ratingARR=[];
                    for(var i=0;i<parseInt(splitRating[0]);i++){
                        ratingARR.push("full");
                    }
                    if(parseInt(splitRating[1])!==0){
                        ratingARR.push("half");
                    }
                    if(ratingARR.length<6){
                        for(var j=ratingARR.length+1;ratingARR.length<5;j++){
                            ratingARR.push("empty");
                        }
                    }
                    empl.emplRatings = ratingARR;
                })
    
        $scope.employees = response.data.Employees;
        
        $scope.loadTags = function(query) {
                
            autoComplete = [{"id":"2","name":"Bob Robson","title":"Engineer","industry":"Development","location":"Chicago","ratings":"5.0"},{"id":"3","name":"John Boo","title":"Investor","industry":"Health tech","location":"London","ratings":"5.0"},{"id":"4","name":"Bob Kennedy","title":"Director","industry":"Finance","location":"Madrid","ratings":"4.5"}];

            var TagsArr = [];
            $scope.employees.forEach(function(empl){
                TagsArr.push({"text":empl.name,"location":empl.location});
            })
            
            return TagsArr;
        
        };
    
    }, function errorCallback(response) {
    });
    
    
    
   
    // code for sorting on columnNames
    $scope.sortBy = function(propertyName) {
        $scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
        $scope.propertyName = propertyName;
    };
    
    //code when user clicks on any User then modal comes up and show userDetail
    $scope.showUserDetail = function(emplId){
        
        var emplId = emplId || 1;
        $http({
                method: 'GET',
                dataType: "jsonp",
                url: baseHttpUrl +'/GetUserData.php?id='+emplId
                })
        
            .then(function successCallback(response) {
                $scope.userDetails = response.data.Users[0];
            }, function errorCallback(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
          });
            
            $scope.config.showUserPopUp = true;
     
    }
    
    //code when user clicks on any Company then modal comes up and show CompanyDetail
    $scope.showCompanyDetail = function(companyId){
        
        $scope.config.showUserPopUp = false;
        var companyId = companyId || 1;
        
        $http({
                method: 'GET',
                dataType: "jsonp",
                url: baseHttpUrl +'/GetCompanyData.php?id='+companyId
                })
            .then(function successCallback(response) {
                $scope.companyDetails = response.data.Users[0];
            }, function errorCallback(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
          });
        
        $scope.config.showCompanyDetailPopUp = true;
    
    }
    
    
    //code for searching employee details in database
    $scope.seachText = function(Text){

        var tags='';
         $scope.tagSearchedItems.forEach(function(Item){
               tags += ' '+ Item.searchItem;
        })

         Text += tags;
        $scope.showAutoComplete = true;
        
        $http({
                method: 'GET',
                dataType: "jsonp",
                url: baseHttpUrl +'/GetEmplSearchAI.php?term='+Text    
                })
        
            .then(function successCallback(response) {
                console.log("search response",response);
                $scope.listdata = [];
              
                $scope.listdata = response.data.Employees;
                
            
            }, function errorCallback(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
            
            
        
    }
    
    //autoCompleteList
    $scope.autoCompleteListItem = function(emplSearchItem,emplId,emplObj){
        
        if(emplId && emplId.length>0){
            $scope.tagSearchedItems.push({"searchItem":emplSearchItem,"emplID":emplId});
            $scope.tagSearchedDetails = [];
            $scope.tagSearchedDetails.push(emplObj)
            $scope.searchInput = '';
            $scope.showAutoComplete = false;
            return;
        }
             
        var isitemFound = false;
       
        if($scope.tagSearchedItems.length >=1){
            $scope.tagSearchedItems.forEach(function(Item){
                if(Item.searchItem == emplSearchItem){
                    isitemFound = true;
                }  
            })
            if(!isitemFound){
                pushItemToList();
            }
        } else {   
            pushItemToList();
        }
        
       function pushItemToList(){
            
               var tagSearchHistory = ''
               $scope.tagSearchedItems.forEach(function(Item){
                  tagSearchHistory += Item.searchItem +' ' ;   
                })
                var originalSearchItem =  emplSearchItem;
                emplSearchItem = tagSearchHistory + emplSearchItem;
                $scope.tagSearchedItems.push({"searchItem":originalSearchItem,"emplID":emplId});
                $scope.tagSearchedItems[$scope.tagSearchedItems.length-1].searchId=[];
                var searchedData = getEmplSearch(emplSearchItem);
               
                //call to http if search is not found
                $scope.tagSearchedDetails = [];
                searchedData.then(function(greeting) {
                greeting.forEach(function(greet){
                $scope.tagSearchedDetails.push(greet)
                $scope.tagSearchedItems[$scope.tagSearchedItems.length-1].searchId.push(greet.id);
                console.log("$scope.tagSearchedItems",$scope.tagSearchedItems)
                })
            })  
        }
        
        $scope.searchInput = '';
        $scope.showAutoComplete = false;
        
    }
    
    
     
    
    //get employee search list
      function getEmplSearch(term){
         var deferred = $q.defer();
            $http({
                method: 'GET',
                dataType: "jsonp",
                url: baseHttpUrl + '/GetEmplSearchAI.php?term='+term    
                })
        
            .then(function successCallback(response) {
              //ss\ deferred.resolve(response)
                  response.data.Employees.forEach(function(empl){
                    
                    var splitRating = empl.ratings.split(".");
                    var ratingARR=[];
                    for(var i=0;i<parseInt(splitRating[0]);i++){
                        ratingARR.push("full");
                    }
                    if(parseInt(splitRating[1])!==0){
                        ratingARR.push("half");
                    }
                    if(ratingARR.length<6){
                        for(var j=ratingARR.length+1;ratingARR.length<5;j++){
                            ratingARR.push("empty");
                        }
                    }
                    empl.emplRatings = ratingARR;
                })
                
                
                deferred.resolve(response.data.Employees)
                //return response.data.Employees;
            }, function errorCallback(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    
        return deferred.promise;
    }
    
    
    //delete Searched tag
    $scope.deleteSearchedTag = function(tag,tagIndex){
       
        var tagsInSearchedItems ='';
      
        $scope.tagSearchedItems.splice(tagIndex,1);
        $scope.tagSearchedItems.forEach(function(items,tagSearchDetailsIndex){
            tagsInSearchedItems += items.searchItem + ' ';
        })
         var searchedData = getEmplSearch(tagsInSearchedItems);
         
            $scope.tagSearchedDetails = [];
                searchedData.then(function(greeting) {
                greeting.forEach(function(greet){
                $scope.tagSearchedDetails.push(greet)
                })
            })
                
         if($scope.tagSearchedItems.length==0){
             $scope.tagSearchedDetails = [];
         }
    }
    
    
    
    
    
    
}]);



inspinia.filter('filterByTags', function () {
  return function (items, tags) {
    var filtered = [];
    (items || []).forEach(function (item) {
      var matches = tags.some(function (tag) {
        return (item.data1.indexOf(tag.text) > -1) ||
               (item.data2.indexOf(tag.text) > -1);
      });
      if (matches) {
        filtered.push(item);
      }
    });
    return filtered;
  };
});

inspinia.directive('myEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.myEnter);
                });

                event.preventDefault();
            }
        });
    };
});