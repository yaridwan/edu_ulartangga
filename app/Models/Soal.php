<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $table = 'soal';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
        'kelas_id',
        'materi_id',
        'jenis_soal',
        'tingkat_kesulitan',
        'pertanyaan',
        'kunci_jawaban',
        'pembahasan',
        'poin',
        'status',
    ];

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

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function pilihanJawaban()
    {
        return $this->hasMany(PilihanJawaban::class);
    }

    public function jawabanPermainan()
    {
        return $this->hasMany(JawabanPermainan::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeByKesulitan($query, $tingkat)
    {
        return $query->where('tingkat_kesulitan', $tingkat);
    }
}
