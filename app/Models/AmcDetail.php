<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AmcDetail extends Model
{
    protected $fillable = [
        'user_id',
        'letter_number',
        'letter_date',
        'date_from',
        'date_to',
        'firm_name',
        'amc_period',
        'contact_no_for_support',
        'firm_contact_no',
        'firm_email',
        'ticket_id',
        'status'
    ];

    public static function get_amc_report($user_id)
    {
        $items_list = DB::table('amc_details')
            ->select('amc_details.*','users.name as user_name','tickets.items_id as itemid','item_names.name as item_names', 'users.zone_id as zid','users.division_id as did','users.post_id as pid', 'zones.name as zone_name','divisions.name as division_name','posts.name as post_name',DB::raw("DATE_FORMAT(amc_details.letter_date, '%d-%m-%Y') as letter_date_new"))
            ->leftJoin('users', 'users.id', '=', 'amc_details.user_id')
            ->leftJoin('zones', 'zones.id', '=', 'users.zone_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'users.division_id')
            ->leftJoin('posts', 'posts.id', '=', 'users.post_id')
            ->leftJoin('tickets','tickets.id','=','amc_details.ticket_id')
            ->leftJoin('item_names', 'item_names.id', '=', 'tickets.items_id')
            ->whereIn('amc_details.user_id',$user_id)
            ->orderBy('amc_details.letter_date','desc')
            ->get();
            // dd($items_list);
        return $items_list;
    }
}
