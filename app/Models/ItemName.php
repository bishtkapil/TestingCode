<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ItemName extends Model
{
  protected $fillable = [
        'name',
        'item_head_id',
        'item_type_id',
        'item_make',
        'codal_life',
        'warranty_items',
        'codal_life_days'
    ];
   public function item_head()
   {
       return $this->belongsTo('App\Models\ItemHead');
   }

   public function item_type()
   {
       return $this->belongsTo('App\Models\ItemType');
   }

    public static function get_items_list_according_to_data_table_format()
    {
        $items_list = DB::table('item_names')
            ->select('item_names.id', 'item_names.name as item_name', 'item_types.name as item_type', 'item_heads.name as item_head','item_names.item_make',DB::raw("CONCAT(item_names.codal_life,' / ', item_names.codal_life_days) AS codal_life_data"),'item_names.warranty_items')
            ->leftJoin('item_heads', 'item_heads.id', '=', 'item_names.item_head_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'item_names.item_type_id')->get();
        return $items_list;
    }
}
