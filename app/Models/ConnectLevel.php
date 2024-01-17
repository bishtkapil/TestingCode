<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectLevel extends Model
{
    public function railway_board()
    {
        return $this->belongsTo('App\Models\RailwayBoard');
    }

    public function zone()
    {
        return $this->belongsTo('App\Models\Zone');
    }

    public function division()
    {
        return $this->belongsTo('App\Models\Division');
    }

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
}