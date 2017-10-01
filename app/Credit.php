<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Bills;

class Credit extends Model
{

    public function bill(){
        return $this->belongsTo('App\Bills', 'bill_id');
    }
    //todo оптимизировать
    
    public static function increase($billId, $amount){

        $res = DB::update('update credits set amount = amount + :amount where user_id = :uid', [
            'amount' => abs($amount),
            'uid' => Auth::id()
        ]);


        if ($res == 0) {

            DB::table('credits')
                ->insert(['amount'=>$amount, 'bill_id'=> $billId, 'user_id'=> Auth::id(), 'created_at'=> Carbon::now(), 'updated_at'=> Carbon::now() ]);
        }

    }

    //todo оптимизировать
    public static function decrease($billId, $amount){

        $res = DB::table('credits')
            ->where('user_id', Auth::id())
            ->where('bill_id', $billId)
            ->select('id', 'amount')
            ->get();

        if(empty($res)){
            return;
        }

        $creditAmount = $res[0]->amount;
//        dd($creditAmount);

        $amount = min($amount, $creditAmount);

//        $res = DB::table('credits')->where('id', $res[0]->id)->update(['amount', $amount]);

        $res = DB::update('update credits set amount = amount - :amount where id = :id', [
            'amount' => abs($amount),
            'id' =>  $res[0]->id
        ]);

//        dd($res);


    }
}
