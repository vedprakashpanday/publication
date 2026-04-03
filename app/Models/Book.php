<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model {
    protected $fillable = [
        'publisher_id',
        'author_id',       // <-- Ye missing tha
        'title',
        'isbn_13',
        'edition',         // <-- Naya column
        'published_date',  // <-- Naya column
        'binding',         // <-- Naya column
        'price',
        'quantity',
        'description',
        
        'is_active',
    ];

    public function publisher() { return $this->belongsTo(Publisher::class); }

    // Ek book ki bahut saari images ho sakti hain
    public function images() { return $this->hasMany(BookImage::class); }

    public function author() {
    return $this->belongsTo(Author::class);
}
}
