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
		<span ng-click="getReport('outcome')" >Расходы</span>
		<span ng-click="getReport('income')">Доходы</span>
	</div>
	<!--<img src="/img/preload.gif" ng-show="loading" class="center-block">-->
	<div class='panel-body'>

		<!--<div ng-hide="loading">-->
		<div class="diagramm">
			<div style="max-width: 250px">
				<canvas class='chart ' id="outcomes" width="250" height="250"></canvas>
			</div>
			<div class='legend' id="legend"></div>
			<div class='clearfix'></div>
		</div> 
		<div class='table' id='accordion'>
			<div class="bg-warning" ng-repeat="r in data.result" >
				<div>
					<span><a data-toggle="collapse" data-parent="#accordion" href="[[('#collapse_'+r.num)]]" aria-expanded="false" aria-controls="[[('#collapse_'+r.num)]]">[[r.name]]</a></span>
					<span>&nbsp;</span>
					<span>[[r.total]]</span>
				</div>
				<div id="[[('collapse_'+r.num)]]" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" ng-if="r.items" >
					<div ng-repeat="item in r.items">
						<span>&nbsp;</span>
						<span>[[item.name || 'Без категории']]</span>
						<span>[[item.total]]</span>
					</div>
				</div>
			</div>
		</div>
		<div class='info'>
			<span>Итого</span>
			<span>&nbsp;</span>
			<span>[[data.total]]</span>
		</div>
	</div>
</div>

