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
	@include('partials.alerts.error')
    <div class='panel-body'>
		{!! Form::open(array('url' => '/auth/login', 'class' => 'form-horizontal', 'role'=>'form')) !!}

		<div class="form-group">
			<input type='text' name='email' class='form-control' placeholder='Email Address' value="{{ old('email') }}">       
		</div>    
		<div class="form-group">  
			<input type='password' name='password' class='form-control' placeholder='Password'> 
		</div>
		<div class="form-group">  
			<input type='submit' value='Login' class='btn btn-primary form-control' placeholder='Password'> 
		</div>  

		<!--<p>Not a member?  <a href="/auth/register">Register here</a>.</p>-->
		{!! Form::close() !!}
    </div>
</div>
@stop
