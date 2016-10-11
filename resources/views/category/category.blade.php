<div ng-controller="categoryCtrl" class="panel panel-default">

	<div class="panel-heading ">
		<h3 class="pull-left">{{$title}}</h3>
		
		<p><a href="{{route('category.create', 'type='.$type)}}" class='btn btn-success pull-right'>Добавить</a></p>
		<div class="clearfix"></div>

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
			
			<a href="#" ng-click="remove({{$category->id}})"><span class="glyphicon glyphicon-trash pull-right"></span></a>  
			<a href="/category/{{$category->id}}/edit"><span class="glyphicon glyphicon-edit pull-right"></span></a>  
		</li>
@if( isset( $category->children ) && count($category->children ) >=1 )
    @include('category.children', ['categories' => $category->children, 'parent' => $category->id])
        @endif
    @empty
        <li>Нет ни одной категории</li>
@endforelse
    </ul>

</div>