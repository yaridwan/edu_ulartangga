<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban_permainan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permainan_id')->constrained('permainan')->cascadeOnDelete();
            $table->foreignId('pemain_permainan_id')->constrained('pemain_permainan')->cascadeOnDelete();
            $table->foreignId('soal_id')->constrained('soal')->cascadeOnDelete();
            $table->text('jawaban')->nullable();
            $table->boolean('is_benar')->default(false);
            $table->integer('poin_diperoleh')->default(0);
            $table->integer('waktu_jawab')->nullable(); // dalam detik
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_permainan');
    }
};
