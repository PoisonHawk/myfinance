<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
    
    
    
}
