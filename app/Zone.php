<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Zone extends Model
{
    //
    protected $fillable = [
        'detailed_name',
        'name',
        'weight',
        'zone_hq',
        'status',
    ];

    public function division()
    {
        return $this->hasOne(Division::class, 'zone_id');
    }

    public function posts()
    {
        return $this->hasOne(Post::class,'division_id');
    }
}
