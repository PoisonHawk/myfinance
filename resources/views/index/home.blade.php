@extends('layouts.main')

@section('content')

<div class="row">
	<table class="table table-borderless">
			<thead>
				<th colspan="3" class="text-center">День</th>
				<th colspan="3" class="text-center">Неделя</th>
				<th colspan="3" class="text-center">Месяц</th>
			</thead>
			<tbody>
				<tr>
					<td class="text-success text-center">+&nbsp;{{ $dayWeekMonthStat['day']->income }}</td>
					<td class="text-danger text-center">-&nbsp;{{ $dayWeekMonthStat['day']->outcome }}</td>
					<td class="text-center {{ $dayWeekMonthStat['day']->income - $dayWeekMonthStat['day']->outcome > 0 ? 'text-success' : 'text-danger' }}">
						<span class="glyphicon glyphicon-arrow-{{ $dayWeekMonthStat['day']->income - $dayWeekMonthStat['day']->outcome > 0 ? 'up' : 'down' }}"></span>&nbsp;
						{{ $dayWeekMonthStat['day']->income - $dayWeekMonthStat['day']->outcome }}
					</td>
					<td class="text-success text-center">+&nbsp;{{ $dayWeekMonthStat['week']->income }}</td>
					<td class="text-danger text-center">-&nbsp;{{ $dayWeekMonthStat['week']->outcome }}</td>
					<td class="text-center {{ $dayWeekMonthStat['week']->income - $dayWeekMonthStat['week']->outcome > 0 ? 'text-success' : 'text-danger' }}">
						<span class="glyphicon glyphicon-arrow-{{ $dayWeekMonthStat['week']->income - $dayWeekMonthStat['week']->outcome > 0 ? 'up' : 'down' }}"></span>&nbsp;
						{{ $dayWeekMonthStat['week']->income - $dayWeekMonthStat['week']->outcome }}
					</td>
					<td class="text-success text-center">+&nbsp;{{ $dayWeekMonthStat['month']->income }}</td>
					<td class="text-danger text-center">-&nbsp;{{ $dayWeekMonthStat['month']->outcome }}</td>
					<td class="text-center {{ $dayWeekMonthStat['month']->income - $dayWeekMonthStat['month']->outcome > 0 ? 'text-success' : 'text-danger' }}">
						<span class="glyphicon glyphicon-arrow-{{ $dayWeekMonthStat['month']->income - $dayWeekMonthStat['month']->outcome > 0 ? 'up' : 'down' }}"></span>&nbsp;
						{{ $dayWeekMonthStat['month']->income - $dayWeekMonthStat['month']->outcome }}
					</td>
				</tr>
			</tbody>
		</table>
</div>

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
			<div class="panel-body" style="min-height: 130px">
				<p class="text-right" style="font-size: 28px; /*margin: 20px 0*/; position: relative">
					{{ number_format($b->amount, 2, '.', ' ')}}
					<span style="font-size: 16px;" class="glyphicon glyphicon-{{ strtolower($b->currency)}}"></span>

				</p>
				@if($b->credit == 1 and $b->debt_amount > 0)
					<p class="text-right" style="font-size: 16px; right: 50px; color: red;">{{ number_format($b->debt_amount, 2, '.', ' ')}} <span style="font-size: 14px;" class="glyphicon glyphicon-{{ strtolower($b->currency)}}"></span></p>
				@endif

				@if($b->saving_account == 0) 
				<span class="pull-right"><a href="/operations?bill={{$b->id}}">Посмотреть все операции</a></span>
<!--				<div class="row">
					<span class="pull-right"><a href="/operations?bill={{$b->id}}">Операции</a></span>
					<span class="text-success col-md-4">
						+{{ number_format($b->in, 2, '.', ' ')}}</span>
					<span class="text-danger col-md-4">-{{ number_format( $b->out, 2, '.', ' ')}}</span>
					<span class="col-md-4"><span class="glyphicon glyphicon-arrow-{{ ($b->in - $b->out)>= 0 ? 'up text-success'  : 'down text-danger'  }}"></span> {{ number_format( ($b->in - $b->out), 2, '.', ' ' ) }}</span>
				</div>-->
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
	<div class='panel panel-default' ng-controller="OperationsCtrl">
        <div class='panel-heading'>
			<div class="col-md-4">
				<span class="glyphicon glyphicon-stats">&nbsp;</span>
				<span>Расходы за</span>&nbsp;
				<div class="btn-group">
					<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  [[ periodName ]] <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
					  <li><a href="javascript: void(0)" ng-click="report(1)" >день</a></li>
					  <li><a href="javascript: void(0)" ng-click="report(7)">неделю</a></li>
					  <li><a href="javascript: void(0)" ng-click="report(31)">месяц</a></li>				 
					  <li><a href="javascript: void(0)" ng-click="period()">период</a></li>
					</ul>
				</div>
			</div>
            <div ng-show="isPeriod" class="col-md-8">
				<form class="form form-inline">
					<label>C&nbsp;</label>	
					<input name="fromDate" type="text" value="[[date.from]]" ng-model="date.from" size="8" class="form-control input-sm">
					<label>&nbsp;по &nbsp;</label>
					<input name="toDate" type="text" value="[[date.to]]" ng-model="date.to" size="8" class="form-control input-sm">
					<button ng-click="makeRequest()" class="btn btn-default btn-sm">Показать</button>
				</form>
            </div>
			<div class="clearfix"></div>
        </div> 
            <img src="/img/preload.gif" ng-show="load"></img>
            <table class='table table-striped' ng-hide="load">
                <p class="text-danger" ng-show="error">[[message]]</p>
                <tbody>
                    <tr ng-repeat="op in operations">
                        <td>[[ op.created | date: 'dd.MM HH:ii' ]]</td>
                        <td>[[op.bill.name]]</td>
                        <td>[[op.category.name ]]</td>
                        <td>[[op.amount]] [[op.bill.currency.iso4217]]</td>
                    </tr>
                    <tr><td></td><td></td><td></td><td>Итого: [[total()]]</td></tr>
					<tr><td colspan="4"><a href="/operations?type=outcome">Посмотреть все</td></a></tr>
                </tbody>
            </table>        
   </div>
</div>

<div class="col-md-4">

	@include('index.credit');

	@include('index.purchases');

</div>
	</div>

<!-- End outbcomes -->

@stop

