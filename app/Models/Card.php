<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'user_id',
        'credit_card_id',
        'number',
        'expiry_date',
        'card_balance',
        'organization',
        'cvv',
        'create_time',
        'state',
    ];
}
