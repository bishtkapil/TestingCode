<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Division extends Model
{
    //
    protected $fillable = [
        'code',
        'uin_prefix',
        'division_hq',
        'name',
        'weight',
        'zone_id',
        'status',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function post()
    {
        return $this->hasOne(Post::class, 'division_id');
    }
}
