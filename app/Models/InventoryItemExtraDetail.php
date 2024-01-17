<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Expired\ExpiredItems;
use Illuminate\Notifications\Notifiable;

class InventoryItemExtraDetail extends Model
{
    use Notifiable;

    protected $fillable = [
        'inventory_item_id',
        'user_id',
        'item_id',
        'warranty_date_to',
        'item_make',
        'model_number',
        'serial_number',
        'status',
        'ticket_status'
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\ItemName');
    }

    public static function get_items_in_warranty_report($user_id)
    {
        $items_list = DB::table('inventory_item_extra_details')
            ->select('inventory_item_extra_details.*','users.name as user_name','item_names.name as item_names', 'users.zone_id as zid','users.division_id as did','users.post_id as pid', 'zones.name as zone_name','divisions.name as division_name','posts.name as post_name','placed_items.name as placed_location',DB::raw("DATE_FORMAT(inventory_item_extra_details.warranty_date_to, '%d-%m-%Y') as warranty_date_to_new"))
            // ->leftJoin('inventory_items','inventory_items.id','=','inventory_item_extra_details.inventory_item_id')
            ->leftJoin('users', 'users.id', '=', 'inventory_item_extra_details.user_id')
            ->leftJoin('zones', 'zones.id', '=', 'users.zone_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'users.division_id')
            ->leftJoin('posts', 'posts.id', '=', 'users.post_id')
            ->leftJoin('item_names', 'item_names.id', '=', 'inventory_item_extra_details.item_id')
            ->leftJoin('placed_items', 'placed_items.id', '=', 'inventory_item_extra_details.placed_at')
            ->whereIn('inventory_item_extra_details.user_id',$user_id)
            // ->where('inventory_item_extra_details.placed_at',NULL)
            // ->where('inventory_item_extra_details.ticket_status',0)
            ->where('inventory_item_extra_details.condemn_status',0)
            ->get();
            // dd($items_list);
        return $items_list;
    }
}
