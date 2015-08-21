<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Bills extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'amount',
    ];
    
   public function scopeUserBills($query){    
       
       if (Auth::user()) {       
        return $query->where('user_id','=', Auth::user()->id)->get();       
       }
   }
   
   public function scopeReportBills($query){
        
        $startTimestamp = mktime(0,0,0, date('m', time()), 1 , date('Y', time()));
        
        $from = date('Y-m-d', $startTimestamp);
        $userId = Auth::user()->id;        
        
        $sql = <<<SQL
                select
                    b.name,
                    (select 
                            sum(amount)
                    from 
                            operations
                    where operations.bills_id = b.id
                    and (operations.type = 'income')
                    and operations.user_id = ?   
                    and operations.created_at >= ?) as `in`,
                    (select 
                            sum(amount)
                    from 
                            operations
                    where operations.bills_id = b.id
                    and operations.type = 'outcome'
                    and operations.user_id = ?    
                    and operations.created_at >= ?) as `out`,		
                    b.amount
                from 
                    bills b
                where b.user_id = ?
SQL;
        
 
                
        $res = DB::select($sql, [$userId, $from, $userId, $from, $userId]);
        
//        dd($res);
        
        return $res;
        
    }
    
}
