<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currency';
    
    public function bills(){
        return $this->belongsTo('App\Bills');
    }
    
    public function allCurrencies(){
        $arr = Currency::all('id', 'iso4217')->toArray('id');
        
        $cur = [];
        foreach ($arr as $a) {
            $cur[$a['id']] = $a['iso4217'];
        }
        
        return $cur;
    }
}
