<?php

namespace App\Imports;

use App\Models\Soal;
use App\Models\PilihanJawaban;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class SoalImport implements ToCollection, WithHeadingRow
{
    protected $mataPelajaranId;
    protected $kelasId;

    public function __construct($mataPelajaranId, $kelasId)
    {
        $this->mataPelajaranId = $mataPelajaranId;
        $this->kelasId = $kelasId;
    }

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                // Lewati jika kolom pertanyaan kosong
                if (empty($row['pertanyaan'])) {
                    continue;
                }

                $jenisSoal = strtolower(trim($row['jenis_soal'] ?? 'pilihan_ganda'));
                if (!in_array($jenisSoal, ['pilihan_ganda', 'benar_salah', 'isian'])) {
                    $jenisSoal = 'pilihan_ganda';
                }

                $tingkatKesulitan = strtolower(trim($row['tingkat_kesulitan'] ?? 'sedang'));
                if (!in_array($tingkatKesulitan, ['mudah', 'sedang', 'sulit'])) {
                    $tingkatKesulitan = 'sedang';
                }

                // Buat Soal
                $soal = Soal::create([
                    'guru_id' => auth()->id(),
                    'mata_pelajaran_id' => $this->mataPelajaranId,
                    'kelas_id' => $this->kelasId,
                    'jenis_soal' => $jenisSoal,
                    'tingkat_kesulitan' => $tingkatKesulitan,
                    'pertanyaan' => trim($row['pertanyaan']),
                    'kunci_jawaban' => trim($row['kunci_jawaban'] ?? ''),
                    'pembahasan' => isset($row['pembahasan']) ? trim($row['pembahasan']) : null,
                    'poin' => (int)($row['poin'] ?? 10),
                    'status' => 'aktif',
                ]);

                // Jika Pilihan Ganda, insert pilihan jawaban
                if ($jenisSoal === 'pilihan_ganda') {
                    $labels = ['a', 'b', 'c', 'd', 'e'];
                    foreach ($labels as $label) {
                        $kolomPilihan = 'pilihan_' . $label;
                        if (!empty($row[$kolomPilihan])) {
                            PilihanJawaban::create([
                                'soal_id' => $soal->id,
                                'label' => strtoupper($label),
                                'isi_pilihan' => trim($row[$kolomPilihan]),
                                'is_benar' => strtoupper(trim($row['kunci_jawaban'] ?? '')) === strtoupper($label),
                            ]);
                        }
                    }
                }
            }
        });
    }
}
