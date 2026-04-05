<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
{
    Schema::create('sellers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone')->unique();
        $table->string('password');
        $table->enum('seller_type', ['book_fair', 'book_store']);
        $table->string('shop_name')->nullable();
        $table->string('profile_image')->nullable();
        $table->boolean('is_approved')->default(false); // Admin verify karega
        $table->rememberToken();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
