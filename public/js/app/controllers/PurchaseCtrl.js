app.controller('PurchaseCtrl', function($scope, $http, CSRF_TOKEN){

    $scope.removePurchase = function(id){
        var confirmRemoving = confirm('Вы действительно хотите удалить запись?');

        if (!confirmRemoving) {
          return;
        }

        $http({
          method: 'POST',
          data: {'_token': CSRF_TOKEN, '_method': 'DELETE'},
          _token: CSRF_TOKEN,
          _method: 'DELETE',
          url: '/purchase/'+id
        }).then(function successCallback(response){
          // console.log(response);
          if(response.data.status === true) {
            alert('Запись удалена!');
            window.location.href = '/purchase';
          } else {
            alert(response.data.error);
          }

        }, function errorCallback(response){
          alert('Невозможно удалить запись');
        })
    }
});
