@extends ('layouts.main')

@section ('content')
<div class="col-md-6">
	@include('category.category', ['categories'=>$outcome, 'title'=>$cat_name['outcome'], 'type'=>'outcome'])
</div>
<div class="col-md-6">
	@include('category.category', ['categories'=>$income, 'title'=>$cat_name['income'], 'type'=>'income'])
</div>
@stop

