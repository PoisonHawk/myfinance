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
<script src="/js/app.js"></script>

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
            <li><a href="{{route('bills.index')}}">Счета</a></li>
            <li><a href="{{route('operations.index')}}">Операции</a></li>
            <li><a href='{{route('transfers.index')}}'>Перемещения</a></li>
            <li><a href='#'>Отчеты</a></li>
            <li><a href="{{route('category.index')}}">Категории</a></li>   
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
            <div class="col-sm-3">
                @section('left-sidebar')
                    <p>Сайдбар</p>
                @show
            </div>
            <div class="col-sm-6">
                @yield('content')
            </div>
            <div class="col-sm-3">
                @section('right-sidebar')
                    @include('partials.bills')
                @show
            </div>
        </div>
    </div>
</main>
 
</body>
</html>
