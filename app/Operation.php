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
    
    
    
}
