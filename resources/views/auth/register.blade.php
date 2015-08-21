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
  {!! Form::open(array('url' => 'auth/register', 'method'=>'POST')) !!}
  {!! Form::label('name', 'Name') !!}
  {!! Form::text('name') !!}
  {!! Form::label('email', 'E-Mail Address') !!}
  {!! Form::text('email') !!}
  {!! Form::label('password', 'Password') !!}
  {!! Form::password('password') !!}
  {!! Form::label('password_confirmation', 'Confirm password') !!}
  {!! Form::password('password_confirmation') !!}
  <div class="form-actions">
  {!! Form::submit('Register', array('class' => 'btn btn-primary')) !!}
  </div>
  {!! Form::close() !!}  
@stop