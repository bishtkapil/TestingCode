<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ItemLog extends Model
{
	protected $fillable = [
        'user_ids',
        'user_id_from',
        'zone_id',
        'division_id',
        'post_id',
        'user_id_to',
        'zone_id_to',
        'division_id_to',
        'post_id_to',
        'item_id',
        'title',
        'store_id',
        'placed_at',
        'quantity',
    ];

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function zone()
    {
        return $this->belongsTo('App\Models\Zone');
    }

    public function division()
    {
        return $this->belongsTo('App\Models\Division');
    }

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    // public function users()
    // {
    //     return $this->belongsToMany('App\User');
    // }

    // public function users2()
    // {
    //     return $this->belongsTo('App\User');
    // }
    public function item()
    {
        return $this->belongsTo('App\Models\ItemName');
    }

    public static function gethistory($item_id,$user_id)
    {
        $latestPosts = DB::table('users AS u')
                    ->select('u.id','u.name','u.role_id', 'posts.name AS post_name','divisions.name AS division_name','zones.name AS zone_name')
                    ->leftJoin('posts', function ($join) {
                        $join->on('posts.id', '=', 'u.post_id')
                            ->whereNotNull('u.post_id');
                    })
                    ->leftJoin('divisions', function ($join) {
                        $join->on('divisions.id', '=', 'u.division_id')
                            ->whereNotNull('u.division_id');
                    })
                    ->leftJoin('zones', function ($join) {
                        $join->on('zones.id', '=', 'u.zone_id')
                            ->whereNotNull('u.zone_id');
                    });
        $latestPosts2 = DB::table('users AS u')
                    ->select('u.id','u.name','u.role_id', 'posts.name AS post_name','divisions.name AS division_name','zones.name AS zone_name')
                    ->leftJoin('posts', function ($join) {
                        $join->on('posts.id', '=', 'u.post_id')
                            ->whereNotNull('u.post_id');
                    })
                    ->leftJoin('divisions', function ($join) {
                        $join->on('divisions.id', '=', 'u.division_id')
                            ->whereNotNull('u.division_id');
                    })
                    ->leftJoin('zones', function ($join) {
                        $join->on('zones.id', '=', 'u.zone_id')
                            ->whereNotNull('u.zone_id');
                    });
        $data = DB::table('item_logs')
            ->select('item_logs.*', 'users.name as user_name_from','users.role_id as user_role_id', 'u2.name as user_name_to','u2.role_id as user2_role_id', 'item_names.name as item_name', 'stores.name as store_name', 'placed_items.name as placed_name','users.post_name AS u1_postname' ,'users.division_name AS u1_division_name'  ,'users.zone_name AS u1_zone_name','u2.post_name AS u2_postname' , 'u2.division_name AS u2_division_name'  ,'u2.zone_name AS u2_zone_name',DB::raw("DATE_FORMAT(item_logs.created_at, '%d-%m-%Y %H:%i:%s') as date"))
            ->leftJoin('item_names', 'item_names.id', '=', 'item_logs.item_id')
            ->leftJoin('stores', 'stores.id', '=', 'item_logs.store_id')
            ->leftJoinSub($latestPosts,'users',function($join){
                $join->on('users.id', '=', 'item_logs.user_id_from');
            })
            ->leftJoinSub($latestPosts2,'u2',function($join){
                $join->on('u2.id', '=', 'item_logs.user_id_to');
            })
            ->leftJoin('placed_items','placed_items.id','=','item_logs.placed_at')
            ->where('item_id','=',$item_id)
            ->whereIn('item_logs.user_ids',$user_id )
            // ->where('item_logs.user_id_from','=',$user_id)
            ->orderBY('created_at','DESC')->get();
        // dd($data);
        // $items_list = DB::table('item_logs')
        //     ->select('item_logs.*', 'users.name as user_name_from','u2.name as user_name_to','item_names.name as item_name','stores.name as store_name','placed_items.name as placed_name')
        //     ->leftJoin('item_names', 'item_names.id', '=', 'item_logs.item_id')
        //     ->leftJoin('stores', 'stores.id', '=', 'item_logs.store_id')
        //     ->leftJoin('users','users.id','=','item_logs.user_id_from')
        //     ->leftJoin('users as u2','u2.id','=','item_logs.user_id_to')
        //     ->leftJoin('placed_items','placed_items.id','=','item_logs.placed_at')
        //     ->where('item_id','=',$item_id)
        //     ->where('item_logs.user_id_from','=',$user_id)
        //     ->orderBY('created_at','DESC')->get();
        return $data;

        
    }

}
