app.controller('OperationsCtrl', function($scope, $http, CSRF_TOKEN){
    
    $scope.operations = [];
    $scope.date = {
        from: null,
        to: null
    };
    $scope.loading = false;
    $scope.error = false;
    $scope.message = null;
    $scope.isPeriod = false;
    $scope.toDate = null;
    $scope.fromDate = null;
    
    $scope.init = function(){
        
        $scope.error = false;
        $scope.makePeriod();               
        $scope.makeRequest();  
        
    };
    
    $scope.report = function(period){
        
        $scope.isPeriod = false;
        $scope.makePeriod(period);
        $scope.makeRequest();
        
    }
    
    $scope.period = function(){
        $scope.isPeriod = true;
        
    }
    
    $scope.makeRequest = function(){
        $scope.load = true;
        $scope.error = false;
        $http.get('/operations/getoutcomes?from='+$scope.date.from+'&to='+$scope.date.to)
                .success(function(data){
                  
                    $scope.operations = data; 
                    
                })
                .error(function(){
                    $scope.error = true;
                    $scope.message = 'Ошибка получения данных';
                    
                })
                
                $scope.load = false;
    }
    
    $scope.makePeriod = function(period){
     
        var now, from, to;
        
        now = new Date();
        from = new Date();
        to = new Date(now.setDate(Number(now.getDate())+1));
  
        if (typeof period !== 'undefined') {
        
            from.setDate(Number(now.getDate())- Number(period));
        
        }
               
        //fromDate
        var frYear = from.getFullYear();
        
        var frMonth = Number(from.getMonth())+1;
        if (frMonth<10) {frMonth = '0'+frMonth};
        
        var frDay = from.getDate();        
        if (frDay<10) {frDay = '0'+frDay};
        
        $scope.date.from = frYear+'-'+frMonth+'-'+frDay;        
          
        //toDate
        var toYear = to.getFullYear();
                
        var toMonth = Number(to.getMonth())+1;
        if (toMonth<10) {toMonth = '0'+toMonth};
        
        var toDay = to.getDate();        
        if (toDay<10) {toDay = '0'+toDay};
        
        $scope.date.to = toYear+'-'+toMonth+'-'+toDay;
        
    }
    
    
    
    $scope.total = function(){
                
        var total = 0;        
        var len = $scope.operations.length;
           
        if (len === 0) {
            return;
        }
        
        var index;
        for (index = 0; index<len; index++) {                  
            total += Number($scope.operations[index].amount);
        }

        return total.toFixed(2);
    }
    
    $scope.init();
    
})


