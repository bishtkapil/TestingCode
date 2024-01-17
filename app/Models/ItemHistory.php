<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ItemHistory extends Model
{
    public function store()
    {
        return $this->belongsTo('App\Models\Store');
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
