<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  // database/migrations/xxxx_create_orders_table.php
public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('order_number')->unique();
        $table->decimal('total_amount', 10, 2);
        
        // Status Fields
        $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
        $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');

        // Tracking Fields (Indian Post etc.)
        $table->string('courier_name')->nullable(); // e.g., Indian Post
        $table->string('tracking_id')->nullable();  // e.g., EL123456789IN
        $table->text('tracking_msg')->nullable();   // e.g., "Left Delhi Hub"
        
        $table->text('shipping_address');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
