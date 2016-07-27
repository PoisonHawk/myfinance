@extends('layouts.auth')

@section('content')
  <h1>Please Register</h1>
   @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="col-md-6">
  {!! Form::open(array('url' => 'auth/register', 'method'=>'POST', )) !!}
  <div class="form-group">
  {!! Form::label('name', 'Name') !!}
  <input type='text' name='name' value="{{old('name')}}" placeholder="John" class="form-control">
  </div>
  <div class="form-group">
  {!! Form::label('email', 'E-Mail Address') !!}
  <input type='text' name='email' value="{{old('email')}}" placeholder="john.smith@gmail.com" class="form-control">
</div>
<div class="form-group">
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
@stop
