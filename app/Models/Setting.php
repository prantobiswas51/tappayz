<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'maileroo_api_key',
        'vcc_user_serial',
        'vcc_secret_key',
        'main_deposit_address',
        'paypal_email',
        'payoneer_email',
        'skrill_email',
    ];
}
