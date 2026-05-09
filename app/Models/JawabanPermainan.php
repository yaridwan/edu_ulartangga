<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanPermainan extends Model
{
    use HasFactory;

    protected $table = 'jawaban_permainan';

    protected $fillable = [
        'permainan_id',
        'pemain_permainan_id',
        'soal_id',
        'jawaban',
        'is_benar',
        'poin_diperoleh',
        'waktu_jawab',
    ];

    protected $casts = [
        'is_benar' => 'boolean',
    ];

    public function permainan()
    {
        return $this->belongsTo(Permainan::class);
    }

    public function pemainPermainan()
    {
        return $this->belongsTo(PemainPermainan::class);
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}
