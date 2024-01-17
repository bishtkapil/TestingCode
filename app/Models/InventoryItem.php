<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;
use Carbon\Carbon;
use App\Helpers\Helper;

class InventoryItem extends Model
{
    protected $fillable = [
        'user_id',
        'zone_id',
        'division_id',
        'post_id',
        'inventory_purchase_detail_id',
        'item_name_id',
        'warranty_date_from',
        'warranty_date_to',
        'quantity',
        'amount_per_unit',
        'total_amount',
        'remarks'
    ];

    public function inventory_purchase_detail()
    {
        return $this->belongsTo('App\Models\InventoryPurchaseDetail');
    }

    public function item_name()
    {
        return $this->belongsTo('App\Models\ItemName');
    }

    public function extra_details()
    {
        return $this->hasMany('App\Models\InventoryItemExtraDetail');
    }

    public static function get_inventory_items_list_according_to_data_table_format($inventory_purchase_detail_id,$user_id)
    {
        $item_names_table_query = DB::table('item_names')
            ->select('item_names.id', 'item_names.name as item_name','item_names.codal_life as codal_life','item_names.warranty_items as warranty_status' ,'item_heads.name as item_head', 'item_types.name as item_type')
            ->leftJoin('item_heads', 'item_heads.id', '=', 'item_names.item_head_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'item_names.item_type_id')->toSql();


        $inventory_items_table_query = DB::table('inventory_items')

            ->select('item_names.item_name', 'item_names.item_type', 'item_names.item_head', 'item_names.codal_life', 'item_names.warranty_status', 'inventory_items.id', 'inventory_items.warranty_date_to','inventory_items.item_name_id','stock_items.quantity as quantity','inventory_items.user_id')
            ->join('stock_items', function($join)
                {
                    $join->on('inventory_items.item_name_id', '=', 'stock_items.item_id');
                    $join->on('inventory_items.user_id', '=', 'stock_items.user_id');

                })
            ->leftJoin(DB::raw('('.$item_names_table_query.') item_names'), 'item_names.id','=','inventory_items.item_name_id')
            // ->leftJoin('inventory_purchase_details', 'inventory_purchase_details.id','=','inventory_items.inventory_purchase_detail_id')
            ->wherein('inventory_purchase_detail_id',$inventory_purchase_detail_id)
            ->whereIn('inventory_items.user_id',$user_id)
            ->groupBy('inventory_items.item_name_id')
            ->get();

        // $items_list = DB::table('items_list')
        //     ->select()
        //     ->from(DB::raw('('.$inventory_items_table_query.') items_list'))
        //     ->where('status', '=', $purchased_or_received)
        //     ->where('user_id', '=', $user_id)
        //     ->get();
         // dd($inventory_items_table_query);
        return $inventory_items_table_query;
    }


    public static function get_inventory_items_list_according_to_data_table_format1($inventory_purchase_detail_id,$user_id)
    {
        // dd($inventory_purchase_detail_id);
        $item_names_table_query = DB::table('item_names')
            ->select('item_names.id', 'item_names.name as item_name','item_names.codal_life as codal_life','item_names.warranty_items as warranty_status' ,'item_heads.name as item_head', 'item_types.name as item_type')
            ->leftJoin('item_heads', 'item_heads.id', '=', 'item_names.item_head_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'item_names.item_type_id')->toSql();


        $inventory_items_table_query = DB::table('inventory_items')
            ->select('item_names.item_name', 'item_names.item_type', 'item_names.item_head', 'item_names.codal_life', 'item_names.warranty_status', 'inventory_items.id', 'inventory_items.warranty_date_to','inventory_items.item_name_id',DB::raw('SUM(inventory_items.quantity) as quantity'))
            ->leftJoin(DB::raw('('.$item_names_table_query.') item_names'), 'item_names.id','=','inventory_items.item_name_id')
            // ->leftJoin('inventory_purchase_details', 'inventory_purchase_details.id','=','inventory_items.inventory_purchase_detail_id')
            ->wherein('inventory_purchase_detail_id',$inventory_purchase_detail_id)
            ->whereIn('user_id',$user_id)
            ->groupBy('inventory_items.item_name_id')
            ->get();
        // $inventory_items_table_query['single'] = 1;
         // dd($inventory_items_table_query);
        return $inventory_items_table_query;
    }

    public static function total_purchased_and_received_in_timeperiod($inventory_purchase_detail_id,$user_id)
    {
        // dd($user_id);
        $item_names_table_query = DB::table('item_names')
            ->select('item_names.id', 'item_names.name as item_name','item_names.codal_life as codal_life','item_names.warranty_items as warranty_status' ,'item_heads.name as item_head', 'item_types.name as item_type')
            ->leftJoin('item_heads', 'item_heads.id', '=', 'item_names.item_head_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'item_names.item_type_id')->toSql();


        $inventory_items_table_query = DB::table('inventory_items')
            ->select('item_names.item_name', 'item_names.item_type', 'item_names.item_head', 'item_names.codal_life', 'item_names.warranty_status', 'inventory_items.id', 'inventory_items.warranty_date_to','inventory_items.item_name_id',DB::raw('SUM(inventory_items.quantity) as quantity'))
            ->leftJoin(DB::raw('('.$item_names_table_query.') item_names'), 'item_names.id','=','inventory_items.item_name_id')
            ->whereIn('inventory_purchase_detail_id',$inventory_purchase_detail_id)
            ->whereIn('user_id',$user_id)
            ->whereBetween('created_at', [Carbon::now()->year.'-01-01', Carbon::now()])
            ->groupBy('inventory_items.item_name_id')
            ->get();
        // dd($inventory_items_table_query);
        return $inventory_items_table_query;
    }

    public static function total_purchased_or_received_in_timeperiod($inventory_purchase_detail_id,$user_id)
    {
        $item_names_table_query = DB::table('item_names')
            ->select('item_names.id', 'item_names.name as item_name','item_names.codal_life as codal_life','item_names.warranty_items as warranty_status' ,'item_heads.name as item_head', 'item_types.name as item_type')
            ->leftJoin('item_heads', 'item_heads.id', '=', 'item_names.item_head_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'item_names.item_type_id')->toSql();


        $inventory_items_table_query = DB::table('inventory_items')

            ->select('item_names.item_name', 'item_names.item_type', 'item_names.item_head', 'item_names.codal_life', 'item_names.warranty_status', 'inventory_items.id', 'inventory_items.warranty_date_to','inventory_items.item_name_id','stock_items.quantity as quantity','inventory_items.user_id')
            ->join('stock_items', function($join)
                {
                    $join->on('inventory_items.item_name_id', '=', 'stock_items.item_id');
                    $join->on('inventory_items.user_id', '=', 'stock_items.user_id');

                })
            ->leftJoin(DB::raw('('.$item_names_table_query.') item_names'), 'item_names.id','=','inventory_items.item_name_id')
            ->wherein('inventory_purchase_detail_id',$inventory_purchase_detail_id)
            ->where('inventory_items.user_id',$user_id)
            ->whereBetween('inventory_items.created_at', [Carbon::now()->year.'-01-01', Carbon::now()])
            ->groupBy('inventory_items.item_name_id')
            ->get();

        return $inventory_items_table_query;
    }

    public static function getqty($item_id)
    {
        $qty = DB::table('inventory_items')
            ->where('item_name_id', '=', $item_id)
            ->sum('quantity');
        return $qty;
    }

    public static function getExpiryNotificationsCount()
    {
        $query = DB::table('inventory_items')
                    ->where('warranty_date_from', '<>', NULL)
                    ->whereDate('warranty_date_to', '<=', Carbon::now()->addMonths(2)->toDateString())
                    ->count();

        dd($query);
        return $query;

        //$found_demand->user->notify(new DemandAcceptedOrRejected($found_demand));
    }

    public static function get_purchase_items_report($user_id,$status)
    {
        $items_list = DB::table('inventory_items')
            ->select('inventory_items.*','inventory_purchase_details.*','item_heads.name as item_head','item_types.name as item_type','stores.name as store','users.name as user_name','item_names.name as item_name', 'users.zone_id as zid','users.division_id as did','users.post_id as pid', 'zones.name as zone_name','divisions.name as division_name','posts.name as post_name',DB::raw("DATE_FORMAT(inventory_purchase_details.challan_issuednote_date, '%d-%m-%Y') as challan_issuednote_date"),DB::raw("DATE_FORMAT(inventory_purchase_details.bill_date, '%d-%m-%Y') as bill_date"),DB::raw("DATE_FORMAT(inventory_purchase_details.indent_regs_date, '%d-%m-%Y') as indent_regs_date"),DB::raw("DATE_FORMAT(inventory_purchase_details.created_at, '%d-%m-%Y') as f_created_at"),DB::raw('CONCAT("purchased") as action'),DB::raw('CONCAT("") as reason'))
            ->leftJoin('users', 'users.id', '=', 'inventory_items.user_id')
            ->leftJoin('zones', 'zones.id', '=', 'users.zone_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'users.division_id')
            ->leftJoin('posts', 'posts.id', '=', 'users.post_id')
            ->leftJoin('inventory_purchase_details','inventory_purchase_details.id','=','inventory_items.inventory_purchase_detail_id')
            ->leftJoin('item_names', 'item_names.id', '=', 'inventory_items.item_name_id')
            ->leftJoin('item_heads', 'item_heads.id', '=', 'item_names.item_head_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'item_names.item_type_id')
            ->leftJoin('stores','stores.id','=','inventory_purchase_details.purchased_from')
            ->where('inventory_purchase_details.status',$status)
            ->whereIn('inventory_items.user_id',$user_id)
            ->orderBy('inventory_purchase_details.created_at','desc')
            ->get()->toArray();
        return $items_list;
    }
    public static function get_purchase_items_report_received($user_id,$status)
    {
        $items_list = DB::table('inventory_items')
            ->select('inventory_items.*','inventory_purchase_details.*','item_heads.name as item_head','item_types.name as item_type','stores.name as store','users.name as user_name','item_names.name as item_name', 'users.zone_id as zid','users.division_id as did','users.post_id as pid', 'zones.name as zone_name','divisions.name as division_name','posts.name as post_name',DB::raw("DATE_FORMAT(inventory_purchase_details.created_at, '%d-%m-%Y') as f_created_at"),DB::raw('CONCAT("received") as action'),DB::raw('CONCAT("") as reason'))
            ->leftJoin('users', 'users.id', '=', 'inventory_items.user_id')
            ->leftJoin('zones', 'zones.id', '=', 'users.zone_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'users.division_id')
            ->leftJoin('posts', 'posts.id', '=', 'users.post_id')
            ->leftJoin('inventory_purchase_details','inventory_purchase_details.id','=','inventory_items.inventory_purchase_detail_id')
            ->leftJoin('item_names', 'item_names.id', '=', 'inventory_items.item_name_id')
            ->leftJoin('item_heads', 'item_heads.id', '=', 'item_names.item_head_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'item_names.item_type_id')
            ->leftJoin('stores','stores.id','=','inventory_purchase_details.purchased_from')
            ->where('inventory_purchase_details.status',$status)
            ->whereIn('inventory_items.user_id',$user_id)
            ->orderBy('inventory_purchase_details.created_at','desc')
            ->get()->toArray();
        return $items_list;
    }
}
