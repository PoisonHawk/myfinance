app.factory('purchaseFactory', function($http){
    
    return {
        get: function() {
            return $http.get('/purchase');
        }
    }
})

