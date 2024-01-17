<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Distribution extends Model
{
    protected $fillable = [
    	'file_no',
        'subject',
        'ref_demand_no',
        'division_id',
        'post_id',
        'user_id',
        'demand_id',
        'level_history',
        'items_data',
        'through',
        'distribution_date',
        'remarks',
        'status'
    ];

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function division()
    {
        return $this->belongsTo('App\Models\Division');
    }

    public static function get_distribution_report($user_id)
    {
        $items_list = DB::table('distributions')
            ->select('distributions.*','users.zone_id as zid','users.division_id as did','users.post_id as pid', 'zones.name as zone_name','divisions.name as division_name','posts.name as post_name',DB::raw("DATE_FORMAT(distributions.distribution_date, '%d-%m-%Y') as distribution_date"))
            ->leftJoin('users', 'users.id', '=', 'distributions.user_id')
            ->leftJoin('zones', 'zones.id', '=', 'users.zone_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'users.division_id')
            ->leftJoin('posts', 'posts.id', '=', 'users.post_id')
            ->whereIn('distributions.user_id',$user_id)->orderBy('distributions.distribution_date','desc')
            ->get();
        return $items_list;
    }
}
