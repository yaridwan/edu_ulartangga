<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'deskripsi',
        'status',
    ];

    public function siswa()
    {
        return $this->hasMany(User::class, 'kelas_id');
    }

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
