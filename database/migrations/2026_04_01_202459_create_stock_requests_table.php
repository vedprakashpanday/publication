<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Terminal: php artisan make:migration create_stock_requests_table

public function up()
{
    Schema::create('stock_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kaunsa Seller mang raha hai
        $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Kaunsi specific edition wali book
        $table->integer('quantity');
        $table->enum('status', ['pending', 'approved', 'rejected', 'dispatched'])->default('pending');
        $table->text('admin_remark')->nullable(); // Admin ka koi message (e.g. "Sirf 30 available hain")
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_requests');
    }
};
