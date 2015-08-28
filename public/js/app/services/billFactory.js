app.factory('billFactory', function($http, CSRF_TOKEN){
    return {
        getBills: function(){
            return $http.get('/bills');
        },
        
        addBill: function(data){
            return $http.post('/bills', data);
        },
        
        removeBill: function(id) {
            
            var data = {
                _method: 'DELETE',
                _token: CSRF_TOKEN 
            }
            
            return $http.post('/bills/'+id, data);
        },
        
        updateBill: function(id, data) {
            
            data._method = 'PUT';
            
            return $http.post('/bills/'+id, data);
        } 
    }
})


