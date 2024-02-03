<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $table = 'citys';

    protected $fillable = [
        'city','state'

    ];

    public function city()
    {
        return $this->belongsTo(state::class, 'country');
    }
}
//re enter
