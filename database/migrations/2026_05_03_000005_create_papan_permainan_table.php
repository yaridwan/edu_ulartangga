<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('papan_permainan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_papan');
            $table->integer('jumlah_kotak')->default(100);
            $table->json('konfigurasi_ular'); // [{"dari": 98, "ke": 78}, ...]
            $table->json('konfigurasi_tangga'); // [{"dari": 4, "ke": 14}, ...]
            $table->json('kotak_soal'); // [5, 12, 23, ...]
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('papan_permainan');
    }
};
