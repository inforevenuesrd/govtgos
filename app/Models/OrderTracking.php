<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    public $guarded = [];

    protected $casts = [
        'order_date' => 'date',
    ];
}
