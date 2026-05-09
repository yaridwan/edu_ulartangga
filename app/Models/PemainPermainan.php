<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemainPermainan extends Model
{
    use HasFactory;

    protected $table = 'pemain_permainan';

    protected $fillable = [
        'permainan_id',
        'user_id',
        'nama_pemain',
        'tipe_pemain',
        'warna_pion',
        'avatar_pion',
        'posisi',
        'skor',
        'jumlah_benar',
        'jumlah_salah',
        'jumlah_giliran',
        'status',
    ];

    public function permainan()
    {
        return $this->belongsTo(Permainan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanPermainan::class);
    }

    public function hasilPermainan()
    {
        return $this->hasOne(HasilPermainan::class);
    }
}
