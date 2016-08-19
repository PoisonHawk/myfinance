app.controller('categoryCtrl', function($scope, $http, CSRF_TOKEN){
    
    $scope.show = false;
    $scope.parent = null;    
    
    $scope.showItems = function(id){
                
        if ($scope.parent == null) {
            $scope.parent = id;
        } else if ($scope.parent == id) {
            $scope.parent = null;
        } else {
            $scope.parent = id;
        }        

    };
    
    $scope.remove = function(id){
        
        var confirmRemove = confirm('Вы действительно хотите удалить категорию?');
        
        if (confirmRemove) {           
            
            $http({
                method: 'POST',
                data: {_method: 'DELETE', _token: CSRF_TOKEN},                
                url: '/category/'+id,
            })
                    .success(function(data){
//                        console.log(data);
                        alert('Категория удалена');
                        location.reload();
                    })
                    .error(function(data){
//                        console.log(data);
                        alert('Невозможно удалить данную категорию. Попробуйте позже');
                    })
        }
    };
        
})
