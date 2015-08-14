<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'user_id',
        'bill_from_id',
        'bill_to_id',
        'amount',
    ];
    
    public function billFrom(){
        return $this->belongsTo('App\Bills', 'bill_from_id');
    }
    
    public function billTo(){
        return $this->belongsTo('App\Bills', 'bill_to_id');
    }
    
    public function operations(){
        return $this->hasMany('App\Operation', 'transfer_id');
    }
    
    
}
