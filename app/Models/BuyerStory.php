<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyerStory extends Model
{
   protected $fillable = ['image_path', 'buyer_name', 'event_name', 'event_date', 'instagram_url', 'facebook_url', 'is_active'];
}
