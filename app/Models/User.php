<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'password',
        'role',
        'balance',
        'number',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }

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

    
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

   
    public function activeCards()
    {
        return $this->hasMany(Card::class)->where('state', 'Active');
    }

    
    public function getActiveCardsAttribute(): int
    {
        return $this->activeCards()->count();
    }

    public function kycs()
    {
        return $this->hasMany(Kyc::class);
    }
}
