<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;
use DB;

class Operation extends Model
{
    //
    protected $fillable = [
        'created',
        'user_id',
        'bills_id',
        'category_id',
        'type',
        'amount',
    ];
    
    public function bill(){
        return $this->belongsTo('App\Bills', 'bills_id');
    }
    
    public function category(){
        return $this->belongsTo('App\Category');
    }
    
    //todo обработка ошибок
    public function operationTransact($data){
                
        $amount = str_replace(',','.',$data['amount']);
                
        //транзакция
        DB::beginTransaction();
        try{
                      
            $this->created = $data['created'];
            $this->user_id = Auth::user()->id;
            $this->bills_id = $data['bills_id'];
            $this->category_id = $data['category_id'];
            $this->type = $data['type'];
            $this->amount = $amount;
            $this->active = 1;
            $this->save();
                   
            $amount = $data['type'] == 'income' ? $amount : -$amount;
            
            $this->bill->amount = floatval($this->bill->amount) + floatval($amount);
            $this->bill->save();
            
        } catch (Exception $e) {
            
            // todo обработка ошибки
            session::flash('flash_message', 'Невозможно провести операцию');
            //throw new Exception($e->getMessage());
            DB:rollback();
        }
                        
        DB::commit();
        //конец транзакции
        
    }
    
    public function scopeOutcomes(){
        $startTimestamp = mktime(0,0,0, date('m', time()), 1 , date('Y', time()));
        
        $from = date('Y-m-d', $startTimestamp);
        
        $res = DB::table('operations')
                ->join('categories', 'operations.category_id', '=', 'categories.id')
                ->select('categories.name', 'categories.parent_id', 'operations.amount')
                ->where('operations.user_id', '=', Auth::user()->id)
                ->where('operations.type','=','outcome')
                ->where('operations.created_at', '>', $from)
                ->get();            
//          dd($res);       
       
        
        $result = [];
        
        $total = 0;
        
        foreach($res as $r) {
            
            if ($r->parent_id == 0 ) {
                
                $cat = $r->name;                
                
            } else {
                $cat = Category::find($r->parent_id)->name;
            }
            
            if (!isset($result[$cat])) {
                $result[$cat] = [
                    'total' => 0,
                    'items' => [],
                ];
            }
            
            $result[$cat]['items'][$r->name] = $r->amount; 
            $result[$cat]['total'] += $r->amount;
            $total += $r->amount; 
        }
        
//        dd($result);
        
        $data = [
            'result' => $result,
            'total' => $total,
        ];
        
        return $data;
    }
    
    /**
     * Расходы за сегодняшний день
     * @param type $query
     * @return type
     */
    public function scopeOutcomeToday($query){
                       
        if (Auth::user()) {
        
        return $query->where('type','=','outcome')
                ->where('user_id','=', Auth::user()->id)
                ->where('created', '>=', date('Y-m-d'))
                ->orderBy('created', 'desc')->get();
        
        }
    }
    
    public function scopeReportBills($query){
        
        $startTimestamp = mktime(0,0,0, date('m', time()), 1 , date('Y', time()));
        
        $from = date('Y-m-d', $startTimestamp);
        
        
        $sql = <<<SQL
                select
                    b.name,
                    case when o.type='income' then sum(o.amount) end as `in`,
                    case when o.type='outcome' then sum(o.amount) end as `out`,
                    b.amount
                from 
                    operations o
                join
                    bills b
                on b.id = o.bills_id
                where o.user_id = ?
                and o.created_at >= ?
                group by o.bills_id
SQL;
        
        $res = DB::select($sql, [Auth::user()->id, $from]);
        
        return $res;
        
    }
    
    
}
