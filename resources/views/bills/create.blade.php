@extends('layouts.main')

@section('content')
<h2>Новый счет</h2>
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
<form method='POST' action='{{route('bills.store')}}'>
    <div class='form-group'>
        <label class='control-label'>Название:</label>
        <input class='form-control' type='text' name='name'>
    </div>
    <div class='form-group'>
        <label class='control-label'>Начальный остаток:</label>
        <input class='form-control 'type='text' name='amount'>
    </div>
    <input type='hidden' name='_token' value='{{csrf_token()}}'>
    <input type='submit' class='btn btn-primary' name='submit' value='Добавить'>
</form>

@stop