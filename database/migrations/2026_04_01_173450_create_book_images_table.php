<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('book_images', function (Blueprint $table) {
        $table->id();
        $table->foreignId('book_id')->constrained()->onDelete('cascade');
        $table->string('image_path');
        $table->string('image_type')->default('front'); // front, back, side, internal_page
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_images');
    }
};
