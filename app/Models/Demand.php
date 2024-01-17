<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Demand extends Model
{
    protected $fillable = [
        'demand_number',
        'user_id',
        'railway_board_id',
        'zone_id',
        'division_id',
        'post_id',
        'item_name_id',
        'placed_at',
        'demand_for',
        'quantity',
        'authorization',
        'demand_type',
        'regular_demand_date',
        'annual_demand_year_from',
        'annual_demand_year_to',
        'other_details',
        'remarks',
        'approval_for',
        'is_approved',
        'purchase_status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function item_name()
    {
        return $this->belongsTo('App\Models\ItemName');
    }

    public static function get_raised_demands_list_according_to_division_data_table_format($role_column_name_and_id, $status,$purchase_status = null,$demands)
    {
        // $item_names_table_query = DB::table('item_names')
        //     ->select('item_names.id', 'item_names.name as item_name', 'item_types.name as item_type', 'item_heads.name as item_head')
        //     ->leftJoin('item_heads', 'item_heads.id', '=', 'item_names.item_head_id')
        //     ->leftJoin('item_types', 'item_types.id', '=', 'item_names.item_type_id')->toSql();
        // $demands_table_query = DB::table('demands')
        //     ->select(
        //         'item_names.item_name',
        //         'item_names.item_type',
        //         'item_names.item_head',
        //         'demands.*',DB::raw('SUM(inventory_items.quantity) as present_stock'))
        //     ->leftJoin(DB::raw('('.$item_names_table_query.') item_names'), 'item_names.id','=','demands.item_name_id')
        //     ->leftJoin('inventory_items', 'inventory_items.item_name_id','=','demands.item_name_id')
        //     ->groupBy('inventory_items.item_name_id')
        //     ->toSql();
        // $avc  = DB::table('demands_list')
        //     ->select()
        //     ->from(DB::raw('('.$demands_table_query.') demands_list'))
        //     ->where($role_column_name_and_id)
        //     ->whereIn('is_approved', $status)
        //     ->whereIn('purchase_status',$purchase_status)->toSql();
        // dd($avc);   



        $item_names_table_query = DB::table('item_names')
            ->select('item_names.id', 'item_names.name as item_name', 'item_types.name as item_type', 'item_heads.name as item_head')
            ->leftJoin('item_heads', 'item_heads.id', '=', 'item_names.item_head_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'item_names.item_type_id')->toSql();
        $demands_table_query = DB::table('demands')
            ->select(
                'item_names.item_name',
                'item_names.item_type',
                'item_names.item_head',
                'demands.*')
            ->leftJoin(DB::raw('('.$item_names_table_query.') item_names'), 'item_names.id','=','demands.item_name_id')
            // ->leftJoin('inventory_items', 'inventory_items.item_name_id','=','demands.item_name_id')
            // ->groupBy('inventory_items.item_name_id')
            ->toSql();
        return DB::table('demands_list')
            ->select()
            ->from(DB::raw('('.$demands_table_query.') demands_list'))
            // ->where($role_column_name_and_id)
            ->whereIn('is_approved', $status)
            // ->whereIn('purchase_status',$purchase_status)
            ->whereIn('id',$demands)
            ->orderBy('created_at', 'desc');
    }


    public static function get_raised_demands_list_according_to_zone_data_table_format($role_column_name_and_id, $status,$purchase_status = null,$demands)
    {
        // dd($demands);
        $item_names_table_query = DB::table('item_names')
            ->select('item_names.id', 'item_names.name as item_name', 'item_types.name as item_type', 'item_heads.name as item_head')
            ->leftJoin('item_heads', 'item_heads.id', '=', 'item_names.item_head_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'item_names.item_type_id')->toSql();
        $demands_table_query = DB::table('demands')
            ->select(
                'item_names.item_name',
                'item_names.item_type',
                'item_names.item_head',
                'demands.*')
            ->leftJoin(DB::raw('('.$item_names_table_query.') item_names'), 'item_names.id','=','demands.item_name_id')
            // ->leftJoin('inventory_items', 'inventory_items.item_name_id','=','demands.item_name_id')
            // ->groupBy('inventory_items.item_name_id')
            ->toSql();
        return DB::table('demands_list')
            ->select()
            ->from(DB::raw('('.$demands_table_query.') demands_list'))
            // ->where($role_column_name_and_id)
            ->whereIn('is_approved', $status)
            // ->whereIn('purchase_status',$purchase_status)
            ->whereIn('id',$demands)
            ->orderBy('created_at', 'desc');

        // $item_names_table_query = DB::table('item_names')
        //     ->select('item_names.id', 'item_names.name as item_name', 'inventory_types.name as item_type', 'item_types.name as item_head')
        //     ->leftJoin('inventory_types', 'inventory_types.id', '=', 'item_names.inventory_type_id')
        //     ->leftJoin('item_types', 'item_types.id', '=', 'item_names.item_type_id')->toSql();
        // $demands_table_query = DB::table('demands')
        //     ->select(
        //         'item_names.item_name',
        //         'item_names.item_type',
        //         'item_names.item_head',
        //         'demands.*')
        //     ->leftJoin(DB::raw('('.$item_names_table_query.') item_names'), 'item_names.id','=','demands.item_name_id')
        //     ->toSql();
        // return DB::table('demands_list')
        //     ->select()
        //     ->from(DB::raw('('.$demands_table_query.') demands_list'))
        //     ->where($role_column_name_and_id)
        //     ->whereIn('is_approved', $status);
    }

    public static function get_raised_demands_list_according_to_post_data_table_format($role_column_name_and_id, $status,$purchase_status = null,$demands)
    {
        $item_names_table_query = DB::table('item_names')
            ->select('item_names.id', 'item_names.name as item_name', 'item_types.name as item_type', 'item_heads.name as item_head')
            ->leftJoin('item_heads', 'item_heads.id', '=', 'item_names.item_head_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'item_names.item_type_id')->toSql();
        $demands_table_query = DB::table('demands')
            ->select(
                'item_names.item_name',
                'item_names.item_type',
                'item_names.item_head',
                'demands.*')
            ->leftJoin(DB::raw('('.$item_names_table_query.') item_names'), 'item_names.id','=','demands.item_name_id')
            // ->leftJoin('inventory_items', 'inventory_items.item_name_id','=','demands.item_name_id')
            // ->groupBy('inventory_items.item_name_id')
            ->toSql();
        return DB::table('demands_list')
            ->select()
            ->from(DB::raw('('.$demands_table_query.') demands_list'))
            // ->where($role_column_name_and_id)
            ->whereIn('is_approved', $status)
            // ->whereIn('purchase_status',$purchase_status)
            ->whereIn('id',$demands)
            ->orderBy('created_at', 'desc');
    }

    public static function update_demand($inputs)
    {
        $data = DB::table('demands')->where('id', $inputs['demand_id'])->whereIn('is_approved', $inputs['is_approved'])->update([
                'demand_type' => $inputs['demand_type'],
                'regular_demand_date' => $inputs['regular_demand_date'],
                'annual_demand_year_from' => $inputs['annual_demand_year_from'],
                'annual_demand_year_to' => $inputs['annual_demand_year_to'],
                'item_name_id' => $inputs['item_name_id'],
                'demand_for' => $inputs['demand_for'],
                'quantity' => $inputs['quantity'],
                'authorization' => $inputs['authorization'],
                'other_details' => $inputs['other_details'],
                'remarks' => $inputs['remarks'],
                'approval_for' => $inputs['approval_for']
        ]);
        if ($data) {
            return true;
        }


    }
}
