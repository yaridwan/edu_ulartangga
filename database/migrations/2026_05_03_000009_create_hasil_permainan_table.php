<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_permainan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permainan_id')->constrained('permainan')->cascadeOnDelete();
            $table->foreignId('pemain_permainan_id')->constrained('pemain_permainan')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('skor_akhir')->default(0);
            $table->integer('jumlah_benar')->default(0);
            $table->integer('jumlah_salah')->default(0);
            $table->integer('durasi_detik')->default(0);
            $table->integer('peringkat')->default(0);
            $table->enum('status', ['menang', 'kalah', 'selesai'])->default('selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_permainan');
    }
};
