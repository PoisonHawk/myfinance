@extends('layouts.main')

@section('content')

@if(isset($purchases) and count($purchases) > 0)
  <table class="table">
    <thead>
      <th>Название</th>
      <th>Категория</th>
      <th>Стоимость</th>
      <th></th>
    </thead>
    <tbody>
      @foreach($purchases as $purchase)
        <tr class='<?php echo App\Purchase::back($purchase->priority)?>'>
          <td>{{$purchase->name}}</td>
          <td>{{$purchase->category->name}}</td>
          <td style="color:green">{{$purchase->amount}}</td>
          <td>
            <a href='/purchase/{{$purchase->id}}/edit'><span class="glyphicon glyphicon-edit"></span></a>
            <span class="glyphicon glyphicon-trash"></span>
          </td>
        <tr>
      @endforeach
    </tbody>
  </table>
@else
  <p>Нет ни одной записи</p>
@endif

<a href="{{route('purchase.create')}}">Добавить</a>

@endsection