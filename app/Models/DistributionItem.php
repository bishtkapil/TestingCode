<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DistributionItem extends Model
{
    protected $fillable = [
        'distribution_id',
        'user_id',
        'item_id',
        'req_qty',
        'diff',
        'present_stock',
        'warranty_type',
        'serial_number',
        'created_at',
        'updated_at'
    ];
}
