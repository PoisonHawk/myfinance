app.controller('ctrlReport', function($scope, $http){
    
    $scope.data = {};    
    $scope.dataSource = [];
    $scope.predicate = 'total';
       
    $http.get('/reportoutcome/outcome').success( function(response) {                                                    
                          $scope.data = response; 
                          console.log($scope.data); 
                          $scope.drawDiagram(); 
                    });
   
    
    $scope.drawDiagram = function(){
        var colors = ['red', 'green', 'yellow', 'blue', 'maroon', 'orange', 'olive', 'aqua', 'pink', 'purple', 'teal', 'gray', 'silver'];
        
        var result = $scope.data.result;
                          
        var count = 0;
        for (var i in result) {
            
            var obj = {};
            obj.label = result[i].name;
            obj.value = result[i].total;
            obj.color = colors[count];

            $scope.dataSource.push(obj);
            count ++;
        }
        
        var context = document.getElementById('outcomes').getContext('2d');
        var skillsChart = new Chart(context).Doughnut($scope.dataSource , {
            animateScale: true
        });
    }
    
})