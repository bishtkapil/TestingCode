<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Country extends Model
{
    //
    protected $table = 'countries';

    protected $fillable = [
        'country'

    ];
    public function state()
    {
        return $this->hasMany(State::class, 'country');
    }

    public function city()
    {
        return $this->hasMany(City::class, 'state');
    }

}
