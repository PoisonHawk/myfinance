<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Bills extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'amount',
    ];
    
   public function scopeUserBills($query){
       
       return $query->where('user_id','=', Auth::user()->id)->get();
   }
    
}
