
var xhReq = new XMLHttpRequest();
      //xhReq.open("GET", "/token", false);
      //xhReq.send(null);

var app = angular.module('app', ['ngMessages']);

app.constant('CSRF_TOKEN', xhReq.responseText);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
  });
  
app.controller('operationCtrl', function($scope, $http){
    
    $scope.cancel = function(){
        var url='/operations/'+$scope.operationId+'/cancel';
        $http.get(url).success( function(response) {
                          
                          if (response.status == 'ok') {
                              $scope.active = 0;                              
                          }
                          
                        });
    }
})


app.controller('categoryCtrl', function($scope){
    
    $scope.show = false;
    $scope.parent = null;
    
    $scope.showItems = function(id){
        
        console.log(id);
        
        if ($scope.parent == null) {
            $scope.parent = id;
        } else if ($scope.parent == id) {
            $scope.parent = null;
        } else {
            $scope.parent = id;
        }
        
//        $scope.parent = $scope.parent == null ? id : null; 
      
    };
        
})


