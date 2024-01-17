<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UsedItem extends Model
{
    protected $fillable = [
    	'used_number',
        'user_id',
        'item_id',
        'quantity',
        'serial_no_id',
        'placed_at'
    ];

    public static function get_generated_placed_items_list_according_to_data_table_format($user_ids)
    {
        $items_list = DB::table('used_items')
            ->select('used_items.*', 'item_names.name as item_name', 'users.name as placed_by','inventory_item_extra_details.serial_number as serial_no_name', 'placed_items.name as placed_location',DB::raw("DATE_FORMAT(used_items.created_at, '%d-%m-%Y %H:%i:%s') as date"))
            ->leftJoin('item_names', 'item_names.id', '=', 'used_items.item_id')
            ->leftJoin('users', 'users.id', '=', 'used_items.user_id')
            ->leftJoin('inventory_item_extra_details', 'inventory_item_extra_details.id', '=', 'used_items.serial_no_id')
            ->leftJoin('placed_items','placed_items.id','=','used_items.placed_at')
            ->whereIn('used_items.user_id',$user_ids)->where('quantity','!=',0)->get();
        
        return $items_list;
    }

    public static function get_generated_placed_items_list_according_to_data_table_format_for_report($user_ids)
    {
        $items_list = DB::table('used_items')
            ->select('used_items.*', 'item_names.name as item_name', 'users.name as placed_by','users.zone_id','users.division_id','users.post_id','zones.name as zone_name','divisions.name as division_name','posts.name as post_name','inventory_item_extra_details.serial_number as serial_no_name', 'placed_items.name as placed_location',DB::raw("DATE_FORMAT(used_items.created_at, '%d-%m-%Y %H:%i:%s') as date"))
            ->leftJoin('item_names', 'item_names.id', '=', 'used_items.item_id')
            ->leftJoin('users', 'users.id', '=', 'used_items.user_id')
            ->leftJoin('zones', 'zones.id', '=', 'users.zone_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'users.division_id')
            ->leftJoin('posts', 'posts.id', '=', 'users.post_id')
            ->leftJoin('inventory_item_extra_details', 'inventory_item_extra_details.id', '=', 'used_items.serial_no_id')
            ->leftJoin('placed_items','placed_items.id','=','used_items.placed_at')
            ->whereIn('used_items.user_id',$user_ids)->get();
        
        return $items_list;
    }
}
