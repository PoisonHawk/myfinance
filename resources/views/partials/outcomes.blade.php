@section('right-sidebar')
<div class='panel panel-default'>
        <div class='panel-heading'>
            <h4>Расходы</h4>
        </div>
        <div class='panel-body'>
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
@stop

