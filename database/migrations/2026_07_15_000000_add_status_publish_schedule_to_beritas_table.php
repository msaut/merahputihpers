<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published'])->default('draft')->after('user_id');
            $table->dateTime('publish_at')->nullable()->after('status');
            $table->timestamp('published_at')->nullable()->after('publish_at');
            
            // Index supaya query filter status/publish_at lebih cepat
            $table->index('status');
            $table->index('publish_at');
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['publish_at']);
            $table->dropColumn(['status', 'publish_at', 'published_at']);
        });
    }
};

