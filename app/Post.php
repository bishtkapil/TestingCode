<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    //
    protected $fillable = [
        'code',
        'name',
        'weight',
        'division_id',
        'status',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
}
