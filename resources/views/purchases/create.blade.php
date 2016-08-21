@extends('layouts.main')

@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
<form method='POST' action='{{route('purchase.store')}}'>
    <div class='form-group'>
        <label class='control-label'>Название:</label>
        <input class='form-control' type='text' name='name' value={{ old('name') }}>
    </div>
    <div class='form-group'>
        <label class='control-label'>Стоимость:</label>
        <input class='form-control 'type='text' name='amount' value={{ old('amount') }}>
    </div>
    <div class='form-group'>
        <label class='control-label'>Категория:</label>
        <!-- <select name='category_id'>
          @foreach($categories as $id => $name)
            <option value='{{$id}}'>{{$name}}</option>
          @endforeach
        </select> -->
        {!! Form::select('category_id', $categories, null , ['class'=>'form-control']) !!}
    </div>
    <div class='form-group'>
        <label class='control-label'>Важность:</label>
        <label class='radio-inline'>
          <input class=' 'type='radio' name='priority' value='1' checked>1
        </label>
        <label class='radio-inline'>
          <input class=' 'type='radio' name='priority' value='2'>2
        </label>
        <label class='radio-inline'>
          <input class=' 'type='radio' name='priority' value='3'>3
        </label>
        <label class='radio-inline'>
          <input class=''type='radio' name='priority' value='4'>4
        </label>
    </div>
    <input type='hidden' name='_token' value='{{csrf_token()}}'>
    <input type='submit' class='btn btn-primary' name='submit' value='Добавить'>
</form>

@stop
