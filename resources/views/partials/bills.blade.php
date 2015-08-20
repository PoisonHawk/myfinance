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


    <div class='panel panel-default'>
        <div class='panel-heading'>
            <h4>Траты за сегодня</h4>
        </div>
        <div class='panel-body'>
            <table class='table'>
                <tbody>
                    @foreach($user_ouctomes as $o)
                    <tr>
                        <td>{{$o->created_at->format('H:i')}}</td>
                        <td>{{$o->bill->name}}</td>
                        <td>{{$o->category->name}}</td>
                        <td>{{$o->amount}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
   </div>
@stop

