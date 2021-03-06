@extends('layouts.main')

@section('content')
<h2>Мои счета</h2>
@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif
<script>
   
     $(document).ready(function(){
         
         $('.remove_bill').click(function(){
             $(this).next('form').submit();
         })
         
     })  

</script>
<table class='table table-striped table-condensed table-hover'>
    <thead>        
        <th>Название</th>
        <th>Сумма</th>
        <th>Валюта</th>
    </thead>
    <tbody>
        @forelse($bills as $bill)
        <tr onclick="document.location='{{route('bills.edit', $bill->id)}}'">            
            <td>{{$bill->name}}</td>
            <td>{{$bill->amount}}</td>
            <td>{{$bill->currency->iso4217}}</td>
<!--            <td><a href='{{route('bills.edit', $bill->id)}}' class='btn btn-primary'><span class="glyphicon glyphicon-edit"></span></a>
            
                <button class="remove_bill btn btn-danger"><span class="glyphicon glyphicon-trash"></button>
                <form method="POST" action="{{route('bills.destroy', $bill->id)}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="_method" value="DELETE">                  
                </form>
            </td>-->
        </tr>
        @empty
        <tr><td>Нет ни одного счета</td></tr>
        @endforelse
    </tbody>
</table>
<a href='#' data-toggle="modal" data-target='#modal_bill' class='btn btn-primary'>Добавить счет</a>

@include('partials.bills.create')

@stop
