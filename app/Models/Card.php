<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'number',
        'expiryDate',
        'cvv',
        'vcc_id',
        'bin',
        'binId',
        'organization',
        'state',
        'remark',
        'createTime',
        'modifyTime',
        'cardBalance',
        'adapterSign',

        'totalConsume',
        'totalRefund',
        'totalRecharge',
        'totalCashOut',
        'bankCardId',
        'hiddenNum',
        'hiddenCvv',
        'hiddenDate',
        'isHidden',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
