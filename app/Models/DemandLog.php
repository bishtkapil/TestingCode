<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandLog extends Model
{
    protected $fillable = [
        'user_id',
        'railway_board_id',
        'zone_id',
        'division_id',
        'post_id',
        'demand_id',
        'status',
        'remarks'
    ];
}
