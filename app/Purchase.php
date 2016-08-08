<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $_table = 'purchases';
    public $timestamps = false;

    protected $fillable = [
      'user_id',
      'name',
      'priority'
    ];
}
