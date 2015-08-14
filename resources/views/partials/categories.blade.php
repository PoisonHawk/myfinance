@if (isset($categories[$parent_id]))
    
    <ul>
    @foreach($categories[$parent_id] as $category)
        <li>{{$category['name']}}</li>
        @include('partials.categories', ['categories' => $category, 'parent_id' => $category['parent_id']])
    @endforeach
    </ul>
@endif




