<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class State extends Model
{
    //

    protected $table = 'states';

    protected $fillable = [
        'state','country'

    ];


    public function country()
    {
        return $this->belongsTo(Country::class, 'country');
    }



}
