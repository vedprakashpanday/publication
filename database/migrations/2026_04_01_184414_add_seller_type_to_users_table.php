<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Nullable isliye kyunki Admin aur normal User ka koi seller type nahi hoga
            $table->enum('seller_type', ['book_fair', 'book_store'])->nullable()->after('role');
            $table->string('shop_name')->nullable()->after('seller_type'); // Store walo ke liye
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['seller_type', 'shop_name']);
        });
    }
};
