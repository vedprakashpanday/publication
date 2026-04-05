<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // E-commerce auth ke liye phone aur OTP zaroori hain
            $table->string('phone')->unique()->nullable()->after('email');
            $table->string('otp')->nullable()->after('password');
            $table->timestamp('otp_expires_at')->nullable()->after('otp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'otp', 'otp_expires_at']);
        });
    }
};
