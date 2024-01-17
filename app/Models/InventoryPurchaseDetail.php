<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryPurchaseDetail extends Model
{
    protected $fillable = [
        'user_id',
        'zone_id',
        'division_id',
        'post_id',
        'status',
        'purchased_from',
        'vendor_department_name',
        'vendor_contact_number',
        'indent_number',
        'indent_regs_date',
        'challan_issuednote_no',
        'challan_issuednote_date',
        'bill_date',
        'inspection_on',
        'inspection_by'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function inventory_items()
    {
        return $this->hasMany('App\Models\InventoryItem');
    }

    // public function distribution(){
    //     return $this->belongsTo('App\Distribution');
    // }
}