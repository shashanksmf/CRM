inspinia.directive('chatbox', function() {
  return {
 	
    restrict: 'E',
    templateUrl: 'Directives/chatbox.html',
    link: function(scope, elem, attr,$timeout) { 
    	
      var chatBoxHt = elem.find('div.msg_container_base')[0];
       
      scope.scrollDown = function() {    
        setTimeout(function(){ 
      		scope.$apply(function(){
      			chatBoxHt.scrollTop = chatBoxHt.scrollHeight;
      			console.log(chatBoxHt);		
      		})
      		
      	}, 500);
    	}
      
      scope.scrollDown();

    	 
    },
  };
});