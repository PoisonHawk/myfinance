@extends ('layouts.main')

@section ('content')
<h2>Операции</h2>

@include('partials.alerts.error')

@if(Session::has('flash_message'))
    <div class='alert alert-success'>
        <p>{{Session::get('flash_message')}}</p>
    </div>
@endif

<script>   
     $(document).ready(function(){
         
         $('.remove_operation').click(function(){
             $(this).next('form').submit();
         })
                  
         $('#from_date').datepicker({dateFormat:'dd.mm.yy'});
         $('#to_date').datepicker({dateFormat:'dd.mm.yy'});         
         
     })  
</script>

<form action='{{route('operations.index')}}' class="form-inline">  
        {!! Form::label('from_date', 'Дата с ')!!}
        {!! Form::text('from_date', $from_date, array('id'=>'from_date', 'class'=>'input-small'))!!}
        {!! Form::label('to_date', 'по ')!!}       
        {!! Form::text('to_date', $to_date, array('id'=>'to_date'))!!}
        {!! Form::label('bill', 'Счет')!!}  
        {!! Form::select('bill', $bills, $bill) !!}
        {!! Form::submit('Поиск', array('class' => 'btn btn-default'))!!}        
</form>


<table class='table table-condensed'>
    <thead>
        <th></th>
        <!--<th></th>-->
        <th>Дата и время</th>
        <th>Счет</th>
        <th>Категория</th>
        <th>Сумма</th>
        <th></th>
    </thead>
    <tbody>
        @forelse($operations as $op)
        <tr>
            <td><span class="text-{{$op->type=='income' ? 'success' : 'danger'}} glyphicon glyphicon-{{$op->type=='income' ? 'plus' : 'minus'}}"></td>
            <!--<td>@if($op->active == 1)<span class="text-success glyphicon glyphicon-ok">@endif</td>-->
            <td>{{$op->created}}</td>
            <td>{{$op->bill->name}}</td>
            <td>{{$op->category->name}}</td>
            <td>{{$op->amount}}</td>
            <td>
                <!--<a href='{{route('operations.edit', $op->id)}}' class='btn btn-primary'><span class="glyphicon glyphicon-edit"></span></a>-->
                <button class="remove_operation btn btn-danger"><span class="glyphicon glyphicon-trash"></button>
                <form method="POST" action="{{route('operations.destroy', $op->id)}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="_method" value="DELETE">                  
                </form>
            </td>
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
