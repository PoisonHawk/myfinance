<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Currency;
use Auth;
use DB;

class Bills extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'amount',
        'currency_id',
        'active',
        'default_wallet',
		'show',
		'saving_account',
		'saving_amount'
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
        'active',
    ];

    public function operations(){
        return $this->hasMany('operations', 'bills_id');
    }

    public function user(){
        return $this->belongsTo('users');
    }

    public function currency(){
        return $this->hasOne('App\Currency', 'id', 'currency_id');
    }

    public function scopeUserBills($query){

        if (Auth::user()) {
         return $query
                 ->where('user_id','=', Auth::user()->id)
                 ->where('active', '=', '1')
//				 ->where('saving_account', '=', 0)
                 ->get();
        }
    }

   public function scopeReportBills($query){

        $startTimestamp = mktime(0,0,0, date('m', time()), 1 , date('Y', time()));

        $from = date('Y-m-d', $startTimestamp);
        $userId = Auth::user()->id;

        $sql = <<<SQL
                select
					b.id,
                    b.name,
					b.saving_account,
					b.saving_amount,
					case when(b.saving_account = 1) then b.amount/b.saving_amount*100 else 0 end as percent,
                    (select
                            sum(amount)
                    from
                            operations
                    where operations.bills_id = b.id
                    and operations.type in ('income','transfer_in')
                    and operations.created_at >= ?) as in,
                    (select
                            sum(amount)
                    from
                            operations
                    where operations.bills_id = b.id
                    and operations.type in ('outcome', 'transfer_out')
                    and operations.created_at >= ?) as out,
                    b.amount,
                    c.iso4217 as currency
                from
                    bills b
                join
                    currency c
                on b.currency_id = c.id
                where b.user_id = ?
                and b.active = 1
				and b.show = 1
				ORDER BY b.saving_account, b.default_wallet desc, amount desc
SQL;

        $res = DB::select($sql, [$from,$from, $userId]);

        return $res;

    }


    public function scopeOperationHistory($query, $type, $from, $to){

        return $query->operations()
                ->where('type', '=', $type)
                ->where('created_at', '>=', $from);
    }

}
