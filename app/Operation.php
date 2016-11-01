<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;
use DB;
use Session;

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
        return $this->belongsTo('App\Category')->withTrashed();
    }
    
   
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
            $this->amount = round($amount, 2);
            $this->active = 1;
            $this->save();
                   
            $amount = $data['type'] == 'income' ? $amount : -$amount;
            
            $this->bill->amount = floatval($this->bill->amount) + floatval($amount);
            $this->bill->save();
            
        } catch (\Exception $e) {
			
			DB::rollBack();
            throw new \Exception($e->getMessage());
            
        }
                        
        DB::commit();
        //конец транзакции
        
    }
    
    public function outcomes($type, $dateFrom = NULL, $dateTo = NULL){

        $startTimestamp = mktime(0,0,0, date('m', time()), 1 , date('Y', time()));
        		
        $dateFrom = !is_null($dateFrom) ? $dateFrom : date('Y-m-d', $startTimestamp);
        $dateTo = !is_null($dateTo) ? $dateTo : date('Y-m-d', time());
        
        $res = DB::table('operations')
                ->join('categories', 'operations.category_id', '=', 'categories.id')
                ->select('categories.name', 'categories.parent_id', 'operations.amount')
                ->where('operations.user_id', '=', Auth::user()->id)
                ->where('operations.type','=', $type)
                ->where('operations.created', '>=', $dateFrom)
                ->where('operations.created', '<=', $dateTo)
                ->get(); 

		$result = [];
        
        $total = 0;
        $num = 0;        
    		
        foreach($res as $r) {
            
            if ($r->parent_id == 0 ) {
                
                $cat = $r->name ;                
                
            } else {
                $cat = Category::withTrashed()->find($r->parent_id)->name;
            }
	            
            if (!isset($result[$cat])) {
                $result[$cat] = [
                    'name' => $cat,
                    'total' => 0,
                    'items' => [],
                    'num' => $num,
                ];
            }
            
            if (!isset($result[$cat]['items'][$r->name])) {
                $result[$cat]['items'][$r->name] = ['name'=> $r->name, 'total' => 0];
            }
            
            $result[$cat]['items'][$r->name]['total'] += $r->amount; 
            $result[$cat]['total'] += $r->amount;
            
            $total += $r->amount; 
            $num++;
        }
        
        //сотрировка
        usort($result , function($a, $b){
                                
                if ($a['total'] == $b['total']) {
                    return 0;
                }

                return ($a['total'] > $b['total']) ? -1 : 1;

        });
        
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
    
    /**
     * Отчет по счетам
     * @param type $query
     * @return type
     */
    public function scopeReportBills($query){
        
        $startTimestamp = mktime(0,0,0, date('m', time()), 1 , date('Y', time()));
        
        $from = date('Y-m-d', $startTimestamp);
                
        $sql = <<<SQL
                select
                    b.name,
                    case when o.type='income' then sum(o.amount) end as in,
                    case when o.type='outcome' then sum(o.amount) end as out,
                    b.amount
                from 
                    operations o
                right join
                    bills b
                on b.id = o.bills_id
                where b.user_id = ?
                and o.created >= ?
                group by b.id
SQL;
        
        $res = DB::select($sql, [Auth::user()->id, $from]);
        
        return $res;
        
    }
    
    protected $visible = [
        'created',
        'amount',
        'bill',
        'category',
    ];
    
    public function scopeOutcomePeriod($query, $from, $to){
                       
        if (Auth::user()) {        
            
        return $query                
                ->where('type','=','outcome')
                ->where('user_id','=', Auth::user()->id)
                ->where('created', '>=', $from)
                ->where('created', '<=', $to)
                ->orderBy('created', 'desc')->get();        
        }
    }
    
	/*
	 * Отчет по доходам и расходам по месяцам за 12 месяцев
	 */
	public function scopeYearOperationReport(){
		
		$sql = <<<SQL
				SELECT extract(YEAR from created) as year, extract(MONTH from created) as month,  sum(case when type='outcome' then amount end) as outcome,
sum(case when type='income' then amount end) as income
FROM "public"."operations"
WHERE user_id = ?
group by year, month
order by month desc
limit 12
SQL;
		
		return DB::select($sql, [Auth::user()->id]);
		
	}
	
	
	//todo оптимизировать
	public static function dayWeekMonthStat(){
		
		$sql = <<<SQL
				SELECT 
					coalesce(sum( case when type='income' then amount end ),0) as income,
					coalesce(sum( case when type='outcome' then amount end ),0) as outcome				
				FROM 
					operations
				WHERE 
					created > date_trunc('month', now()) 
				AND 
					user_id = :id
SQL;
		
		
		$month = DB::select($sql, ['id'=>Auth::user()->id]);
	
		
				$sql = <<<SQL
				SELECT 
					coalesce(sum( case when type='income' then amount end ),0) as income,
					coalesce(sum( case when type='outcome' then amount end ),0) as outcome
				FROM 
					operations
				WHERE 
					created > date_trunc('week', now()) 
				AND 
					user_id = :id
SQL;
		
		$week = DB::select($sql, ['id'=>Auth::user()->id]);

				$sql = <<<SQL
				SELECT 
					coalesce(sum( case when type='income' then amount end ),0) as income,
					coalesce(sum( case when type='outcome' then amount end ),0) as outcome						
				FROM 
					operations
				WHERE 
					created > date_trunc('day', now()) 
				AND 
					user_id = :id
SQL;
		
		$day = DB::select($sql, ['id'=>Auth::user()->id]);
		
		
		return [
			'day' => $day[0],
			'week' => $week[0],
			'month' =>$month[0],			
		];

		
	}
    
}
