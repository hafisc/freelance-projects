<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'type',
        'address', 'class', 'otp', 'otp_expires_at', 'is_verified'
    ];

    protected $hidden = [
        'password', 'remember_token', 'otp'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'is_verified' => 'boolean'
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPanitia()
    {
        return $this->role === 'panitia';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function isInternal()
    {
        return $this->type === 'internal';
    }

    public function isExternal()
    {
        return $this->type === 'external';
    }
}
