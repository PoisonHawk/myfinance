@extends('layouts.main')
 
@section('content')

<script>
    $(document).ready(function(){

        $('input[name=created]').datetimepicker({format:'Y-m-d H:i'})
        
        $('input[name=fromDate]').datetimepicker({timepicker:false, format:'Y-m-d'});
        $('input[name=toDate]').datetimepicker({timepicker:false, format:'Y-m-d'})
    })
</script>


<button class='btn btn-success' data-toggle="modal" data-target="#modal_income">Доход</button>
<button class='btn btn-danger' data-toggle="modal" data-target="#modal_outcome">Расход</button>
<button class='btn btn-primary' data-toggle='modal' data-target='#modal_transfer'>Перевод</button> 

<!-- Modal Income-->
@include('partials.operations.modal', ['type'=>'income', 'today'=>$today, 'bills'=>$bills, 'categories'=> $categories, 'title' => 'доход'])
@include('partials.operations.modal', ['type'=>'outcome', 'today'=>$today, 'bills'=>$bills, 'categories'=> $categories, 'title'=> 'расход'])
<div class="modal fade" id="modal_transfer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Новый перевод</h4>
      </div>
      <div class="modal-body">        
        <form method='POST' action='{{route('transfers.store')}}'>
            <div class='form-group'>
                <label class='control-label'>Дата:</label>
                <input type='text' name='created' class='form-control' value='{{$today}}'>
            </div>    
            <!--Счет-->
            <div class='form-group'>
                <label class='control-label'>Cчет отправитель:</label>        
                    <select name='bill_from_id' class='form-control'>
                    @foreach($bills as $bill)
                    <option value="{{$bill->id}}">{{$bill->name}}</option>
                    @endforeach
                </select>        
            </div>
            <div class='form-group'>
                <label class='control-label'>Cчет получатель:</label>                     
                    <select name='bill_to_id' class='form-control'>
                    @foreach($bills as $bill)
                    <option value="{{$bill->id}}">{{$bill->name}}</option>
                    @endforeach
                </select>   

            </div>    
            <div class='form-group'>
                <label class='control-label'>Сумма:</label>
                <input type='text' name='amount' class='form-control'>
            </div>    
            <input type='hidden' name='type' value='transfer'>    
            <input type='hidden' name='redirect' value='/'>   
            <input type='hidden' name='_token' value='{{csrf_token()}}'>
            <input type='submit' name='submit' value='Сохранить' class='btn btn-primary'>
        </form>
      </div>
    </div>
  </div>
</div>
<br>

<div class='panel panel-default'>
        <div class='panel-heading'>
            <span class="glyphicon glyphicon-credit-card"></span>
            <span>Счета</span>
        </div>
        <div class='panel-body'>
            <table class='table'>
                <thead>
                    <th>Счет</th>
                    <th>Доход</th>
                    <th>Расход</th>
                    <th>Сумма</th>
                    <th>Валюта</th>
                </thead>
                <tbody>
                    <?php $total = 0;?>
                    @foreach($user_bills as $b)
                    <tr>
                        <td>{{$b->name}}</td>
                        <td>{{$b->in or 0}}</td>
                        <td>{{$b->out or 0}}</td>
                        <td>{{$b->amount}}</td>
                        <td>{{$b->currency}}</td>
                    </tr>
                    <?php $total += $b->amount?>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <!--<td>{{$total}}</td>-->
                    </tr>
                </tbody>
            </table>
        </div>
   </div>


<div class='panel panel-default' ng-controller="OperationsCtrl">
        <div class='panel-heading'>
            <span class="glyphicon glyphicon-stats"></span>
            <span>Расходы за </span>
            <div class="btn-group btn-group-xs">
                <button class="btn btn-default" ng-click="report(1)">день</button>
                <button class="btn btn-default" ng-click="report(7)">неделю</button>
                <button class="btn btn-default" ng-click="report(31)">месяц</button>
                <button class="btn btn-default" ng-click="period()">период</button>
            </div>
            <div ng-show="isPeriod">
                C <input name="fromDate" type="text" value="[[date.from]]" ng-model="date.from" size="8">
                по <input name="toDate" type="text" value="[[date.to]]" ng-model="date.to" size="8">
                <button ng-click="makeRequest()">Показать</button>
            </div>
        </div>
        <div class='panel-body'>
            <img src="/img/preload.gif" ng-show="load"></img>
            <table class='table' ng-hide="load">
                <p class="text-danger" ng-show="error">[[message]]</p>
                <tbody>
                    <tr ng-repeat="op in operations">
                        <td>[[op.created | date:'dd.MM HH:ii']]</td>
                        <td>[[op.bill.name]]</td>
                        <td>[[op.category.name ]]</td>
                        <td>[[op.amount]] [[op.bill.currency.iso4217]]</td>
                    <tr>
                    <tr><td></td><td></td><td></td><td>[[total()]]</td></tr>
                </tbody>
            </table>
        </div>
   </div>
@stop