
var app = angular.module('app', []);

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
    
    $scope.showItems = function(){
        $scope.show = $scope.show == false ? true : false;
    };
    
    
    
})


