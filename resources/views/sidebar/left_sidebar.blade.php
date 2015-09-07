
<div class='panel panel-default bills' ng-controller='BillCtrl'>
    <div class='panel-heading'>
        <span class="glyphicon glyphicon-credit-card"></span>
        <span>Счета</span>
    </div>
    <div class='panel-body'>
        <img src='/img/preload.gif' ng-show="loading"></img>
        <table class='table'>
            <tr ng-repeat='bill in bills'>
                <td>[[bill.name]]</td>
                <td>[[bill.amount]]</td>
                <td class="[[ 'glyphicon glyphicon-'+bill.currency.iso4217 ]]"></td>
            </tr>
        </table>
    </div>
</div>