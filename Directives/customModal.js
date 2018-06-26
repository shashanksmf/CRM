inspinia.directive('custommodal', function($rootScope) {
  return {
    restrict: 'E',
    scope: {
      isshow: '=',
      action: '&',
      header: '=',
      responsetext: '='
    },
    templateUrl: 'Directives/customModal.html',
    link: function(scope, elem, attrs, $rootScope) {
      console.log("Hey", scope);

    }

  };
});
