@extends ('layouts.main')

@section ('content')
<div ng-controller="categoryCtrl" class="panel panel-default">

	<div class="panel-heading">
		<h2>Категории</h2>
		
		<a href="{{route('category.create', 'type='.$type)}}" class='btn btn-success pull-right'>Добавить</a>
		
		<ul class="nav nav-tabs">
			<li role="presentation" class="{{ $type == 'income' ? 'active' : '' }}"><a href="{{url('category/income')}}">Доходы</a></li> 
			<li role="presentation" class="{{ $type == 'outcome' ? 'active' : '' }}"><a href="{{url('category/outcome')}}">Расходы</a></li>		   
		</ul>
	</div>

    <ul class="list-group"> 
    @forelse($categories as $category)
        <li class="list-group-item list-group-item-warning" >
			<span ng-click="showItems({{$category->id}})">
			@if( isset( $category->children ) && count($category->children ) >=1 )
				<span ng-class="{'glyphicon glyphicon-plus': {{$category->id}} !== parent, 'glyphicon glyphicon-minus': {{$category->id}} == parent}" ></span>
			@endif		
			&nbsp;{{$category->name}}		
			</span>
			<a href="#"><span class="glyphicon glyphicon-trash pull-right"></span></a>  
			<a href="#"><span class="glyphicon glyphicon-edit pull-right"></span></a>  
		</li>
        @if( isset( $category->children ) && count($category->children ) >=1 )
            @include('category.children', ['categories' => $category->children, 'parent' => $category->id])
        @endif
    @empty
        <li>Нет ни одной категории</li>
    @endforelse
    </ul>	
</div>
@stop

