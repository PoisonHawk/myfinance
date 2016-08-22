@extends('layouts.main')

@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
<form method='POST' action='{{route('purchase.update',['id' => $purchase->id ])}}'>
    <div class='form-group'>
        <label class='control-label'>Название:</label>
        <input class='form-control' type='text' name='name' value={{ $purchase->name or old('name') }}>
    </div>
    <div class='form-group'>
        <label class='control-label'>Стоимость:</label>
        <input class='form-control 'type='text' name='amount' value={{$purchase->amount or old('amount') }}>
    </div>
    <div class='form-group'>
        <label class='control-label'>Категория:</label>
        {!! Form::select('category_id', $categories, $purchase->category->id , ['class'=>'form-control']) !!}
    </div>
    <div class='form-group'>
        <label class='control-label'>Важность:</label>
        @for($i=1; $i<=4; $i++)
        <label class='radio-inline'>
          <input class=' 'type='radio' name='priority' value='{{$i}}' {{ ($purchase->priority == $i ? 'checked' : '')}}>{{$i}}
        </label>
        @endfor
    </div>
    <input type='hidden' name='_token' value='{{csrf_token()}}'>
    <input type='hidden' name='_method' value='PUT'>
    <input type='submit' class='btn btn-default' name='submit' value='Сохранить'>
</form>

@stop
