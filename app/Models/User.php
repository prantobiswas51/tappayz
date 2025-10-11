<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'password',
        'trx_address',
        'trx_private_key',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all cards belonging to this user.
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * Get only the active cards belonging to this user.
     */
    public function activeCards()
    {
        return $this->hasMany(Card::class)->where('state', 'Active');
    }

    /**
     * Get the count of active cards for this user.
     * This is used in the dashboard to display active cards count.
     */
    public function getActiveCardsAttribute(): int
    {
        return $this->activeCards()->count();
    }
}
