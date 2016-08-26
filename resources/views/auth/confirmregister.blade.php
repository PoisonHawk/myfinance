
@extends('layouts.auth')

@section('content')
	<div class='container text-center'>
	<h2>Проверьте свой почтовый ящик</h2>
	<p>Мы отправили письмо на {{$email}}. Для завершения регистрации следуйте инструкциям в письме.</p>
	</div>
@stop
