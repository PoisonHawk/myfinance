@extends ('layouts.main')

@section('content')
<h2>Новая операция ({{$type=='income' ? 'доход' : 'расход'}})</h2>

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
<form method='POST' action='{{route('operations.store')}}'>
    <div class='form-group'>
        <label class='control-label'>Дата:</label>
        <input type='text' name='created' class='form-control' value='{{$today}}'>
    </div>
    <!--Счет-->
    <div class='form-group'>
        <label class='control-label'>Cчет:</label>
        <select name='bills_id' class='form-control'>
            @foreach($bills as $bill)
            <option value="{{$bill->id}}" {{ $bill->default_wallet == 1 ? 'selected' : ''}}>{{$bill->name}}</option>
            @endforeach
        </select>
    </div>
    <!--Категория-->
    <div class='form-group'>
        <label class='control-label'>Категория:</label>
        {!! Form::select('category_id', $category, null , ['class'=>'form-control']) !!}

    </div>
    <div class='form-group'>
        <label class='control-label'>Сумма:</label>
        <input type='text' name='amount' class='form-control'>
    </div>
    <input type='hidden' name='type' value='{{$type}}'>
    <input type='hidden' name='_token' value='{{csrf_token()}}'>
    <input type='submit' name='submit' value='Сохранить' class='btn btn-primary'>
</form>
@stop
