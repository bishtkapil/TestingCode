<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpCon extends Model
{
    protected $fillable = [
        'letter_number',
        'subject',
        'type',
        'file',
    ];
}
