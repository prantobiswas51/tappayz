<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',

        'street_address',
        'apt_unit',
        'zip_code',

        'phone_number',
        'email_address',

        'country',
        'passport_number',
        'passport_img_path',
        'status',
    ];
}
