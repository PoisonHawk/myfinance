@section('right-sidebar')
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
        <div class='panel-body'>
            <div class="diagramm">
                <div style="max-width: 300px">
                <canvas class='chart ' id="outcomes" width="300" height="300"></canvas>
                </div>
                <div class='legend ' id="legend"></div>
                <div class='clearfix'></div>
            </div>
<table class='table'>   
    <tr class="active" ng-repeat="r in data.result">
        <td>[[r.name]]</td>
        <td>&nbsp;</td>
        <td>[[r.total]]</td>
        <ul ng-if="r.items">
        <li ng-repeat="item in r.items">
            <span></span>
            <span>[[item.name]]</span>
            <span>[[item.total]]</span>
        </li>
    
        </ul>
    </tr>
    <tr class='info'>
        <td>Итого</td>
        <td>&nbsp;</td>
        <td>[[data.total]]</td>
    </tr>
</table>
</div>
</div>
<script>

</script>
@stop

