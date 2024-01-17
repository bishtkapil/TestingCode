<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];

    public function scopeActive($query) {
        return $query->where('status', 1);
    }

    public function scopeOrdered($query){
        return $query->orderBy('name', 'asc');
    }
}
