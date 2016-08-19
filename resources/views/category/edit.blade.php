@extends ('layouts.main') 

@section ('content')

<h2>Редактирование категории</h2>

@include ('partials.alerts.error')

    <form method='POST' action='{{route('category.update', $category->id)}}'>
        <div class='form-group'>
            <label class='control-label'>Название: </label>
            <input type='text' name='name' class='form-control' value="{{$category->name}}">
        </div>
        <div class='form-group'>
            <label class='control-label'>Вложенность: </label>		
            {!! Form::select('parent_id', $categories, $category->parent_id, array('class' => 'form-control')) !!}
        </div>
        <input type='hidden' name='type' value='{{$category->type}}'>
        <input type='hidden' name='_token' value='{{csrf_token()}}'>       
		<input type='hidden' name='_method' value='PUT'>    
        <input class='btn btn-primary' type='submit' name='submit' value='Сохранить'>
    </form>
@stop