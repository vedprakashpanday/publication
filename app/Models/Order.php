<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id', 'total_amount', 'order_number', 'status', 'payment_status', 'shipping_address', 'notes'];

   public function user() {
        // Agar table me customer_id hai, to relation bhi waise hi banegi
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}