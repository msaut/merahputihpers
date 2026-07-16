<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });

        // Prevent duplicate FK error if constraint already exists
        DB::statement('ALTER TABLE `beritas` DROP FOREIGN KEY `beritas_user_id_foreign`');
        DB::statement('ALTER TABLE `beritas`
            ADD CONSTRAINT `beritas_user_id_foreign`
            FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
            ON DELETE SET NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE `beritas` DROP FOREIGN KEY `beritas_user_id_foreign`');

        Schema::table('beritas', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
