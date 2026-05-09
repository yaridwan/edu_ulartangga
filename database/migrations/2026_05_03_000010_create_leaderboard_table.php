<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaderboard', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->cascadeOnDelete();
            $table->integer('total_skor')->default(0);
            $table->integer('total_menang')->default(0);
            $table->integer('total_permainan')->default(0);
            $table->decimal('rata_rata_skor', 8, 2)->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'kelas_id', 'mata_pelajaran_id'], 'leaderboard_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaderboard');
    }
};
