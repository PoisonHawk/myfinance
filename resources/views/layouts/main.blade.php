<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Myfinance</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
		<link rel="stylesheet" href="/css/main.css">
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<link rel='stylesheet' href='/js/jquery.datetimepicker.css'>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.12/angular.min.js"></script>
		<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.3.12/angular-messages.js'></script>
		<script src="/js/chartjs/Chart.js"></script>
		<script src="/js/app.js"></script>
		<script src="/js/app/services/reportFactory.js"></script>
		<script src="/js/app/services/billFactory.js"></script>
		<script src="/js/app/controllers/ctrlReport.js"></script>
		<script src="/js/app/controllers/BillCtrl.js"></script>
		<script src="/js/app/controllers/OperationsCtrl.js"></script>
		<script src="/js/app/controllers/categoryCtrl.js"></script>
		<script src="/js/app/controllers/PurchaseCtrl.js"></script>
		<script src='/js/jquery.datetimepicker.js'></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	</head>
	<body ng-app='app'>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header col-md-2 ">
					<a class="navbar-brand" href="/">Myfinance &beta;</a>
				</div>
				<div>
					<ul class="nav navbar-nav transaction-actions">
						<li><a href='#' class='action-income' data-toggle="modal" data-target="#modal_income"><span class='glyphicon glyphicon-plus'> Доход</span></a></li>
						<li><a href='#' class='action-outcome' data-toggle="modal" data-target="#modal_outcome"><span class='glyphicon glyphicon-minus'> Расход</span></a><li>
						<li><a href='#' class='action-transfer' data-toggle='modal' data-target='#modal_transfer'><span class="glyphicon glyphicon-transfer"> Перевод</span></a><li>

						<!-- Modal Income-->
						@include('partials.operations.modal', ['type'=>'income', 'today'=>$today, 'bills'=>$bills, 'categories'=> $categories, 'title' => 'доход'])
						@include('partials.operations.modal', ['type'=>'outcome', 'today'=>$today, 'bills'=>$bills, 'categories'=> $categories, 'title'=> 'расход'])
						@include('partials.operations.modaltransfer', [ 'today'=>$today, 'bills'=>$bills, 'categories'=> $categories, 'title'=> 'расход'])
					</ul>
				</div>
				<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}} <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="/auth/logout">Выйти</a></li>
							</ul>
						</li>
					</ul>					
				</div>
			</div>
		</nav>
		<main>
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-3 col-md-2 sidebar">						
						<ul class='nav nav-sidebar'>
							<li></span><a href="/"><span class="glyphicon glyphicon-home"> Главная</a></li>
							<li><a href="/bill"><span class="glyphicon glyphicon-credit-card"> Счета</a></li>
							<li><a href="{{route('category.index')}}"><span class="glyphicon glyphicon-list"> Категории</a></li>
							<li><a href="{{route('operations.index')}}"><span class="glyphicon glyphicon-transfer"> Операции</a></li>
							<li><a href="{{route('purchase.index')}}"><span class="glyphicon glyphicon-shopping-cart"> Запланированные покупки</a></li>
							<!--<li><a href='#'><span class="glyphicon glyphicon-stats"> Отчеты</a></li>-->
							<!--<li><a href='#'>Планирование</a></li>-->
						</ul>										
					</div>
					<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
						@yield('content')
					</div>
				</div>
			</div>
		</main>

	</body>
</html>
