<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kit extends Model
{

    protected $fillable = [
       'user_id',
       'zone_id',
       'division_id',
       'post_id',
       'demand_type',
       'name',
       'present_stock',
       'Size',
       'quantity',
       'Rank',
       'other_details',
       'itemHead',
       'itemtype',
       'codal_life_Years',
       'codal_life_Months',
       'entitlement',
       'item_name_id'
    ];
}
