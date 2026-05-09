<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPermainan extends Model
{
    use HasFactory;

    protected $table = 'hasil_permainan';

    protected $fillable = [
        'permainan_id',
        'pemain_permainan_id',
        'user_id',
        'skor_akhir',
        'jumlah_benar',
        'jumlah_salah',
        'durasi_detik',
        'peringkat',
        'status',
    ];

    public function permainan()
    {
        return $this->belongsTo(Permainan::class);
    }

    public function pemainPermainan()
    {
        return $this->belongsTo(PemainPermainan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
