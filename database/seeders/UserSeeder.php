<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@edut.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);
        $admin->assignRole('admin');

        $guru = User::create([
            'name' => 'Guru Demo',
            'email' => 'guru@edut.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'status' => 'aktif',
        ]);
        $guru->assignRole('guru');

        $siswa = User::create([
            'name' => 'Siswa Demo',
            'email' => 'siswa@edut.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'kelas_id' => 1,
            'status' => 'aktif',
        ]);
        $siswa->assignRole('siswa');
    }
}
