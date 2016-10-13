app.controller('ctrlReport', function($scope, reportFactory){
    
    $scope.data = {};    
    $scope.dataSource = [];
    $scope.predicate = 'total';
    $scope.type = 'outcome';
    $scope.chart = null;
    $scope.block = false;
    $scope.loading = false;
       
    $scope.drawDiagram = function(){
        var colors = ['Tomato', 'LightGreen', 'SkyBlue', 'Gold', 'maroon', 'orange', 'MediumSeaGreen', 'aqua', 'pink', 'purple', 'teal', 'gray', 'silver'];
        
        var result = $scope.data.result;
        $scope.dataSource = [];
        
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
                
        if ($scope.chart !== null) {            
            $scope.chart.destroy();           
        } 
      
        $scope.chart = new Chart(context).Doughnut($scope.dataSource, {
            animation: true,
            animationSteps: 30,
            animationEasing: 'linear',
            showScale: true,
            responsive: true, 
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
        });   
        document.getElementById('legend').innerHTML = $scope.chart.generateLegend();
        
    };
    
    $scope.getReport = function(type){
        
        if ($scope.block) {
            return;
        }
        
        $scope.loading = true;
        $scope.block = true;
        reportFactory.outcome(type)
                .success( function(data) {                                                    
                        $scope.data = data;                          
                        $scope.loading = false;
                        $scope.drawDiagram(); 
                        $scope.block = false;
                        
                })
                .error(function(){
                    $scope.loading = false;
                });       
    };   
    
    $scope.getReport('outcome');
    
})