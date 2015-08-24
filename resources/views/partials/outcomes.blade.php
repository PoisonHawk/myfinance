@section('right-sidebar')
<script src="/js/chartjs/Chart.js"></script>

<div class='panel panel-default'>
        <div class='panel-heading'>
            <h4>Расходы</h4>
        </div>
        <div class='panel-body'>
            <div class="diagramm">
                <canvas id="outcomes" width="300" height="300"></canvas>                
            </div>
<table class='table'>   
    @foreach($data['result'] as $cat => $cat_data)
        <tr class='active'>
            <td>{{$cat}}</td>
            <td>&nbsp;</td>
            <td>{{$cat_data['total']}}</td>
            @foreach($cat_data['items'] as $k => $v)
        <tr>
            <td>&nbsp;</td>
            <td>{{$k}}</td>
            <td>{{$v}}</td>
        </tr>
            @endforeach
        </tr>
    @endforeach
    <tr class='info'>
        <td>Итого</td>
        <td>&nbsp;</td>
        <td>{{$data['total']}}</td>
    </tr>
</table>
</div>
</div>
<script>
var dataSource = [
    { label: "Авто", value: 500, color: 'red' },
    { label: "Карманнные расходы", value: 95, color: 'blue' },
    { label: "Обед", value: 305, color: 'green' },
    { label: "Продукты", value: 500, color: 'yellow' },
    { label: "детские товары", value: 841.5, color: 'orange' }
]; 

var context = document.getElementById('outcomes').getContext('2d');
var skillsChart = new Chart(context).Doughnut(dataSource , {
    animateScale: true
});
</script>
@stop

