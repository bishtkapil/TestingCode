<?php

namespace App\Models\Complaints;

use Illuminate\Database\Eloquent\Model;

class ModelComplaintStatus extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_complaint_status';
    protected $guarded = [];
}
