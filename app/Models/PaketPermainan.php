<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketPermainan extends Model
{
    use HasFactory;

    protected $table = 'paket_permainan';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
        'kelas_id',
        'judul',
        'deskripsi',
        'mode',
        'maks_pemain',
        'jumlah_soal',
        'poin_benar',
        'poin_salah',
        'bonus_langkah',
        'penalti_langkah',
        'tampilkan_pembahasan',
        'acak_soal',
        'waktu_jawab',
        'status',
    ];

    protected $casts = [
        'tampilkan_pembahasan' => 'boolean',
        'acak_soal' => 'boolean',
    ];

    // === Relasi ===

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function permainan()
    {
        return $this->hasMany(Permainan::class);
    }

    // === Scopes ===

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeByGuru($query, $guruId)
    {
        return $query->where('guru_id', $guruId);
    }

    // === Helpers ===

    /**
     * Hitung jumlah soal tersedia untuk paket ini
     */
    public function jumlahSoalTersedia(): int
    {
        return Soal::where('mata_pelajaran_id', $this->mata_pelajaran_id)
            ->where('kelas_id', $this->kelas_id)
            ->where('status', 'aktif')
            ->count();
    }

    /**
     * Hitung jumlah sesi permainan yang sudah dibuat dari paket ini
     */
    public function jumlahSesiDimainkan(): int
    {
        return $this->permainan()->count();
    }
}
