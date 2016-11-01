app.factory('reportFactory', function($http){
    return {
        outcome : function(type, from, to){
            return $http.get('/reportoutcome/'+type+'?from='+from+'&to='+to);
        }
    }
});


