<div class="panel panel-default">
    <div class='panel-heading'>

        <h4><span class="glyphicon glyphicon-stats">&nbsp;</span>Запланированные расходы</h4>
    </div>
    <table class='table' >
        <tbody>
        @foreach($purchases as $purchase)
            <tr>
                <td>{{$purchase->name}}</td>
                <td>{{$purchase->amount}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2"><a href="/purchase">Посмотреть все</a></td>
        </tr>
        </tbody>
    </table>
</div>