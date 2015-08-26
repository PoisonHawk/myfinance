<div class="modal fade" id="modal_{{$type}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Новый {{$title}}</h4>
      </div>
      <div class="modal-body">        
        <form method='POST' action='{{route('operations.store')}}' name='operationForm'>
            <div class='form-group'>
                <label class='control-label'>Дата:</label>
                <input type='text' name='created' class='form-control' value='{{$today}}'>
            </div>    
            <!--Счет-->
            <div class='form-group'>
                <label class='control-label'>Cчет:</label>
                <select name='bills_id' class='form-control'>
                    @foreach($bills as $bill)
                    <option value="{{$bill->id}}">{{$bill->name}}</option>
                    @endforeach
                </select>
            </div>
            <!--Категория-->
            <div class='form-group'>
                <label class='control-label'>Категория:</label>
                {!! Form::select('category_id', $categories[$type], null , ['class'=>'form-control']) !!}

            </div>
            <div class='form-group'>
                <label class='control-label'>Сумма:</label>
                <input type='text' name='amount' class='form-control' ng-model="amount"  required>
                <div ng-messages='operationForm.amount.$error'>
                    <div ng-message="required">Поле не может быть пустым</div>                    
                </div>
            </div>    
            <input type='hidden' name='type' value='{{$type}}'>
            <input type='hidden' name='redirect' value='/'>
            <input type='hidden' name='_token' value='{{csrf_token()}}'>
            <input type='submit' name='submit' value='Сохранить' class='btn btn-primary form-control'>
        </form>
      </div>
    </div>
  </div>
</div>
