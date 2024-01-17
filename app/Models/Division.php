<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{

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
        return $this->belongsTo('App\Models\Zone');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    // public function demands()
    // {
    //     return $this->hasMany('App\Models\Demand');
    // }

    
}
