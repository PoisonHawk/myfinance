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
}
