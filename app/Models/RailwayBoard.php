<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RailwayBoard extends Model
{
    public function zones()
    {
        return $this->hasMany('App\Models\Zone');
    }
}