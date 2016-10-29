<style>
    .doughnut-legend{
        list-style: none;
    }

    .doughnut-legend li span{
        display: inline-block;
        height: 10px;
        margin-right: 5px;
        width: 10px;
    }

    .diagramm .chart,
    .diagramm .legend{
        float: left;
    }
</style>
<div class='panel panel-default' ng-controller="ctrlReport">
	<div class='panel-heading'>
		<span ng-click="getReport('outcome')">Расходы</span>
		<span ng-click="getReport('income')">Доходы</span>
		<div class="btn-group">
			<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				[[ activePeriod.name ]] <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				<li><a href="javascript: void(0)" ng-click="changePeriod(r)"  ng-repeat="r in periods | orderBy : '-from'">[[r.name]]</a></li>

			</ul>
		</div>
	</div>
	<div class='panel-body'>
		<div class="row">
			<div class="diagramm col-md-6 col-sm-6 col-xs-6">
				<div ng-show="data.result.length>0">
					<canvas class='chart' id="outcomes" width="300" height="300"></canvas>
				</div>
				<div ng-hide="data.result.length>0">Нет данных за указанный период.</div>
				<div class='legend' id="legend"></div>
				<div class='clearfix'></div>
			</div> 
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class='table' id='accordion'>
					<div ng-repeat="r in data.result" >
						<div> 
							<span style="padding: 0 10px ; margin-right: 5px; background: [[r.color]] "></span>
							<span><a data-toggle="collapse" data-parent="#accordion" href="[[('#collapse_'+r.num)]]" aria-expanded="false" aria-controls="[[('#collapse_'+r.num)]]">[[r.name]]</a></span>
							<span>&nbsp;</span>
							<span class="pull-right "><strong>[[r.total]]</strong></span>
						</div>
						<div id="[[('collapse_'+r.num)]]" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" ng-if="r.items" >
							<div ng-repeat="item in r.items">
								<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<span>[[item.name || 'Без категории']]</span>
								<span class="pull-right"><small>[[item.total]]</small></span>
							</div>
						</div>
					</div>
				</div>
				<div class='info pull-right'>
					<span>Итого</span>
					<span>&nbsp;</span>
					<span><strong>[[data.total]]</strong></span>
				</div>
			</div>
		</div>
	</div>
</div>

