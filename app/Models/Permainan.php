<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permainan extends Model
{
    use HasFactory;

    protected $table = 'permainan';

    protected $fillable = [
        'kode_permainan',
        'paket_permainan_id',
        'mode',
        'mata_pelajaran_id',
        'kelas_id',
        'materi_id',
        'papan_permainan_id',
        'jumlah_pemain',
        'jumlah_kotak',
        'status',
        'dimulai_pada',
        'selesai_pada',
        'pemenang_id',
        'created_by',
    ];

    protected $casts = [
        'dimulai_pada' => 'datetime',
        'selesai_pada' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->kode_permainan)) {
                $model->kode_permainan = 'GAME-' . strtoupper(Str::random(8));
            }
        });
    }

    public function paketPermainan()
    {
        return $this->belongsTo(PaketPermainan::class);
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

    public function papanPermainan()
    {
        return $this->belongsTo(PapanPermainan::class);
    }

    public function pemain()
    {
        return $this->hasMany(PemainPermainan::class);
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanPermainan::class);
    }

    public function hasil()
    {
        return $this->hasMany(HasilPermainan::class);
    }

    public function pemenang()
    {
        return $this->belongsTo(User::class, 'pemenang_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isBerjalan(): bool
    {
        return $this->status === 'berjalan';
    }

    public function isSelesai(): bool
    {
        return $this->status === 'selesai';
    }
}
