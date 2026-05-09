<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $dataKelas = [
            ['nama_kelas' => 'Kelas 4 SD', 'tingkat' => 'SD'],
            ['nama_kelas' => 'Kelas 5 SD', 'tingkat' => 'SD'],
            ['nama_kelas' => 'Kelas 6 SD', 'tingkat' => 'SD'],
            ['nama_kelas' => 'Kelas 7 SMP', 'tingkat' => 'SMP'],
            ['nama_kelas' => 'Kelas 8 SMP', 'tingkat' => 'SMP'],
            ['nama_kelas' => 'Kelas 9 SMP', 'tingkat' => 'SMP'],
            ['nama_kelas' => 'Kelas 10 SMA', 'tingkat' => 'SMA'],
            ['nama_kelas' => 'Kelas 11 SMA', 'tingkat' => 'SMA'],
            ['nama_kelas' => 'Kelas 12 SMA', 'tingkat' => 'SMA'],
        ];

        foreach ($dataKelas as $kelas) {
            Kelas::create($kelas);
        }
    }
}
