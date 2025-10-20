<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi (membuat tabel mahasiswa)
     */
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20)->unique();
            $table->string('nama', 100);
            // Ganti kolom 'prodi' lama dengan relasi ke tabel 'prodi'
            $table->foreignId('prodi_id')->constrained('prodi')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi (hapus tabel mahasiswa)
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
