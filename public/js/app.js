
var app = angular.module('app', []);

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


