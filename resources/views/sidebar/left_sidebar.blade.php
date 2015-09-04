
<div class='panel panel-default' ng-controller='BillCtrl'>
    <div class='panel-heading'>
        <h4>Счета</h4>
    </div>
    <div class='panel-body'>
        <img src='/img/preload.gif' ng-show="loading"></img>
        <div ng-repeat='bill in bills'>
            <span>[[bill.name]]</span>
            <span>[[bill.amount]]</span>
            <span class="glyphicon gliphicon-[[bill.currency.iso4217 ]]"></span>
        </div>
    </div>
</div>