@extends ('layouts.main')

@section ('content')
<div ng-controller="categoryCtrl">

<div class="navbar-right">
    <a href="{{url('category/outcome')}}">Расходы</a>
    <a href="{{url('category/income')}}">Доходы</a> 
</div>


<h2>Категории {{$cat_name}}</h2>

    <ul class="list-group"> 
    @forelse($categories as $category)
        <li class="list-group-item list-group-item-warning" ng-click="showItems()">{{$category->name}}</li>
        @if( isset( $category->children ) && count($category->children ) >=1 )
            @include('category.children', ['categories' => $category->children])
        @endif
    @empty
        <li>Нет ни одной категории</li>
    @endforelse
    </ul>

<a href="{{route('category.create', 'type='.$type)}}" class='btn btn-primary'>Добавить</a>
</div>
@stop

