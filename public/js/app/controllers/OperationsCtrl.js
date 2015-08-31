app.controller('OperationsCtrl', function($scope, $http, CSRF_TOKEN){
    
    $scope.operations = [];
    
    $scope.init = function(){
        console.log('hello');
        
        $http.get('/operations/getoutcomes').success(function(data){            
            $scope.operations = data;
        })
        
    }
    
    $scope.init();
    
})


