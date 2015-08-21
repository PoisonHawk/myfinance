@extends('layouts.main')

@section('content')
<table class='table'>
    @foreach($result as $cat => $data)
        <tr>
            <td>{{$cat}}</td>
            <td>&nbsp;</td>
            <td>{{$data['total']}}</td>
            @foreach($data['items'] as $k => $v)
        <tr>
            <td>&nbsp;</td>
            <td>{{$k}}</td>
            <td>{{$v}}</td>
        </tr>
            @endforeach
        </tr>
    @endforeach
    <tr>
        <td>Итого</td>
        <td>&nbsp;</td>
        <td>{{$total}}</td>
    </tr>
</table>
@stop

