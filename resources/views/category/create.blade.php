@extends ('layouts.main') 

@section ('content')

<h2>Новая категория {{$type=='income' ? 'доходов' : 'расходов'}}</h2>

@include ('partials.alerts.error')

    <form method='POST' action='{{route('category.store')}}'>
        <div class='form-group'>
            <label class='control-label'>Название: </label>
            <input type='text' name='name' class='form-control'>
        </div>
        <div class='form-group'>
            <label class='control-label'>Вложенность: </label>
            {!! Form::select('parent_id', $categories, null, array('class' => 'form-control')) !!}
        </div>
        <input type='hidden' name='type' value='{{$type}}'>
        <input type='hidden' name='_token' value='{{csrf_token()}}'>        
        <input class='btn btn-primary' type='submit' name='submit' value='Сохранить'>
    </form>
@stop