<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'kelas_id',
        'avatar',
        'bintang',
        'level',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function soal()
    {
        return $this->hasMany(Soal::class, 'guru_id');
    }

    public function permainanDibuat()
    {
        return $this->hasMany(Permainan::class, 'created_by');
    }

    public function pemainPermainan()
    {
        return $this->hasMany(PemainPermainan::class);
    }

    public function hasilPermainan()
    {
        return $this->hasMany(HasilPermainan::class);
    }

    public function leaderboard()
    {
        return $this->hasMany(Leaderboard::class);
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }
}
