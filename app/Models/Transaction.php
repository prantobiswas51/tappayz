<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
     protected $fillable = [
        'user_id',
        'payment_method',
        'payment_id',
        'payer_email',
        'merchant',
        'amount',
        'status',
        'type',
    ];
}
