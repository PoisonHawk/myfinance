<div class="modal fade" id="modal_transfer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Новый перевод</h4>
      </div>
      <div class="modal-body">
        <form method='POST' action='{{route('transfers.store')}}'>
            <div class='form-group'>
                <label class='control-label'>Дата:</label>
                <input type='text' name='created' class='form-control' value='{{$today}}'>
            </div>
            <!--Счет-->
            <div class='form-group'>
                <label class='control-label'>Cчет отправитель:</label>
                    <select name='bill_from_id' class='form-control'>
                    @foreach($bills as $bill)
                    <option value="{{$bill->id}}" {{$bill->default_wallet == 1 ? 'selected' : ''}}>{{$bill->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class='form-group'>
                <label class='control-label'>Cчет получатель:</label>
                    <select name='bill_to_id' class='form-control'>
                    @foreach($bills as $bill)
                    <option value="{{$bill->id}}">{{$bill->name}}</option>
                    @endforeach
                </select>

            </div>
            <div class='form-group'>
                <label class='control-label'>Сумма:</label>
                <input type='text' name='amount' class='form-control'>
            </div>
            <input type='hidden' name='type' value='transfer'>
            <input type='hidden' name='redirect' value='/'>
            <input type='hidden' name='_token' value='{{csrf_token()}}'>
            <input type='submit' name='submit' value='Сохранить' class='btn btn-primary'>
        </form>
      </div>
    </div>
  </div>
</div>

