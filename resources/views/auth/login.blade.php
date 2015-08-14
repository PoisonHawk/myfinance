<style>
    .panel{
        max-width:330px;
        margin: 0 auto;
        padding:25px;
    }
</style>
@extends('layouts.main')

@section('left-sidebar')
@stop

@section('content')
<div class='panel panel-primary'>
    <div class='panel-body'>
  {!! Form::open(array('url' => '/auth/login', 'class' => 'form-horizontal', 'role'=>'form')) !!}
  <!--<h1>Please Log in</h1>-->
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

  <div class="form-group">
      <input type='text' name='email' class='form-control' placeholder='Email Address'>       
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

@section('right-sidebar')
@stop