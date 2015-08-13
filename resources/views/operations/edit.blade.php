@extends ('layouts.main')

@section('content')
<div ng-controller='operationCtrl' ng-init='operationId={{$op->id}}; active={{$op->active}}'>
<h2>Операция #{{$op->id}}</h2>
@include('partials.alerts.error')

@if(Session::has('flash_error'))
<div class="alert alert-danger">
    <p>{{Session::get('flash_error')}}</p>
</div>
@endif
<script>
    $(document).ready(function(){        
        $('input[name=created]').datetimepicker({format:'Y-m-d H:i'})
    })
</script>
<form method='POST' action='{{route('operations.update', $op->id)}}' >
    <div class='form-group'>
        <label class='control-label'>Дата:</label>
        <input type='text' name='created' class='form-control' value='{{$op->created}}' ng-disabled="active">
    </div>    
    <!--Счет-->
    <div class='form-group'>
        <label class='control-label'>Cчет:</label>
        <select name='bills_id' class='form-control' ng-disabled="active">
            @foreach($bills as $bill)
            <option value="{{$bill->id}}">{{$bill->name}}</option>
            @endforeach
        </select>
    </div>
    <!--Категория-->
    <div class='form-group'>
        <label class='control-label'>Категория:</label>
        {!! Form::select('category_id', $category, $op->category, array('class' => 'form-control', 'ng-disabled' => 'active')) !!}

    </div>
    <div class='form-group'>
        <label class='control-label'>Сумма:</label>
        <input type='text' name='amount' class='form-control' value="{{$op->amount}}" ng-disabled="active">
    </div>  
    <input type="hidden" name="_method" value="PUT">
    <input type='hidden' name='id' ng-value='{{$op->id}}' ng-model='operationId'>
    <input type='hidden' name='type' value='{{$op->type}}'>
    <input type='hidden' name='_token' value='{{csrf_token()}}'>
    <input type='submit' name='submit' value='Сохранить' class='btn btn-primary' ng-hide="active">
    
</form>
    <button class='btn btn-warning' ng-show='active' ng-click='cancel()'>Отменить</button>
    <button class='btn btn-danger' ng-hide='active'>Удалить</button>
</div>
@stop
