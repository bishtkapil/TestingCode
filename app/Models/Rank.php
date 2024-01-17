<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $fillable = [
        'name',
        'weight',
        'status'
    ];

    public function scopeActive($query) {
        return $query->where('status', 1);
    }

    public function scopeOrdered($query){
        return $query->orderBy('weight', 'asc');
    }
}
