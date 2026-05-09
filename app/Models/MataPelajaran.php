<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'warna',
        'status',
    ];

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }

    public function permainan()
    {
        return $this->hasMany(Permainan::class);
    }

    public function leaderboard()
    {
        return $this->hasMany(Leaderboard::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
