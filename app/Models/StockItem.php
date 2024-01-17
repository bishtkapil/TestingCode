<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class StockItem extends Model
{
    protected $fillable = [
        'user_id',
        'zone_id',
        'division_id',
        'post_id',
        'item_id',
        'quantity',
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\ItemName');
    }

    public static function update_quantity($item_id,$zone_id,$division_id,$post_id,$quantity)
    {
        $qty = DB::table('stock_items')
        	->select('id' ,'quantity')
            ->where('item_id', '=', $item_id)
            ->where('zone_id',$zone_id)
            ->where('division_id',$division_id)
            ->where('post_id',$post_id)
            ->get()->toArray();
            
        $quantity1 = $qty[0]->quantity + $quantity;
        $update = DB::table('stock_items')
            ->where('id', $qty[0]->id)
            ->update(['quantity' => $quantity1]);
        return $update;
    }

    public static function getqty($item_id,$user_id)
    {
        $qty = DB::table('stock_items')
            ->where('item_id', '=', $item_id)
            ->where($user_id)
            ->sum('quantity');
        return $qty;
    }

    public static function get_stock_items_report($user_id)
    {
        $items_list = DB::table('stock_items')
            ->select('stock_items.*','users.name as user_name','item_names.name as item_names', 'users.zone_id as zid','users.division_id as did','users.post_id as pid', 'zones.name as zone_name','divisions.name as division_name','posts.name as post_name')
            ->leftJoin('users', 'users.id', '=', 'stock_items.user_id')
            ->leftJoin('zones', 'zones.id', '=', 'users.zone_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'users.division_id')
            ->leftJoin('posts', 'posts.id', '=', 'users.post_id')
            ->leftJoin('item_names', 'item_names.id', '=', 'stock_items.item_id')
            ->whereIn('stock_items.user_id',$user_id)
            ->get();
        return $items_list;




        // if($zone_id == null && $division_id == null && $post_id == null){
        //     $items_list = DB::table('stock_items')
        //         ->select('stock_items.*','users.name as user_name','item_names.name as item_names', 'users.zone_id as zid','users.division_id as did','users.post_id as pid', 'zones.name as zone_name','divisions.name as division_name','posts.name as post_name')
        //         ->leftJoin('users', 'users.id', '=', 'stock_items.user_id')
        //         ->leftJoin('zones', 'zones.id', '=', 'users.zone_id')
        //         ->leftJoin('divisions', 'divisions.id', '=', 'users.division_id')
        //         ->leftJoin('posts', 'posts.id', '=', 'users.post_id')
        //         ->leftJoin('item_names', 'item_names.id', '=', 'stock_items.item_id')
        //         ->get();
        //     return $items_list;
        // }else{
        //     // dd($division_id);
        //     $items_list = DB::table('stock_items')
        //         ->select('stock_items.*','users.name as user_name','item_names.name as item_names', 'users.zone_id as zid','users.division_id as did','users.post_id as pid', 'zones.name as zone_name','divisions.name as division_name','posts.name as post_name')
        //         ->leftJoin('users', 'users.id', '=', 'stock_items.user_id')
        //         ->leftJoin('zones', 'zones.id', '=', 'users.zone_id')
        //         ->leftJoin('divisions', 'divisions.id', '=', 'users.division_id')
        //         ->leftJoin('posts', 'posts.id', '=', 'users.post_id')
        //         ->leftJoin('item_names', 'item_names.id', '=', 'stock_items.item_id');
        //     if($zone_id == [])
        //         ->whereIn('stock_items.zone_id',$zone_id)
        //         ->whereIn('stock_items.division_id',$division_id)
        //         ->whereIn('stock_items.post_id',$post_id)
        //         ->toSql();
        //     dd($items_list);
        //     return $items_list;
    }

    public static function get_stock_items_root($zone_id,$division_id,$post_id)
    {
        $items_list = DB::table('stock_items')
            ->select('stock_items.*','users.name as user_name','item_names.name as item_names', 'users.zone_id as zid','users.division_id as did','users.post_id as pid', 'zones.name as zone_name','divisions.name as division_name','posts.name as post_name')
            ->leftJoin('users', 'users.id', '=', 'stock_items.user_id')
            ->leftJoin('zones', 'zones.id', '=', 'users.zone_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'users.division_id')
            ->leftJoin('posts', 'posts.id', '=', 'users.post_id')
            ->leftJoin('item_names', 'item_names.id', '=', 'stock_items.item_id')
            ->where('stock_items.status',null)
            ->orwhereIn('stock_items.zone_id',$zone_id)
            ->orwhereIn('stock_items.division_id',$division_id)
            ->orwhereIn('stock_items.post_id',$post_id)
            ->get();
        return $items_list;
    }
}
