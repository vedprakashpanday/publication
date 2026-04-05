<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model {
   // $fillable array mein ye naye columns add karein
    protected $fillable = [
        'publisher_id', 'author_id', 'category_id', 'title', 'isbn_13', 'edition', 
        'published_date', 'binding', 'mrp', 'price', 'quantity', 'description', 
        'is_exclusive', 'is_active'
    ];

    // Naya Relation
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function publisher() { return $this->belongsTo(Publisher::class); }

    // Ek book ki bahut saari images ho sakti hain
    public function images() { return $this->hasMany(BookImage::class); }

    public function author() {
    return $this->belongsTo(Author::class);
}
}
