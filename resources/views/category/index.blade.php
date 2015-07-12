@extends ('layouts.main')

@section ('content')

<div class="navbar-right">
    <a href="{{url('category/outcome')}}">Расходы</a>
    <a href="{{url('category/income')}}">Доходы</a> 
</div>


<h2>Категории {{$cat_name}}</h2>

<table class='table'>
    <tbody>
    @forelse($categories as $category)
    <tr>
        <td>{{$category->name}}</td>
    </tr>
    @empty
    <tr>Нет ни одной категории</tr>
    @endforelse
    </tbody>
</table>
<a href="{{route('category.create', 'type='.$type)}}" class='btn btn-primary'>Добавить</a>
@stop

