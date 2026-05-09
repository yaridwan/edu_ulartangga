<?php

namespace Database\Seeders;

use App\Models\PengaturanAplikasi;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        $pengaturan = [
            ['key' => 'nama_aplikasi', 'value' => 'Edu Ular Tangga', 'type' => 'text'],
            ['key' => 'deskripsi_aplikasi', 'value' => 'Belajar Jadi Lebih Seru dengan Ular Tangga Edukatif', 'type' => 'text'],
            ['key' => 'logo', 'value' => null, 'type' => 'image'],
            ['key' => 'favicon', 'value' => null, 'type' => 'image'],
            ['key' => 'warna_tema', 'value' => '#3B82F6', 'type' => 'text'],
            ['key' => 'suara_aktif', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'musik_aktif', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'jumlah_kotak', 'value' => '100', 'type' => 'number'],
            ['key' => 'jumlah_ular', 'value' => '8', 'type' => 'number'],
            ['key' => 'jumlah_tangga', 'value' => '8', 'type' => 'number'],
            ['key' => 'poin_benar_mudah', 'value' => '10', 'type' => 'number'],
            ['key' => 'poin_benar_sedang', 'value' => '15', 'type' => 'number'],
            ['key' => 'poin_benar_sulit', 'value' => '20', 'type' => 'number'],
            ['key' => 'poin_salah', 'value' => '-5', 'type' => 'number'],
            ['key' => 'poin_naik_tangga', 'value' => '5', 'type' => 'number'],
            ['key' => 'poin_turun_ular', 'value' => '-5', 'type' => 'number'],
            ['key' => 'poin_menang', 'value' => '30', 'type' => 'number'],
            ['key' => 'poin_jawab_cepat', 'value' => '5', 'type' => 'number'],
            ['key' => 'batas_jawab_cepat', 'value' => '10', 'type' => 'number'],
            ['key' => 'aturan_melebihi_kotak', 'value' => 'mundur', 'type' => 'text'], // mundur / diam
            ['key' => 'pwa_aktif', 'value' => '0', 'type' => 'boolean'],
        ];

        foreach ($pengaturan as $p) {
            PengaturanAplikasi::create($p);
        }
    }
}
