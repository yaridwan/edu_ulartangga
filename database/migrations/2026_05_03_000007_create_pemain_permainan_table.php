<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemain_permainan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permainan_id')->constrained('permainan')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_pemain');
            $table->enum('tipe_pemain', ['siswa', 'lokal', 'komputer'])->default('siswa');
            $table->string('warna_pion')->default('#3B82F6');
            $table->string('avatar_pion')->nullable();
            $table->integer('posisi')->default(0);
            $table->integer('skor')->default(0);
            $table->integer('jumlah_benar')->default(0);
            $table->integer('jumlah_salah')->default(0);
            $table->integer('jumlah_giliran')->default(0);
            $table->enum('status', ['aktif', 'menang', 'kalah'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemain_permainan');
    }
};
