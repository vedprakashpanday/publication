<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailySale extends Model {
    protected $fillable = ['user_id', 'book_id', 'quantity_sold', 'total_price', 'sale_date'];

    public function seller() { return $this->belongsTo(User::class, 'user_id'); }
    public function book() { return $this->belongsTo(Book::class); }
}