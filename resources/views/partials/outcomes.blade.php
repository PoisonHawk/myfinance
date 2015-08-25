@section('right-sidebar')

<div class='panel panel-default' ng-controller="ctrlReport">
        <div class='panel-heading'>
            <h4>Расходы</h4>
        </div>
        <div class='panel-body'>
            <div class="diagramm">
                <canvas id="outcomes" width="300" height="300"></canvas>
<!--                <div class="discribe col-md-1">
                    <ul>
                        <li ng-repeat="i in dataSource">[[i.label]]</li>
                    </ul>
                </div>-->
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

