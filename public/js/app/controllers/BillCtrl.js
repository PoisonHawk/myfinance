app.controller('BillCtrl', function($scope, billFactory, CSRF_TOKEN){
    $scope.bills = [];
    $scope.currencies;
    $scope.loading = false;
    $scope.sending = false;
    $scope.success = false;
    $scope.fail = false;
    $scope.message = '';
    $scope.bill = {
        name: '',
        currency: 1,
        amount: 0,
    },
    $scope.index;
        
    $scope.closeAlert = function(){
       
        $scope.success = false;
        $scope.fail = false;
    };
    
    $scope.messageSuccess = function(text) {
        $scope.fail = false;
        $scope.success = true;
        $scope.message = text;  
    };
    
    $scope.messageFail = function(text) {
        $scope.fail = true;
        $scope.succes = false;
        $scope.message = text;  
    };
    
    $scope.init = function(){
       
        $scope.loading = true;
        billFactory.getBills().success(function(data, status, headers, config){
            $scope.bills = data.bills;
            $scope.currencies = data.currency;
            $scope.loading = false;  
        })
    };
    
    $scope.addBill = function(){  
               
        $scope.sending = true;
        
        var post = {
            name: $scope.bill.name,
            currency_id: $scope.bill.currency,
            amount: $scope.bill.amount
        }
        
        billFactory.addBill(post)
                .success(function(data, status, headers, config){
            $scope.bills.push(data);
            $scope.sending = false;
            $('#modal_bill').modal('hide');
        })        
        
    };
    
    $scope.showBill = function(index){
                       
        var bill = $scope.bills[index];
        $scope.index = index;
                       
        $scope.bill.name = bill.name;
        $scope.bill.currency = bill.currency_id;
        $scope.bill.amount = bill.amount;
        $scope.bill.id = bill.id;
        $('#modal_bill_update').modal('show');
    };
    
    $scope.updateBill = function(id){
        
        $scope.sending = true;
        
        var post = {
            name: $scope.bill.name,            
        }
        
        billFactory.updateBill(id, post)
            .success(function(data, status, headers, config){               
                
                if (data.status === 'ok') {
                    $scope.bills[$scope.index] = data.bill;                    
                    $scope.messageSuccess(data.message); 
                } else {
                    $scope.messageFail('Ошибка операции');
                }
                
                $scope.sending = false;
                $('#modal_bill_update').modal('hide');
            }) 
            .error(function(){               
                $scope.messageFail('Ошибка операции');  
        
                $scope.sending = false;
                $('#modal_bill_update').modal('hide');
            })
            
            
        
    };
    
    $scope.removeBill = function(index){
        
        $scope.loading = true;
        
        var bill = $scope.bills[index];
                        
        billFactory.removeBill(bill.id)
                .success(function(data, status, headers, config){
                    if (data.status === 'ok') {
                        $scope.messageSuccess(data.message);                        
                        $scope.bills.splice(index, 1);
                        $scope.loading = false;
                    } else {
                       $scope.messageFail('Ошибка удаления');              
                       $scope.loading = false; 
                    }
                })
                .error(function(){
                    $scope.messageFail('Ошибка удаления');             
                    $scope.loading = false; 
                })
    };
        
    $scope.init();
})

