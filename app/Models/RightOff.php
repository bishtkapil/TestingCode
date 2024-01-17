<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class RightOff extends Model
{
    protected $fillable = [
        'user_id',
        'zone_id',
        'division_id',
        'post_id',
        'item_id',
        'used_id',
        'quantity',
        'serial_numbers',
        'condemn_from',
        'placed_id',
        'reason',
        'remarks'
    ];
}
