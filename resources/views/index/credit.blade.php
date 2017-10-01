<div class="panel panel-default">
    <div class='panel-heading'>

        <h4><span class="glyphicon glyphicon-stats">&nbsp;</span>Долги</h4>
    </div>
    <table class='table' >
        <tbody>
        @forelse($credits as $credit)
            <tr>
                <td>{{$credit->name}}</td>
                <td>{{$credit->debt_amount}}</td>
            </tr>
        @empty
            <tr>
                <td>Нет долгов!!!</td>
            </tr>
        @endforelse
        <tr>
            {{--<td colspan="2"><a href="/purchase">Посмотреть все</a></td>--}}
        </tr>
        </tbody>
    </table>
</div>