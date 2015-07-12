@extends ('layouts.main')

@section ('content')
<h2>Операции</h2>

@include('partials.alerts.error')

<table class='table'>
    <thead>
        <th>Дата и время</th>
        <th>Счет</th>
        <th>Категория</th>
        <th>Сумма</th>
    </thead>
    <tbody>
        @forelse($operations as $op)
        <tr class='{{$op->type=='income' ? 'success' : 'danger'}}'>
            <td>{{$op->created_at}}</td>
            <td>{{$op->bill->name}}</td>
            <td>{{$op->category->name}}</td>
            <td>{{$op->amount}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">Нет операций</td>
        </tr>
        @endforelse
    </tbody>
</table>

<a href='{{route('operations.create', 'type=income')}}' class='btn btn-success'>Доход</a>
<a href='{{route('operations.create', 'type=outcome')}}' class='btn btn-danger'>Расход</a>
@stop
