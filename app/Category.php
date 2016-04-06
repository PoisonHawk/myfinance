<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends \Baum\Node
{
    public $table = 'categories';
    //
    protected $fillable = [
      'user_id',
        'name',
        'type',
        //'parent_id',
    ];
    
    protected $visible = [
      'name',  
    ];
    
    public function user(){
        $this->belongsTo('user');
    }
}
