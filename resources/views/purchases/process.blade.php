@extends('layouts.main')

@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
<form method='POST' action='{{route('purchase.process',['id' => $purchase->id ])}}'>
    <div class='form-group'>
        <label class='control-label'>Название:</label>
        <input class='form-control' type='text' name='name' value={{ $purchase->name or old('name') }}>
    </div>
    <div class='form-group'>
        <label class='control-label'>Стоимость:</label>
        <input class='form-control 'type='text' name='amount' value={{$purchase->amount or old('amount') }}>
    </div>
	<div class='form-group'>
        <label class='control-label'>Счет:</label>
			<select name="bill_id" class="form-control">
				@foreach($bills as $bill)
					<option value="{{$bill->id}}" {{ ($bill->default_wallet == 1) ? 'selected' : '' }}>{{$bill->name}}</option>
				@endforeach
			</select>        
    </div> 
    <div class='form-group'>
        <label class='control-label'>Категория:</label>
        {!! Form::select('category_id', $categories, $purchase->category->id , ['class'=>'form-control']) !!}
    </div>    
    <input type='hidden' name='_token' value='{{csrf_token()}}'>
    <!--<input type='hidden' name='_method' value='PUT'>-->
    <input type='submit' class='btn btn-success' name='submit' value='Провести операцию'>	
</form>
@stop
