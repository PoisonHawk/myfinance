@extends('layouts.main')
 


@section('content')
 
<h1>Myfinance</h1>
<p class="lead">This is apllication for control your finances.</p>
<p>There are is developing yet</p>
<hr>

<a href='{{route('operations.create', 'type=income')}}' class='btn btn-success'>Доход</a>
<a href='{{route('operations.create', 'type=outcome')}}' class='btn btn-danger'>Расход</a>
<a href='{{route('transfers.create')}}' class='btn btn-primary'>Перевод</a> 
@stop