<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model 
{
    // 🌟 CHANGE 1: Laravel ko table ka asli naam batana
    protected $table = 'customer_addresses';

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'phone', 
        'address_line', 'apartment', 'city', 'state', 'pincode', 'is_default'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}