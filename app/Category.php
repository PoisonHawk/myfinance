<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends \Baum\Node
{
    //
    protected $fillable = [
      'user_id',
        'name',
        'type',
        //'parent_id',
    ];
    
    public function user(){
        $this->belongsTo('user');
    }
}
