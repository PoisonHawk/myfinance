@extends ('layouts.main')

@section ('content')
<div ng-controller="categoryCtrl" class="panel panel-default">

<div class="panel-heading">
	<h2>Категории</h2>
	<ul class="nav nav-tabs">
	  <li role="presentation" class="{{ $type == 'outcome' ? 'active' : '' }}"><a href="{{url('category/outcome')}}">Расходы</a></li>
	  <li role="presentation" class="{{ $type == 'income' ? 'active' : '' }}"><a href="{{url('category/income')}}">Доходы</a></li>  
	</ul>
</div>

		

    <ul class="list-group"> 
    @forelse($categories as $category)
        <li class="list-group-item list-group-item-warning" ng-click="showItems({{$category->id}})">
			
			{{$category->name}}		
		</li>
        @if( isset( $category->children ) && count($category->children ) >=1 )
            @include('category.children', ['categories' => $category->children, 'parent' => $category->id])
        @endif
    @empty
        <li>Нет ни одной категории</li>
    @endforelse
    </ul>

<a href="{{route('category.create', 'type='.$type)}}" class='btn btn-primary'>Добавить</a>
</div>
@stop

