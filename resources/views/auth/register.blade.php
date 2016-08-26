<style>
    .panel{
        max-width:500px;
        margin: 0 auto;
        padding:25px;
    }
</style>
@extends('layouts.auth')

@section('content')
<div class='panel panel-primary'>
	<h1>Регистрация</h1>
	@include('partials.alerts.error')
	<div class='panel-body'>
		{!! Form::open(array('url' => 'auth/register', 'method'=>'POST', )) !!}
		<div class="form-group {{  $errors->has('name') ? 'has-error' : ''}}">
			{!! Form::label('name', 'Name') !!}
			<input type='text' name='name' value="{{old('name')}}" placeholder="John" class="form-control">
		</div>
		<div class="form-group {{  $errors->has('email') ? 'has-error' : ''}}">
			{!! Form::label('email', 'E-Mail Address') !!}
			<input type='text' name='email' value="{{old('email')}}" placeholder="john.smith@gmail.com" class="form-control">
		</div>
		<div class="form-group {{  $errors->has('password') ? 'has-error' : ''}}">
			{!! Form::label('password', 'Password') !!}
			<input type='password' name='password'class="form-control">
		</div>
		<div class="form-group">
			{!! Form::label('password_confirmation', 'Confirm password') !!} 
			<input type='password' name='password_confirmation'class="form-control">
		</div>

		<div class="form-actions">
			{!! Form::submit('Register', array('class' => 'btn btn-primary')) !!}
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop
