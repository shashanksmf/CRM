inspinia.directive('chatbox', function() {
  return {
  	scope:{
  		chat:'=',
  		parentindex:'@',
  		closechatwindow:'&'
  	},	
    restrict: 'E',
    templateUrl: 'Directives/chatbox.html',
    link: function(scope, elem, attr,$timeout) { 
    	setTimeout(function(){ 
    		scope.$apply(function(){
    			var chatBoxHt = elem.find('div.msg_container_base')[0];
    			chatBoxHt.scrollTop = chatBoxHt.scrollHeight;
    			console.log(chatBoxHt);		
    		})
    		
    	}, 1000);
    	
    	 
    },
  };
});