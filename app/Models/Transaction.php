<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
     protected $fillable = [
        'vcc_id',
        'transactionId',
        'cardNum',
        'clientId',
        'type',
        'status',
        'amount',
        'merchantName',
        'recordTime',
    ];
}
