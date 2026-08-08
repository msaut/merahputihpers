<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Koleksi koran digital (PDF) - hanya untuk member aktif
    public function up(): void
    {
        Schema::create('koran_pdfs', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('file')->comment('Path file PDF');
            $table->date('tanggal')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koran_pdfs');
    }
};
