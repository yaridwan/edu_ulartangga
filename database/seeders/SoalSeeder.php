<?php

namespace Database\Seeders;

use App\Models\Materi;
use App\Models\Soal;
use App\Models\PilihanJawaban;
use Illuminate\Database\Seeder;

class SoalSeeder extends Seeder
{
    public function run(): void
    {
        // Buat materi contoh untuk Matematika Kelas 4 SD
        $materi = Materi::create([
            'mata_pelajaran_id' => 1, // Matematika
            'kelas_id' => 1, // Kelas 4 SD
            'judul' => 'Operasi Hitung Bilangan',
            'deskripsi' => 'Penjumlahan, pengurangan, perkalian, dan pembagian',
        ]);

        $soalData = [
            [
                'pertanyaan' => 'Berapakah hasil dari 25 + 37?',
                'kunci_jawaban' => 'B',
                'tingkat_kesulitan' => 'mudah',
                'poin' => 10,
                'pembahasan' => '25 + 37 = 62. Jumlahkan satuan: 5+7=12, tulis 2 simpan 1. Jumlahkan puluhan: 2+3+1=6.',
                'pilihan' => [
                    ['label' => 'A', 'isi_pilihan' => '52', 'is_benar' => false],
                    ['label' => 'B', 'isi_pilihan' => '62', 'is_benar' => true],
                    ['label' => 'C', 'isi_pilihan' => '72', 'is_benar' => false],
                    ['label' => 'D', 'isi_pilihan' => '42', 'is_benar' => false],
                ],
            ],
            [
                'pertanyaan' => 'Hasil dari 8 × 7 adalah ...',
                'kunci_jawaban' => 'C',
                'tingkat_kesulitan' => 'mudah',
                'poin' => 10,
                'pembahasan' => '8 × 7 = 56. Ini adalah perkalian dasar yang perlu dihafal.',
                'pilihan' => [
                    ['label' => 'A', 'isi_pilihan' => '48', 'is_benar' => false],
                    ['label' => 'B', 'isi_pilihan' => '54', 'is_benar' => false],
                    ['label' => 'C', 'isi_pilihan' => '56', 'is_benar' => true],
                    ['label' => 'D', 'isi_pilihan' => '63', 'is_benar' => false],
                ],
            ],
            [
                'pertanyaan' => 'Berapakah hasil dari 144 ÷ 12?',
                'kunci_jawaban' => 'A',
                'tingkat_kesulitan' => 'sedang',
                'poin' => 15,
                'pembahasan' => '144 ÷ 12 = 12. Karena 12 × 12 = 144.',
                'pilihan' => [
                    ['label' => 'A', 'isi_pilihan' => '12', 'is_benar' => true],
                    ['label' => 'B', 'isi_pilihan' => '14', 'is_benar' => false],
                    ['label' => 'C', 'isi_pilihan' => '11', 'is_benar' => false],
                    ['label' => 'D', 'isi_pilihan' => '13', 'is_benar' => false],
                ],
            ],
            [
                'pertanyaan' => 'Urutan bilangan dari yang terkecil adalah ...',
                'kunci_jawaban' => 'B',
                'tingkat_kesulitan' => 'sedang',
                'poin' => 15,
                'pembahasan' => 'Urutan dari terkecil: 234, 243, 324, 342. Bandingkan nilai ratusan terlebih dahulu.',
                'pilihan' => [
                    ['label' => 'A', 'isi_pilihan' => '324, 243, 342, 234', 'is_benar' => false],
                    ['label' => 'B', 'isi_pilihan' => '234, 243, 324, 342', 'is_benar' => true],
                    ['label' => 'C', 'isi_pilihan' => '342, 324, 243, 234', 'is_benar' => false],
                    ['label' => 'D', 'isi_pilihan' => '243, 234, 342, 324', 'is_benar' => false],
                ],
            ],
            [
                'pertanyaan' => 'Nilai dari 1.250 + 3.780 - 2.030 adalah ...',
                'kunci_jawaban' => 'D',
                'tingkat_kesulitan' => 'sulit',
                'poin' => 20,
                'pembahasan' => '1.250 + 3.780 = 5.030. Kemudian 5.030 - 2.030 = 3.000.',
                'pilihan' => [
                    ['label' => 'A', 'isi_pilihan' => '2.000', 'is_benar' => false],
                    ['label' => 'B', 'isi_pilihan' => '2.500', 'is_benar' => false],
                    ['label' => 'C', 'isi_pilihan' => '3.500', 'is_benar' => false],
                    ['label' => 'D', 'isi_pilihan' => '3.000', 'is_benar' => true],
                ],
            ],
            [
                'pertanyaan' => 'Bilangan 1, 1, 2, 3, 5, 8, ... . Bilangan selanjutnya adalah ...',
                'kunci_jawaban' => 'B',
                'tingkat_kesulitan' => 'sulit',
                'poin' => 20,
                'pembahasan' => 'Ini adalah deret Fibonacci. Setiap bilangan adalah jumlah dari dua bilangan sebelumnya. 5 + 8 = 13.',
                'pilihan' => [
                    ['label' => 'A', 'isi_pilihan' => '11', 'is_benar' => false],
                    ['label' => 'B', 'isi_pilihan' => '13', 'is_benar' => true],
                    ['label' => 'C', 'isi_pilihan' => '15', 'is_benar' => false],
                    ['label' => 'D', 'isi_pilihan' => '10', 'is_benar' => false],
                ],
            ],
        ];

        foreach ($soalData as $data) {
            $soal = Soal::create([
                'guru_id' => 2, // Guru Demo
                'mata_pelajaran_id' => 1,
                'kelas_id' => 1,
                'materi_id' => $materi->id,
                'jenis_soal' => 'pilihan_ganda',
                'tingkat_kesulitan' => $data['tingkat_kesulitan'],
                'pertanyaan' => $data['pertanyaan'],
                'kunci_jawaban' => $data['kunci_jawaban'],
                'pembahasan' => $data['pembahasan'],
                'poin' => $data['poin'],
                'status' => 'aktif',
            ]);

            foreach ($data['pilihan'] as $pilihan) {
                PilihanJawaban::create([
                    'soal_id' => $soal->id,
                    'label' => $pilihan['label'],
                    'isi_pilihan' => $pilihan['isi_pilihan'],
                    'is_benar' => $pilihan['is_benar'],
                ]);
            }
        }
    }
}
