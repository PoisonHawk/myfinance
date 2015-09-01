app.controller('OperationsCtrl', function($scope, $http, CSRF_TOKEN){
    
    $scope.operations = [];
    
    $scope.init = function(){
               console.info('init');
        $http.get('/operations/getoutcomes').success(function(data){  
            console.log(data);
            $scope.operations = data;
        })
        
    };
    
    $scope.total = function(){
        console.info('total');
        
        var total = 0;        
        var len = $scope.operations.length;
           
        if (len === 0) {
            return;
        }
        
        var index;
        for (index = 0; index<len; index++) {        
            console.log('amount: '+$scope.operations[index].amount);
            total += Number($scope.operations[index].amount);
            console.log('total: '+total);
        }

        return total;
    }
    
    $scope.init();
    
})


