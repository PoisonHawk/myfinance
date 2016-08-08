@extends('layouts.main')

@section('content')

@if(isset($purchases) and count($purchases) > 0)
  <table class="table">
    <thead>
      <th>Название</th>
      <th>Стоимость</th>
    </thead>
    <tbody>
      @foreach($purchases as $purchase)
        <tr>
          <td>{{$purchase->name}}</td>
          <td>{{$purchase->amount}}</td>
        <tr>
      @endforeach
    </tbody>
  </table>
@else
  <p>Нет ни одной записи</p>
@endif

<a href="{{route('purchase.create')}}">Добавить</a>

@endsection
