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
</head>
<body ng-app='app'>
 
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/">Myfinance</a>
    </div>
    <div class="nav navbar-nav navbar-right">      
        <?php if (Auth::user()):?>
            <li><a href="{{route('bills.index')}}">Счета</a></li>
            <li><a href="{{route('operations.index')}}">Операции</a></li>
            <li><a href="{{route('category.index')}}">Категории</a></li>        
            <li><a href='/auth/logout'>Выход</a></li>
        <?php endif;?>
    </div>
  </div>
</nav>
 
<main>
    <div class="container">
        @yield('content')
    </div>
</main>
 
</body>
</html>
