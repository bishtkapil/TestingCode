<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemHead extends Model
{
    protected $fillable = [
        'name'
    ];

    public function item_name()
    {
        $this->hasMany('App\Models\ItemName','item_head_id');
    }
}
