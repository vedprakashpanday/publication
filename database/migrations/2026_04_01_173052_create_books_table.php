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
    Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->foreignId('publisher_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->string('isbn_13')->unique();
        $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
        $table->string('edition')->nullable();
        $table->date('published_date')->nullable();
        $table->string('language')->default('Hindi');
        $table->integer('pages')->nullable();
        $table->enum('binding', ['Paperback', 'Hardbound', 'Spiral'])->default('Paperback');
        $table->decimal('price', 10, 2);
        $table->integer('quantity')->default(0);
        $table->text('description')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
