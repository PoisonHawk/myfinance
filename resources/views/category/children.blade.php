<ul ng-show=" {{$parent}} == parent" >
@foreach ($categories as $category)
      <li class="list-group-item" >{{ $category->name }}
	  <a href="#" ng-click="remove({{$category->id}})"><span class="glyphicon glyphicon-trash pull-right"></span></a>  
			<a href="/category/{{$category->id}}/edit"><span class="glyphicon glyphicon-edit pull-right"></span></a>  
	  </li>
	  
      @if( isset($category->children) && count($category->children ) >=1 )
        @include('category.children', array('categories' => $category->children))
      @endif  
@endforeach
</ul>

