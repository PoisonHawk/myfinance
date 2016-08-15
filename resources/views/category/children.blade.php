<ul ng-show=" {{$parent}} == parent" >
@foreach ($categories as $category)
      <li class="list-group-item" >{{ $category->name }}</li>
      @if( isset($category->children) && count($category->children ) >=1 )
        @include('category.children', array('categories' => $category->children))
      @endif  
@endforeach
</ul>

