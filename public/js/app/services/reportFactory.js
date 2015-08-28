app.factory('reportFactory', function($http){
    return {
        outcome : function(type){
            return $http.get('/reportoutcome/'+type);
        }
    }
});


