<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
     protected $fillable = [
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
