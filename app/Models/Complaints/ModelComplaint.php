<?php

namespace App\Models\Complaints;

use Illuminate\Database\Eloquent\Model;
use App\Models\Designation;
use App\Models\Rank;
use App\Models\Complaints\ModelComplaintStatus;
use App\Models\Complaints\ModelComplaintType;
use App\Models\Complaints\ModelComplaintSubType;
use App\Models\Complaints\ModelComplaintThread;
use Illuminate\Support\Carbon;
use App\User;

class ModelComplaint extends Model
{
    public $timestamps = true;
    protected $table = 'tbl_complaint';
    protected $guarded = [];
    protected $appends = [
        'f_created_at', 'f_updated_at'
    ];


    public static function get_complaints_count_other()
    {
        return ModelComplaint::where('status', '<>', 2)->count();
    }

    public static function get_complaints_count_pending()
    {
        return ModelComplaint::where('status', '=', 2)->count();
    }

    public function scopeOrdered($query){
        return $query->orderBy('updated_at', 'desc');
    }

    public function currentStatus(){
        return $this->hasOne(ModelComplaintStatus::class, 'id', 'status');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'added_by');
    }

    public function r_designation(){
        return $this->hasOne(Designation::class, 'id', 'designation');
    }

    public function r_rank(){
        return $this->hasOne(Rank::class, 'id', 'rank');
    }

    public function complaint_type(){
        return $this->hasOne(ModelComplaintType::class, 'id', 'type');
    }

    public function sub_complaint_type(){
        return $this->hasOne(ModelComplaintSubType::class, 'id', 'subtype');
    }

    public function thread(){
        return $this->hasMany(ModelComplaintThread::class, 'complaint_id', 'id');
    }

    public function getFCreatedAtAttribute(){
        if ($this->created_at){
            // return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d-m-Y H:i:s');
            return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d-m-Y');

        }
        return "";
    }

    public function getFUpdatedAtAttribute(){
        if ($this->updated_at){
            // return Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('d-m-Y');
            return Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('d-m-Y H:i:s');
        }
        return "";
    }

}
