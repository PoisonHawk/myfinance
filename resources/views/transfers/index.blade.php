@extends ('layouts.main')

@section ('content')
<h2>Журнал перемещений</h2>

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

<form action='{{route('transfers.index')}}' class="form-inline">  
        {!! Form::label('from_date', 'Дата с ')!!}
        {!! Form::text('from_date', $from_date, array('id'=>'from_date', 'class'=>'input-small'))!!}
        {!! Form::label('to_date', 'по ')!!}       
        {!! Form::text('to_date', $to_date, array('id'=>'to_date'))!!}
        
        {!! Form::submit('Поиск', array('class' => 'btn btn-default'))!!}        
</form>


<table class='table'>
    <thead>      
        <th>Дата и время</th>
        <th>Счета</th>        
        <th>Сумма</th>
        <th></th>
    </thead>
    <tbody>
        @forelse($transfers as $t)
        <tr>            
            <td>{{$t->created_at}}</td>
            <td>{{$t->billFrom->name}}<span class='glyphicon glyphicon-arrow-right'></span> {{$t->billTo->name}}</td>            
            <td>{{$t->amount}}</td>
            <td>                
                <button class="remove_operation btn btn-danger"><span class="glyphicon glyphicon-trash"></button>
                <form method="POST" action="{{route('transfers.destroy', $t->id)}}">
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

<a href='{{route('transfers.create')}}' class='btn btn-primary'>Перемещение</a>

@stop
