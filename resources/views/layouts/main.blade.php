<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Myfinance</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.12/angular.min.js"></script>
<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.3.12/angular-messages.js'></script>
<script src="/js/chartjs/Chart.js"></script>

<script src="/js/app.js"></script>

<script src="/js/app/services/reportFactory.js"></script>
<script src="/js/app/services/billFactory.js"></script>
<script src="/js/app/controllers/ctrlReport.js"></script>
<script src="/js/app/controllers/BillCtrl.js"></script>

<link rel='stylesheet' href='/js/jquery.datetimepicker.css'>
<script src='/js/jquery.datetimepicker.js'></script>
<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-bootstrap/0.5pre/assets/css/bootstrap.min.css'></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body ng-app='app'>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/">Myfinance</a>
    </div>
    <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">      
        <?php if (Auth::user()):?>
            <ul class="nav navbar-nav">              
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="/auth/logout">Выйти</a></li>
                    </ul>
                </li>
            </ul>
        <?php endif;?>
    </div>
  </div>
</nav>
 
<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 col-md-2 sidebar">
                <ul class='nav nav-sidebar'>
                    <li><a href="/bill">Счета</a></li>
                    <li><a href="{{route('category.index')}}">Категории</a></li> 
                    <li><a href="{{route('operations.index')}}">Операции</a></li>                    
                    <li><a href='#'>Отчеты</a></li>
                    <!--<li><a href='#'>Планирование</a></li>-->
                </ul>
            </div>
            <div class="col-sm-6">
                @yield('content')
            </div>
            <div class="col-sm-4">
                @section('right-sidebar')
                    @include('partials.outcomes')
                @show
            </div>
        </div>
    </div>
</main>
 
</body>
</html>
