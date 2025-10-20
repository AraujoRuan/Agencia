<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'document',
        'phone',
        'avatar',
        'bio',
        'rating',
        'rating_count',
        'credits',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'rating' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'seller_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function isBusiness()
    {
        return $this->type === 'business';
    }

    public function addCredits($amount)
    {
        $this->credits += $amount;
        return $this->save();
    }

    public function deductCredits($amount)
    {
        if ($this->credits >= $amount) {
            $this->credits -= $amount;
            return $this->save();
        }
        return false;
    }
}