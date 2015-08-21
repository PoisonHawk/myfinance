@extends('layouts.main')
 
@section('content')
 
<a href='{{route('operations.create', 'type=income')}}' class='btn btn-success'>Доход</a>
<a href='{{route('operations.create', 'type=outcome')}}' class='btn btn-danger'>Расход</a>
<a href='{{route('transfers.create')}}' class='btn btn-primary'>Перевод</a> 

<br>

<div class='panel panel-default'>
        <div class='panel-heading'>
            <h4>Счета</h4>
        </div>
        <div class='panel-body'>
            <table class='table'>
                <thead>
                    <th>Счет</th>
                    <th>Доход</th>
                    <th>Расход</th>
                    <th>Сумма</th>
                </thead>
                <tbody>
                    @foreach($user_bills as $b)
                    <tr>
                        <td>{{$b->name}}</td>
                        <td>{{$b->in ?: 0}}</td>
                        <td>{{$b->out}}</td>
                        <td>{{$b->amount}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
   </div>


<div class='panel panel-default'>
        <div class='panel-heading'>
            <h4>Траты за сегодня</h4>
        </div>
        <div class='panel-body'>
            <table class='table'>
                <tbody>
                    @foreach($userOucomesToday as $o)
                    <tr>
                        <td>{{$o->created_at->format('H:i')}}</td>
                        <td>{{$o->bill->name}}</td>
                        <td>{{$o->category->name}}</td>
                        <td>{{$o->amount}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
   </div>
@stop