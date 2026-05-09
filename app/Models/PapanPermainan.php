<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PapanPermainan extends Model
{
    use HasFactory;

    protected $table = 'papan_permainan';

    protected $fillable = [
        'nama_papan',
        'jumlah_kotak',
        'konfigurasi_ular',
        'konfigurasi_tangga',
        'kotak_soal',
        'status',
    ];

    protected $casts = [
        'konfigurasi_ular' => 'array',
        'konfigurasi_tangga' => 'array',
        'kotak_soal' => 'array',
    ];

    public function permainan()
    {
        return $this->hasMany(Permainan::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Cek apakah posisi terkena ular
     */
    public function cekUlar(int $posisi): ?int
    {
        foreach ($this->konfigurasi_ular as $ular) {
            if ($ular['dari'] == $posisi) {
                return $ular['ke'];
            }
        }
        return null;
    }

    /**
     * Cek apakah posisi terkena tangga
     */
    public function cekTangga(int $posisi): ?int
    {
        foreach ($this->konfigurasi_tangga as $tangga) {
            if ($tangga['dari'] == $posisi) {
                return $tangga['ke'];
            }
        }
        return null;
    }

    /**
     * Cek apakah posisi adalah kotak soal
     */
    public function isKotakSoal(int $posisi): bool
    {
        return in_array($posisi, $this->kotak_soal ?? []);
    }
}
