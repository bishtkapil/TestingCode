<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    // public function railway_board()
    // {
    //     return $this->belongsTo('App\Models\RailwayBoard');
    // }

    public function divisions()
    {
        return $this->hasMany('App\Models\Division');
    }
    
    protected $fillable = [
        'detailed_name',
        'name',
        'weight',
        'zone_hq',
        'status',
    ];
}
