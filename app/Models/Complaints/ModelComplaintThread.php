<?php

namespace App\Models\Complaints;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ModelComplaintThread extends Model
{
    public $timestamps = true;
    protected $table = 'tbl_complaint_thread';
    protected $guarded = [];

    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'asc');
    }


    public function user(){
        return $this->hasOne(User::class, 'id', 'added_by');
    }
}
