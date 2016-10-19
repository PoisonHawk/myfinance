@extends('layouts.main')

@section('content')

<!--Top Outcomes-->
	<div class="panel panel-default">
		<div class="panel-heading"><h4>Топ расходов</h4></div>
		<table class="table">
			<thead>
				@foreach($topCategories as $month => $data)
					<th colspan="2" class="text-center">{{ $month}}</th>
				@endforeach
			</thead>
			<tbody>
				@for($i=0; $i<5; $i++)
				<tr>
					<?php foreach($topCategories as $month): ?>			
						<?php $keys = array_keys($month); ?>									
						<?php echo isset($keys[$i]) ? '<td>'.$keys[$i] .'</td><td><strong>'.$month[$keys[$i]] .'</strong></td>': '<td colspan=2></td>' ?>
					<?php endforeach ?>
				</tr>
				@endfor
			</tbody>
		</table>
	</div>
<!-- END TOP Outcomes -->


<!-- Charts-->
<div class="row">
	<div class="col-md-6">
        @include('partials.outcomesmonth')
    </div>
    <div class="col-md-6">
        @include('partials.outcomes')
    </div>
</div>

<!-- End Charts -->

<!-- Bills -->
<div class="row">	
	@foreach($user_bills as $b)
	<div class="col-lg-3 col-md-4 col-sm-6">
		<div class="panel panel-default ">			
			<div class="panel-heading"><h4>{{$b->name}}</h4></div>
			<div class="panel-body">
				<div class="text-center" style="font-size: 28px; margin: 20px 0;">
					<span class="glyphicon glyphicon-{{ strtolower($b->currency)}}"></span> 
					{{ number_format($b->amount, 2, '.', ' ')}} 
					<!--{{ $b->currency }}-->
				</div>
				@if($b->saving_account == 0) 
				<div class="row">
					<span class="text-success col-md-4"><span class="glyphicon glyphicon-plus"></span> {{ number_format($b->in, 2, '.', ' ')}}</span>
					<span class="text-danger col-md-4"><span class="glyphicon glyphicon-minus"></span> {{ number_format( $b->out, 2, '.', ' ')}}</span>
					<span class="col-md-4"><span class="glyphicon glyphicon-arrow-{{ ($b->in - $b->out)>= 0 ? 'up text-success'  : 'down text-danger'  }}"></span> {{ number_format( ($b->in - $b->out), 2, '.', ' ' ) }}</span>
				</div>
				@else				
				<div class="progress" style="position:relative">
					<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$b->percent}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$b->percent.'%'}};">
						
						<span class="sr-only">{{$b->percent}}% Complete</span>
					</div>
					<span style="color: #000; position: absolute; right: 5px" class="pull-right"><span class="glyphicon glyphicon-{{ strtolower($b->currency)}}"></span> <strong>{{ number_format($b->saving_amount , 0, '.', ' ')}}</strong></span>
				</div>
				@endif
			</div>		
		</div>
	</div>
	@endforeach
</div>
<!-- END BILLS -->


<!-- Outcomes -->
<div class="row">
	<div class="col-md-8">
	<script>
		$(document).ready(function(){

			$('input[name=created]').datetimepicker({format:'Y-m-d H:i'})
			$('input[name=fromDate]').datetimepicker({timepicker:false, format:'Y-m-d'})
			$('input[name=toDate]').datetimepicker({timepicker:false, format:'Y-m-d'})
		})
	</script>

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
</div>

<div class="col-md-4">

    <div class="panel panel-default">
        <div class='panel-heading'>
            <span class="glyphicon glyphicon-stats"></span>
            <span>Запланированные расходы</span>
        </div>
        <div class="panel-body">
            <table class='table' >
                <tbody>
                    @foreach($purchases as $purchase)
                       <tr>
                           <td>{{$purchase->name}}</td>
                           <td>{{$purchase->amount}}</td>
                       </tr>
                    @endforeach
                <tr>
                    <td><a href="/purchase">Посмотреть все</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
	</div>

<!-- End outbcomes -->

@stop

