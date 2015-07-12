@extends('layouts.main')
 
@section('content')
 
<h1>Editing "{{ $bill->name}}"</h1>
<p class="lead">Edit and save this task below, or <a href="{{ route('bills.index') }}">go back to all tasks.</a></p>
<hr>
 
@include('partials.alerts.error')
 
@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif
 

<form method="POST" action='{{route('bills.update', $bill->id)}}'> 
    <div class='form-group'>
        <label class='control-label'>Название:</label>
        <input class='form-control' type='text' name='name' value='{{$bill->name}}'>
    </div>
    <div class='form-group'>
        <label class='control-label'>Начальный остаток:</label>
        <input class='form-control 'type='text' name='amount' value='{{$bill->amount}}'>
    </div>
    <input type="hidden" name="_method" value="PUT">
    <input type='hidden' name='_token' value='{{csrf_token()}}'>
    <input type='submit' class='btn btn-primary' name='submit' value='Сохранить'>
</form>
@stop