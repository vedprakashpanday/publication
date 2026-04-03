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
    Schema::create('buyer_stories', function (Blueprint $table) {
        $table->id();
        $table->string('image_path'); // Buyer ki photo
        $table->string('buyer_name')->nullable(); // Buyer ka naam
        $table->string('event_name')->nullable(); // Event ya Shop ka naam
        $table->date('event_date')->nullable(); // Kab ki photo hai
        $table->string('instagram_url')->nullable(); // Insta link
        $table->string('facebook_url')->nullable(); // FB link
        $table->boolean('is_active')->default(true); // Show/Hide control
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_stories');
    }
};
