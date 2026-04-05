<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('last_name')->nullable();
        $table->string('email')->unique();
        $table->string('phone')->unique();
        $table->string('password');
        $table->string('otp', 6)->nullable();
        $table->timestamp('otp_expires_at')->nullable();
        $table->string('profile_image')->nullable();
        $table->timestamp('email_verified_at')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
