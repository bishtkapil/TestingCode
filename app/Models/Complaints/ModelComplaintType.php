<?php

namespace App\Models\Complaints;

use Illuminate\Database\Eloquent\Model;

class ModelComplaintType extends Model
{
    public $timestamps = true;
    protected $table = 'tbl_complaint_type';
    protected $guarded = [];

    public function scopeActive($query) {
        return $query->where('status', 1);
    }

    public function scopeOrdered($query){
        return $query->orderBy('weight', 'asc');
    }
}
