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
         
     })  

</script>
{!! Form::open() !!}
    <div class="form-group">
        {!! Form::label('from_date', 'Дата с:') !!}
        {!! Form::text('from_date') !!}
    </div>

{!! Form::close() !!}
<form action='{{route('operations.index')}}'>
    <div class='form-group'>
        <label>Дата с</label>
        <input type='date' name='from_date'>
        <label>по</label>
        <input type='date' name='to_date'>
    </div>
</form>


<table class='table'>
    <thead>
        <th>Дата и время</th>
        <th>Счет</th>
        <th>Категория</th>
        <th>Сумма</th>
        <th></th>
    </thead>
    <tbody>
        @forelse($operations as $op)
        <tr class='{{$op->type=='income' ? 'success' : 'danger'}}'>
            <td>{{$op->created}}</td>
            <td>{{$op->bill->name}}</td>
            <td>{{$op->category->name}}</td>
            <td>{{$op->amount}}</td>
            <td>
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
