<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 'role' ko fillable mein add karna zaroori hai
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'seller_type', // Naya add kiya
        'shop_name',   // Naya add kiya
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

    // Role check karne ke helper functions
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    // Seller ke liye relationships
    public function stockRequests()
    {
        return $this->hasMany(StockRequest::class, 'user_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_id');
    }
}