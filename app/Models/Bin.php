<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bin extends Model
{
    protected $fillable = [
        'id',
        'bin',
        'cr',
        'organization',
        'actualOpenCardPrice',
        'actualRechargeFeeRate',
        'enable',
        'description'
    ];
}
