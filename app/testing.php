<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class testing extends Model
{
    //
    protected $fillable = [
        'name',
        'course',
        'email',
        'country',
        'phone',
    ];
}
