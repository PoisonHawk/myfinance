@if (isset($categories[$parent_id]))    
    <ul>
    {{dd($categories[$parent_id])}}
    @foreach($categories[$parent_id] as $category)
        <li>{{$category['name']}}</li>
        @include('partials.categories', ['categories' => $category, 'parent_id' => $category['parent_id']])
    @endforeach
    </ul>
@endif




