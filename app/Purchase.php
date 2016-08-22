<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $_table = 'purchases';
    public $timestamps = false;

    public function category(){
      return $this->belongsTo('App\Category');
    }

    protected $fillable = [
      'user_id',
      'name',
      'priority'
    ];

    public static function back($priority){

      switch ($priority){
        case 1:
          return 'info';
          break;
        case 2:
          return 'success';
          break;
        case 3:
          return 'warning';
          break;
        case 4:
          return 'danger';
          break;
      }

    }
}
