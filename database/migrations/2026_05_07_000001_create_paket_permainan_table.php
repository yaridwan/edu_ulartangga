<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_permainan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('mode', ['solo', 'lokal', 'komputer'])->default('solo');
            $table->integer('maks_pemain')->default(4);
            $table->integer('jumlah_soal')->default(20);
            $table->integer('poin_benar')->default(10);
            $table->integer('poin_salah')->default(-5);
            $table->integer('bonus_langkah')->default(0);
            $table->integer('penalti_langkah')->default(0);
            $table->boolean('tampilkan_pembahasan')->default(true);
            $table->boolean('acak_soal')->default(true);
            $table->integer('waktu_jawab')->nullable()->comment('Batas waktu menjawab dalam detik');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });

        // Add paket_permainan_id to permainan table
        Schema::table('permainan', function (Blueprint $table) {
            $table->foreignId('paket_permainan_id')->nullable()->after('kode_permainan')
                  ->constrained('paket_permainan')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('permainan', function (Blueprint $table) {
            $table->dropConstrainedForeignId('paket_permainan_id');
        });
        Schema::dropIfExists('paket_permainan');
    }
};
