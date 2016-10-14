app.controller('ctrlReport', function($scope, reportFactory){
    
    $scope.data = {};    
    $scope.dataSource = {};
    $scope.predicate = 'total';
    $scope.type = 'outcome';
    $scope.chart = null;
    $scope.block = false;
    $scope.loading = false;
       
    $scope.drawDiagram = function(){
        
        var colors = ['rgb(255,99,71)', 'rgb(144,238,144)', 'rgb(135,206,235)', 'rgb(255,215,0)', 'rgb(128,0,0)', 'rgb(255,165,0)', 'rgb(60,179,113)', 'rgb(0,255,255)', 'rgb(255,192,203)', 'rgb(128,0,128)', 'rgb(0,128,128)', 'rgb(128,128,128)', 'rgb(192,192,192)'];
                
        var result = $scope.data.result;
        
        var labels = [];
        var data = [];
        var bcolors = [];
        
        var colorCount = 0;
        
        for (var i in result) {  
            labels.push(result[i].name);
            data.push(result[i].total);
            bcolors.push(colors[colorCount]);
            
            result[i].color = colors[colorCount];
            
            colorCount++; 
        }        
       
        if ($scope.chart !== null) { 
            
            var datasets = {
                data: data,
                backgroundColor:bcolors,
                hoverBackgroundColor:bcolors,
            }
            
            $scope.chart.data.labels = labels;
            $scope.chart.data.datasets[0] = datasets;            
            $scope.chart.update();
            return;
        } 

        var context = document.getElementById('outcomes').getContext('2d');
        $scope.chart = new Chart(context,{
            type: 'doughnut',          
            data:{
                labels: labels,     
                datasets: [{
                        data: data,
                        backgroundColor: bcolors,
                        hoverBackgroundColor: bcolors
                    }]
            },
             animation:{
                animateScale:true
            },
            options: {
                legend: {
                    display: false,
                  
                }
            },
        })
      
//        document.getElementById('legend').innerHTML = $scope.chart.generateLegend();
        
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