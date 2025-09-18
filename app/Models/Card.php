<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'user_id',
        'number',
        'amount',
        'expiry_date',
        'type',
        'cvc',
        'registered_at',
        'status',
    ];
}
