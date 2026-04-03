<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'book_id',
        'seller_id',
        'sale_date',
        'quantity',
        'total_price',
    ];

    // app/Models/Sale.php
public function seller() {
    return $this->belongsTo(User::class, 'user_id');
}

public function book() {
    return $this->belongsTo(Book::class);
}

  
}
