@section('right-sidebar')
    <div class='panel panel-default'>
        <div class='panel-heading'>
            <h4>Счета</h4>
        </div>
        <div class='panel-body'>
            <table class='table'>
                <tbody>
                    @foreach($user_bills as $b)
                    <tr>
                        <td>{{$b->name}}</td>
                        <td>{{$b->amount}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
   </div>
@stop

