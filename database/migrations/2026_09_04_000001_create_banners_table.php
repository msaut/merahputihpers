<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('gambar')->nullable();
            $table->string('link')->nullable();
            $table->enum('posisi', ['header', 'leaderboard', 'sidebar', 'mobile', 'square']);
            $table->enum('target', ['_self', '_blank'])->default('_blank');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedInteger('urutan')->default(0);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('alt_text')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('clicks')->default(0);
            $table->string('validation_mode')->default('recommended');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
