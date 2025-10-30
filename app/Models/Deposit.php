<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'user_id',
        'tx_id',
        'sender_id',
        'receiver_id',
        'amount',
        'type',
        'method',
        'currency',
        'status',
        'screenshot_path',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
