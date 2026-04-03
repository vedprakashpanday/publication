<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('buyer_stories', function (Blueprint $table) {
        $table->string('x_url')->nullable()->after('facebook_url');
        $table->string('threads_url')->nullable()->after('x_url');
        $table->string('whatsapp_url')->nullable()->after('threads_url');
    });
}

public function down()
{
    Schema::table('buyer_stories', function (Blueprint $table) {
        $table->dropColumn(['x_url', 'threads_url', 'whatsapp_url']);
    });
}
};
