<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permainan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_permainan')->unique();
            $table->enum('mode', ['solo', 'lokal', 'komputer'])->default('solo');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('papan_permainan_id')->nullable()->constrained('papan_permainan')->nullOnDelete();
            $table->integer('jumlah_pemain')->default(1);
            $table->integer('jumlah_kotak')->default(100);
            $table->enum('status', ['berjalan', 'selesai', 'batal'])->default('berjalan');
            $table->timestamp('dimulai_pada')->nullable();
            $table->timestamp('selesai_pada')->nullable();
            $table->foreignId('pemenang_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permainan');
    }
};
