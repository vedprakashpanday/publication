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
    Schema::table('books', function (Blueprint $table) {
        $table->foreignId('category_id')->nullable()->after('publisher_id')->constrained('categories')->onDelete('set null');
        $table->decimal('mrp', 10, 2)->nullable()->after('price'); // Original Price for discount display
        $table->boolean('is_exclusive')->default(false)->after('is_active'); // "Only on Divyansh" section ke liye
    });
}

    /**
     * Reverse the migrations.
     */
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Pehle foreign key constraint ko drop karo
            $table->dropForeign(['category_id']);
            
            // Phir un teeno columns ko drop karo
            $table->dropColumn(['category_id', 'mrp', 'is_exclusive']);
        });
    }
};
