app.controller('ctrlReport', function($scope, reportFactory){
    
    $scope.data = {};    
    $scope.dataSource = {};
    $scope.predicate = 'total';
    $scope.type = 'outcome';
    $scope.chart = null;
    $scope.block = false;
    $scope.loading = false;
    $scope.ctx = null;
    $scope.activePeriod = null;
    $scope.periods = [];

    $scope.makePeriod = function(period){

        var months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];

        var  date = new Date(new Date().getFullYear(), new Date().getMonth(), 1);

       for (var i=1; i<=12; i++) {

            var m = date.getMonth();
            var y = date.getFullYear();

            var month =  (m+1) < 10 ? '0'+(m+1) : m+1;

            var fromDate = y +'-'+ month + '-01';

            var toDate = y + '-' + month + '-' +date.getDaysInMonth();

            $scope.periods.push({
                name: months[m] + ' ' + y,
                from: fromDate,
                to: toDate,
            });

            date.setMonth(m-1);
        }

        $scope.activePeriod = $scope.periods[0];

    };

    $scope.changePeriod = function(period){
        $scope.activePeriod = period;
        $scope.getReport($scope.type);

    };

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
       
        if ($scope.ctx == null) {        
            $scope.ctx = document.getElementById('outcomes').getContext('2d');
        }  
        
        if($scope.chart != null) {
           
            $scope.chart.data.labels = labels;
            $scope.chart.data.datasets[0] = {
                        data: data,
                        backgroundColor: bcolors,
                        hoverBackgroundColor: bcolors
                    };
                    
            $scope.chart.update();
            return;
        }

        $scope.chart = new Chart($scope.ctx,{
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
                cutoutPercentage: 70,
                legend: {
                    display: false,
                  
                }
            },
        })


        
    };
    
    $scope.getReport = function(type){
        
        if ($scope.block) {
            return;
        }

        $scope.loading = true;
        $scope.block = true;
        reportFactory.outcome(type, $scope.activePeriod.from, $scope.activePeriod.to)
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

    $scope.makePeriod();

    $scope.getReport('outcome');
    
})