<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
	// public $timestamps = false;

	protected $fillable = [
        'description',
        'title',
        'user_id',
        'status',
        'generated_by',
        'items_id',
        'serial_no_id',
        'zone_id',
        'division_id',
        'post_id',
        'placed_at',
        'reason',
        'action_by'
    ];

    public static function get_generated_ticket_list_according_to_data_table_format($user_id)
    {
        $items_list = DB::table('tickets')
            ->select('tickets.*', 'item_names.name as item_name', 'inventory_item_extra_details.serial_number as serial_number', 'placed_items.name as placed_at_name','users.name as action_by_name','user1.name as user_name',DB::raw("DATE_FORMAT(tickets.created_at, '%d-%m-%Y') as created_at1"))
            ->leftJoin('item_names', 'item_names.id', '=', 'tickets.items_id')
            ->leftJoin('inventory_item_extra_details', 'inventory_item_extra_details.id', '=', 'tickets.serial_no_id')
            ->leftJoin('placed_items','placed_items.id','=','tickets.placed_at')
            ->leftJoin('users','users.id','=','tickets.action_by')
            ->leftJoin('users as user1','user1.id','=','tickets.user_id')
            ->whereIn('tickets.user_id',$user_id)->orWhereIn('action_by',$user_id)
            ->orderBy('tickets.created_at','desc')->get();
        return $items_list;
    }

    public static function pendingTicketcount()
    {
        $user = Auth::user();
        $items_list = DB::table('tickets')->where('action_by',$user->id)->where('status','!=',2)->count();
        return $items_list;
    }

    public static function get_items_under_amc_report($user_id)
    {
        $items_list = DB::table('tickets')
            ->select('tickets.*','users.name as user_name','u2.name as action_by_name','item_names.name as item_names', 'users.zone_id as zid','users.division_id as did','users.post_id as pid', 'zones.name as zone_name','divisions.name as division_name','posts.name as post_name','inventory_item_extra_details.serial_number as serial_number',DB::raw("DATE_FORMAT(tickets.created_at, '%d-%m-%Y') as date"))
            ->leftJoin('users', 'users.id', '=', 'tickets.user_id')
            ->leftJoin('users as u2', 'u2.id', '=', 'tickets.action_by')
            ->leftJoin('zones', 'zones.id', '=', 'users.zone_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'users.division_id')
            ->leftJoin('posts', 'posts.id', '=', 'users.post_id')
            ->leftJoin('item_names', 'item_names.id', '=', 'tickets.items_id')
            ->leftJoin('inventory_item_extra_details','inventory_item_extra_details.id','=','tickets.serial_no_id')
            ->whereIn('tickets.status',[0,1])
            ->whereIn('tickets.user_id',$user_id)
            ->orderBy('tickets.created_at','desc')
            ->get();
            // dd($items_list);
        return $items_list;
    }
}
