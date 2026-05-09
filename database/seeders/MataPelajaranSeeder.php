<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $mapel = [
            ['nama' => 'Matematika', 'kode' => 'MTK', 'warna' => '#3B82F6', 'deskripsi' => 'Pelajaran Matematika'],
            ['nama' => 'IPA', 'kode' => 'IPA', 'warna' => '#10B981', 'deskripsi' => 'Ilmu Pengetahuan Alam'],
            ['nama' => 'IPS', 'kode' => 'IPS', 'warna' => '#F59E0B', 'deskripsi' => 'Ilmu Pengetahuan Sosial'],
            ['nama' => 'Bahasa Indonesia', 'kode' => 'BIND', 'warna' => '#EF4444', 'deskripsi' => 'Pelajaran Bahasa Indonesia'],
            ['nama' => 'Bahasa Inggris', 'kode' => 'BING', 'warna' => '#8B5CF6', 'deskripsi' => 'Pelajaran Bahasa Inggris'],
            ['nama' => 'PKN', 'kode' => 'PKN', 'warna' => '#EC4899', 'deskripsi' => 'Pendidikan Kewarganegaraan'],
        ];

        foreach ($mapel as $m) {
            MataPelajaran::create($m);
        }
    }
}
