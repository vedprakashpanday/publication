<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model 
{
    protected $fillable = ['code', 'discount_type', 'discount_value', 'min_cart_value', 'expires_at', 'is_active'];
}