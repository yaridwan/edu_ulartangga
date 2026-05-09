<?php

namespace Database\Seeders;

use App\Models\PapanPermainan;
use Illuminate\Database\Seeder;

class PapanPermainanSeeder extends Seeder
{
    public function run(): void
    {
        PapanPermainan::create([
            'nama_papan' => 'Papan Standar',
            'jumlah_kotak' => 100,
            'konfigurasi_ular' => [
                ['dari' => 99, 'ke' => 80],
                ['dari' => 95, 'ke' => 75],
                ['dari' => 92, 'ke' => 88],
                ['dari' => 89, 'ke' => 68],
                ['dari' => 74, 'ke' => 53],
                ['dari' => 64, 'ke' => 60],
                ['dari' => 62, 'ke' => 19],
                ['dari' => 49, 'ke' => 11],
                ['dari' => 46, 'ke' => 25],
                ['dari' => 16, 'ke' => 6],
            ],
            'konfigurasi_tangga' => [
                ['dari' => 2, 'ke' => 38],
                ['dari' => 7, 'ke' => 14],
                ['dari' => 8, 'ke' => 31],
                ['dari' => 15, 'ke' => 26],
                ['dari' => 21, 'ke' => 42],
                ['dari' => 28, 'ke' => 84],
                ['dari' => 36, 'ke' => 44],
                ['dari' => 51, 'ke' => 67],
                ['dari' => 71, 'ke' => 91],
                ['dari' => 78, 'ke' => 98],
                ['dari' => 87, 'ke' => 94],
            ],
            'kotak_soal' => [3, 8, 12, 16, 22, 27, 33, 37, 42, 46, 50, 55, 58, 65, 69, 74, 79, 83, 88, 92, 96],
            'status' => 'aktif',
        ]);
    }
}
