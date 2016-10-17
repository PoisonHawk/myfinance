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
        default_wallet: 0,
        show: 0,
        saving_account: 0,
        saving_amount: 0,
    };
    $scope.index;
    $scope.error = false;
    $scope.errors = [];

    $scope.clearDefault = function(){

        for (bill in $scope.bills) {
            $scope.bills[bill].default_wallet = 0;
        }
    };

    $scope.clearBillData = function(){
        $scope.bill = {
            name: '',
            currency: 1,
            amount: 0,
            default_wallet: 0,
            show: 0,
            saving_account: 0,
            saving_amount: 0,
        }
    };

    $scope.closeAlert = function(){

        $scope.error = false;
        $scope.errors = [];
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
        billFactory.getBills()
                .success(function(data, status, headers, config){
                                       
                    console.log(data.bills);
                    $scope.bills = data.bills;
                    $scope.currencies = data.currency;
                    $scope.loading = false;
                })
                .error(function(){
                    $scope.messageFail('Ошибка получения данных');
                    $scope.loading = false;
                })
    };

    $scope.addBill = function(){

        $scope.sending = true;

        var post = {
            name: $scope.bill.name,
            currency_id: $scope.bill.currency,
            amount: $scope.bill.amount,
            default_wallet: $scope.bill.default_wallet,
            show: $scope.bill.show,
            saving_account: $scope.bill.saving_account,
            saving_amount: $scope.bill.saving_amount,
        }

        billFactory.addBill(post)
                .success(function(data, status, headers, config){

                    if (data.status === 'ok') {

                        if (data.bill.default_wallet == 1) {
                            $scope.clearDefault();
                        }

                        $scope.bills.push(data.bill);
                        $('#modal_bill').modal('hide');
                        
                        $scope.clearBillData();
                        
                    } else {

                        $scope.error = true;
                        $scope.errors = data.errors;

                    }

                    $scope.sending = false;
                })
                .error(function(data){                  
                    $scope.sending = false;
                    $scope.showErrors(data);
                })

    };

    $scope.showBillAdd = function(index){

        $scope.clearBillData();
        $('#modal_bill').modal('show');
    };

    $scope.showBill = function(index){

        var bill = $scope.bills[index];
        $scope.index = index;

        $scope.bill.name = bill.name;
        $scope.bill.currency = bill.currency.iso4217;
        $scope.bill.amount = bill.amount;
        $scope.bill.default_wallet = bill.default_wallet;
        $scope.bill.show = bill.show;
        $scope.bill.id = bill.id;
        $scope.bill.saving_account = bill.saving_account;
        $scope.bill.saving_amount = bill.saving_amount;
        $('#modal_bill_update').modal('show');
    };

    $scope.updateBill = function(id){

        $scope.sending = true;

        var post = {
            name: $scope.bill.name,
            default_wallet: $scope.bill.default_wallet,
            show: $scope.bill.show,
        }

        billFactory.updateBill(id, post)
            .success(function(data, status, headers, config){

                if (data.status === 'ok') {

                    if (data.bill.default_wallet == 1) {
                        $scope.clearDefault();
                    }
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

        var confirmRemoving = confirm('Вы действительно хотите удалить счет?');
        
        if (!confirmRemoving) {
            return;
        }

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

    $scope.showErrors = function(errors) {
        
        $scope.error = true;                
        $scope.errors = errors;
    }

    $scope.init();

})
