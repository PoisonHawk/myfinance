@extends('layouts.main')

@section('content')
<div  ng-controller="BillCtrl">
<h2>Управление счетами</h2>

<div class="alert alert-success" ng-show="success">
    <button type="button" ng-click="closeAlert()" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    [[message]]
</div>

<div class="alert alert-danger" ng-show="fail">
    <button type="button" ng-click="closeAlert()" class="close" ><span aria-hidden="true">&times;</span></button>
    [[message]]
</div>

<table class='table table-striped table-condensed table-hover' >
    <thead>
		<th>Название</th>
        <th>Основной</th>	
		<th>Избранный</th>
		<th>Накопительный</th>
        <th>Сумма</th>
		<th>Сумма накопления</th>
        <th>Валюта</th>
        <th></th>
    </thead>
    <tbody>
        <img src="/img/preload.gif" ng-show="loading" class="center-block">
        <tr ng-repeat="bill in bills" >
			<td>[[bill.name]]</td>
            <td><span ng-if="bill.default_wallet == 1" class='glyphicon glyphicon-ok'></span></td>
			<td><span ng-if="bill.show == 1" class='glyphicon glyphicon-star'></span></td>
            <td><span ng-if="bill.saving_account == 1" class='glyphicon glyphicon-ok'></span></td>
            <td>[[bill.amount]]</td>
			<td>[[bill.saving_amount]]</td>
            <td>[[bill.currency.iso4217]]</td>
            <td>
                <button ng-click="showBill($index)"><span class='glyphicon glyphicon-edit'></span></button>
                <button ng-click="removeBill($index)"><span class='glyphicon glyphicon-trash'></span></button>
            </td>
            <input type='hidden' ng-model="token" value='{{csrf_token()}}'>
        </tr>
    </tbody>
</table>
<a href='#'  ng-click='showBillAdd()' class='btn btn-primary'>Добавить счет</a>

<!--Modal-->
<div class="modal fade" id="modal_bill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Новый счет</h4>
		<p class="text-danger" ng-show="error" ng-repeat="e in errors.main">
			[[e]]
		</p>
      </div>
		
      <div class="modal-body">
        <form name='operationForm'>
            <div class='form-group'>
                <label class='control-label'>Название:</label>
                <input class='form-control' type='text' ng-model='bill.name'>
                    <p class="text-danger" ng-show="error" ng-repeat="e in errors.name">
                        [[e]]
                    </p>
            </div>

            <div class='form-group'>
                <label class='control-label'>Валюта:</label>
                <select class='form-control 'type='text' ng-model='bill.currency'>
                    <option ng-repeat="(key, val) in currencies" value='[[key]]'>[[val]]</option>
                </select>
            </div>
            <div class='form-group'>
                <label class='control-label'>Начальный остаток:</label>
                <input class='form-control' type='text' ng-model='bill.amount'>
                <p class="text-danger" ng-show="error" ng-repeat="e in errors.amount">
                    [[e]]
                </p>
            </div>
            <div class='form-group'>
                <input class=' 'type='checkbox' id="default_wallet" name="default_wallet" ng-model="bill.default_wallet" value='1'>
                <label class='' for="default_wallet">Основной</label>
            </div>
			<div class='form-group' >
                <input class=' 'type='checkbox' id="show_wallet" name="show" ng-model='bill.show' ng-true-value=1 ng-false-value=0>				
                <label class='' for="show_wallet">Отображать на главной</label>
            </div>
			<div class='form-group'>
                <input class=' 'type='checkbox' id="saving_account" name="saving_account" ng-model='bill.saving_account' ng-true-value=1 ng-false-value=0 >
                <label class='' for="saving_account">Накопительный счет</label>
            </div>
			<div class='form-group' ng-show="bill.saving_account" ng-class="errors.saving_amount ? 'has-error' : '' ">
                <label class='control-label'>Сумма накопления:</label>
                <input class='form-control 'type='text' ng-model='bill.saving_amount'>
                <p class="text-danger" ng-show="error" ng-repeat="e in errors.saving_amount">
					[[e]]
				</p>
            </div>
            <div class='form-group'>
                <input class=' 'type='checkbox' id="credit" name="credit" ng-model='bill.credit' ng-true-value=1 ng-false-value=0 >
                <label class='' for="credit">Кредитный</label>
            </div>
            <input type='hidden' name='_token' value='{{csrf_token()}}'>
            <button class='btn btn-primary form-control' ng-click='addBill()'ng-hide="sending" >Добавить</button>
            <img src="/img/horizont_preload.gif" ng-show="sending" class="center-block">
        </form>
      </div>
    </div>
  </div>
</div>

<!--Modal-->
<div class="modal fade" id="modal_bill_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Редактирование [[bill.name]]</h4>
      </div>
      <div class="modal-body">
        <form name='operationForm'>
            <div class='form-group'>
                <label class='control-label'>Название:</label>
                <input class='form-control' type='text' ng-model='bill.name' required>
            </div>
            <div class='form-group'>
                <label class='control-label'>Валюта:</label>
                <input type="text" class='form-control' ng-model='bill.currency' disabled>
            </div>
            <div class='form-group'>
                <label class='control-label'>Сумма:</label>
                <input class='form-control 'type='text' ng-model='bill.amount' disabled>
            </div>
            <div class='form-group'>
                <input class=' 'type='checkbox' id="default_wallet" name="default_wallet" ng-model='bill.default_wallet' ng-true-value=1 ng-false-value=0>
                <label class='' for="default_wallet">Основной</label>
            </div>
			<div class='form-group'>
                <input class=' 'type='checkbox' id="show_wallet" name="show" ng-model='bill.show' ng-true-value=1 ng-false-value=0>
                <label class='' for="show_wallet">Отображать на главной</label>
            </div>
			<div class='form-group' ng-show="bill.saving_account">
                <input class=' 'type='checkbox' id="saving_account" name="saving_account" ng-model='bill.saving_account' ng-true-value=1 ng-false-value=0 disabled>
                <label class='' for="saving_account">Накопительный счет</label>
            </div>
			<div class='form-group' ng-show="bill.saving_account" ng-class="errors.saving_amount ? 'has-error' : '' ">
                <label class='control-label'>Сумма накопления:</label>
                <input class='form-control 'type='text' ng-model='bill.saving_amount' disabled>                
            </div>
            <div class='form-group'>
                <input class=' 'type='checkbox' id="credit" name="credit" ng-model='bill.credit' ng-true-value=1 ng-false-value=0 >
                <label class='' for="credit">Кредитный</label>
            </div>
            <input type="hidden" name="_method" value="PUT">
            <input type='hidden' name='_token' value='{{csrf_token()}}'>
            <button class='btn btn-primary form-control' ng-click='updateBill(bill.id)'ng-hide="sending">Сохранить</button>
            <img src="/img/horizont_preload.gif" ng-show="sending" class="center-block">
        </form>
      </div>
    </div>
  </div>
</div>

</div>
@stop
