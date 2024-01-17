<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Committee extends Model
{
    protected $fillable = [
        'committee_organise_date',
        'committee_members_details'
    ];

    public static function get_condemnation_list_according_to_data_table_format($user_id)
    {
        $items_list = DB::table('committees')
            ->select('committees.*', 'condemnations.condemnation_letter_no as condemnation_letter_no','condemnations.user_id' ,DB::raw('count(condemnations.committee_id) as total'),DB::raw("DATE_FORMAT(committees.created_at, '%d-%m-%Y %H:%i:%s') as committee_organise_date"))
            ->leftJoin('condemnations', 'committees.id', '=', 'condemnations.committee_id')
            ->whereIn('condemnations.user_id',$user_id)->groupBy('condemnation_letter_no')->orderBy('committees.created_at','desc')->get();
        return $items_list;
    }
}
