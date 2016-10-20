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
<div class='row'>
	<form action='{{route('operations.index')}}' class="form-inline">  
		

			{!! Form::label('from_date', 'Дата с ', array('class'=>'control-label'))!!}
			{!! Form::text('from_date', $from_date, array('id'=>'from_date', 'class'=>'form-control input-sm'))!!}	
			
			{!! Form::label('to_date', 'по ')!!}       
			{!! Form::text('to_date', $to_date, array('id'=>'to_date', 'class'=>'form-control input-sm'))!!}

			{!! Form::label('bill', 'Счет')!!}  
			{!! Form::select('bill', $bills, $bill, array('class'=>'form-control input-sm')) !!}
			
			{!! Form::label('type', 'Тип операции') !!}
			{!! Form::select('type', $types, $type, array('class'=>'form-control input-sm')) !!}
			
			{!! Form::label('category', 'Категория') !!}
			{!! Form::select('category', $categories, $category, array('class'=>'form-control input-sm')) !!}

			{!! Form::submit('Поиск', array('class' => 'btn btn-default'))!!}        
	
	</form>
</div>

<br>
<br>

<table class='table table-striped'>
    <thead>
        <th class='text-center'>Сумма</th>
        <th class='text-center'>Категория</th>
        <th class='text-center'>Дата и время</th>
        <th class='text-center'>Счет</th>
        <th></th>
    </thead>
    <tbody>
        @forelse($operations as $op)
        <tr style='font-size:18px'>     
            <td style="vertical-align:middle" class='text-center'><span class="text-{{$op->type=='income' ? 'success' : 'danger'}} glyphicon glyphicon-{{$op->type=='income' ? 'plus' : 'minus'}}"></span>&nbsp;
					{{$op->amount}} {{ $op->bill->currency->iso4217 }}
			</td>
            <td style="vertical-align:middle" class='text-center'>{{$op->category->name}}</td>
            <td style="vertical-align:middle" class='text-center'>{{$op->created->format('d.m.Y')}}<br><small>{{$op->created->format('H:i:s')}}</small></td>
            <td style="vertical-align:middle" class='text-center'>{{$op->bill->name}}</td>

            <td class='text-center'>
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
