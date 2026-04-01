<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model {
    protected $fillable = ['name', 'profile_image', 'born_date', 'death_date', 'about', 'famous_works'];

    public function books() {
        return $this->hasMany(Book::class);
    }
}