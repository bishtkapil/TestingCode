<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlacedItem extends Model
{
	const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'zone_id',
        'division_id',
        'post_id',

    ];
}
