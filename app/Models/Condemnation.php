<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Condemnation extends Model
{
    protected $fillable = [
        'user_id',
        'committee_id',
        'condemnation_letter_no',
        'condemnation_date',
        'zone_id',
        'division_id',
        'post_id',
        'item_id',
        'used_id',
        'quantity',
        'serial_numbers',
        'condemn_from',
        'placed_id',
        'remarks'
    ];

    public static function get_data($committee_id)
    {
        $items_list = DB::table('condemnations')
            ->select('condemnations.*', 'zones.name as zone_name','divisions.name as division_name','posts.name as post_name','item_names.name as item_name','item_names.codal_life as codal_life')
            ->leftJoin('zones', 'zones.id', '=', 'condemnations.zone_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'condemnations.division_id')
            ->leftJoin('posts', 'posts.id', '=', 'condemnations.post_id')
            ->leftJoin('item_names', 'item_names.id', '=', 'condemnations.item_id')
            ->where('committee_id',$committee_id)->get();
        return $items_list;
    }

    public static function get_condemnation_report()
    {
        $items_list = DB::table('condemnations')
            ->select('condemnations.*', 'zones.name as zone_name','divisions.name as division_name','posts.name as post_name','item_names.name as item_name','users.name as user_name',DB::raw("DATE_FORMAT(condemnations.condemnation_date, '%d-%m-%Y') as condemnation_date1"))
            ->leftJoin('zones', 'zones.id', '=', 'condemnations.zone_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'condemnations.division_id')
            ->leftJoin('posts', 'posts.id', '=', 'condemnations.post_id')
            ->leftJoin('item_names', 'item_names.id', '=', 'condemnations.item_id')
            ->leftJoin('users', 'users.id', '=', 'condemnations.user_id')
            ->orderBy('condemnations.condemnation_date','desc')
            ->get();
        return $items_list;
    }

    public static function get_condemnation_report_with_filter($zone_ids,$division_id,$post_id){
        $items_list = DB::table('condemnations')
            ->select('condemnations.*', 'zones.name as zone_name','divisions.name as division_name','posts.name as post_name','item_names.name as item_name','users.name as user_name',DB::raw("DATE_FORMAT(condemnations.condemnation_date, '%d-%m-%Y') as condemnation_date1"))
            ->leftJoin('zones', 'zones.id', '=', 'condemnations.zone_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'condemnations.division_id')
            ->leftJoin('posts', 'posts.id', '=', 'condemnations.post_id')
            ->leftJoin('item_names', 'item_names.id', '=', 'condemnations.item_id')
            ->leftJoin('users', 'users.id', '=', 'condemnations.user_id');
            // ->whereIn('condemnations.zone_id',$zone_ids)
            // ->whereIn('condemnations.division_id',$division_id)
            // ->whereIn('condemnations.post_id',$post_id)
            // ->toSql();
        if(count($zone_ids) != 0 && count($division_id) == 0 && count($post_id) == 0){
            $data = $items_list->whereIn('condemnations.zone_id',$zone_ids)->orderBy('condemnations.condemnation_date','desc')->get();
        }else if(count($zone_ids) != 0 && count($division_id) != 0 && count($post_id) == 0){
            $data = $items_list->whereIn('condemnations.zone_id',$zone_ids)->whereIn('condemnations.division_id',$division_id)->orderBy('condemnations.condemnation_date','desc')->get();
        }else if(count($zone_ids) != 0 && count($division_id) != 0 && count($post_id) != 0){
            $data = $items_list->whereIn('condemnations.zone_id',$zone_ids)->whereIn('condemnations.division_id',$division_id)->whereIn('condemnations.post_id',$post_id)->orderBy('condemnations.condemnation_date','desc')->get();
        }
        // dd($items_list);
        return $items_list;
    }
}
