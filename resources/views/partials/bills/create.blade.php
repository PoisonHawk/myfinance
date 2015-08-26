<div class="modal fade" id="modal_bill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Новый счет</h4>
      </div>
      <div class="modal-body">        
        <form method='POST' action='{{route('bills.store')}}' name='operationForm'>
            <div class='form-group'>
                <label class='control-label'>Название:</label>
                <input class='form-control' type='text' name='name'>
            </div>
            <div class='form-group'>
                <label class='control-label'>Валюта:</label>
                <select class='form-control 'type='text' name='currency_id'>
                    @foreach ($currency as $id => $name)
                    <option value="{{$id}}">{{$name}}</option>
                    @endforeach
                </select>
            </div>
            <div class='form-group'>
                <label class='control-label'>Начальный остаток:</label>
                <input class='form-control 'type='text' name='amount'>
            </div>
            
            <input type='hidden' name='redirect' value='/'>
            <input type='hidden' name='_token' value='{{csrf_token()}}'>
            <input type='submit' class='btn btn-primary form-control' name='submit' value='Добавить'>           
        </form>
      </div>
    </div>
  </div>
</div>