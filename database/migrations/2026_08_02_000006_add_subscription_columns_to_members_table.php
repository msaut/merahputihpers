<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Menambahkan kolom langganan ke tabel members (additive, tidak merusak data)
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('status')->default('inactive')->comment('active, inactive')->after('email');
            $table->timestamp('subscription_start')->nullable()->after('status');
            $table->timestamp('subscription_end')->nullable()->after('subscription_start');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['status', 'subscription_start', 'subscription_end']);
        });
    }
};
