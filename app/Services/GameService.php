<?php

namespace App\Services;

use App\Models\Permainan;
use App\Models\PemainPermainan;
use App\Models\PapanPermainan;
use App\Models\Soal;
use App\Models\JawabanPermainan;
use App\Models\HasilPermainan;
use App\Models\Leaderboard;
use App\Models\PengaturanAplikasi;

class GameService
{
    /**
     * Lempar dadu — generate angka 1-6
     */
    public function lemparDadu(): int
    {
        return rand(1, 6);
    }

    /**
     * Hitung posisi baru setelah lempar dadu
     */
    public function hitungPosisiBaru(int $posisiSekarang, int $angkaDadu, int $jumlahKotak): int
    {
        $posisiBaru = $posisiSekarang + $angkaDadu;

        if ($posisiBaru > $jumlahKotak) {
            $aturan = PengaturanAplikasi::getValue('aturan_melebihi_kotak', 'mundur');
            if ($aturan === 'mundur') {
                $selisih = $posisiBaru - $jumlahKotak;
                $posisiBaru = $jumlahKotak - $selisih;
            } else {
                // diam di tempat
                $posisiBaru = $posisiSekarang;
            }
        }

        return $posisiBaru;
    }

    /**
     * Cek ular dan tangga, return posisi akhir dan event
     */
    public function cekUlarTangga(PapanPermainan $papan, int $posisi): array
    {
        // Cek tangga dulu
        $tujuanTangga = $papan->cekTangga($posisi);
        if ($tujuanTangga !== null) {
            return [
                'posisi_akhir' => $tujuanTangga,
                'event' => 'tangga',
                'dari' => $posisi,
                'ke' => $tujuanTangga,
            ];
        }

        // Cek ular
        $tujuanUlar = $papan->cekUlar($posisi);
        if ($tujuanUlar !== null) {
            return [
                'posisi_akhir' => $tujuanUlar,
                'event' => 'ular',
                'dari' => $posisi,
                'ke' => $tujuanUlar,
            ];
        }

        return [
            'posisi_akhir' => $posisi,
            'event' => null,
            'dari' => $posisi,
            'ke' => $posisi,
        ];
    }

    /**
     * Ambil soal acak yang belum dijawab pada sesi ini
     */
    public function ambilSoal(Permainan $permainan): ?Soal
    {
        $soalSudahDijawab = JawabanPermainan::where('permainan_id', $permainan->id)
            ->pluck('soal_id')
            ->toArray();

        $soal = Soal::where('mata_pelajaran_id', $permainan->mata_pelajaran_id)
            ->where('kelas_id', $permainan->kelas_id)
            ->where('status', 'aktif')
            ->whereNotIn('id', $soalSudahDijawab)
            ->with('pilihanJawaban')
            ->inRandomOrder()
            ->first();

        // Jika semua soal sudah dijawab, reset dan ambil ulang
        if (!$soal) {
            $soal = Soal::where('mata_pelajaran_id', $permainan->mata_pelajaran_id)
                ->where('kelas_id', $permainan->kelas_id)
                ->where('status', 'aktif')
                ->with('pilihanJawaban')
                ->inRandomOrder()
                ->first();
        }

        return $soal;
    }

    /**
     * Proses jawaban pemain
     */
    public function prosesJawaban(Permainan $permainan, PemainPermainan $pemain, Soal $soal, string $jawaban, ?int $waktuJawab = null): array
    {
        $isBenar = strtoupper(trim($jawaban)) === strtoupper(trim($soal->kunci_jawaban));
        $poin = 0;
        $langkahTambahan = 0;

        $paket = $permainan->paketPermainan;

        if ($isBenar) {
            if ($paket) {
                $poin = $paket->poin_benar;
                $langkahTambahan = $paket->bonus_langkah;
            } else {
                $poin = match ($soal->tingkat_kesulitan) {
                    'mudah' => (int) PengaturanAplikasi::getValue('poin_benar_mudah', 10),
                    'sedang' => (int) PengaturanAplikasi::getValue('poin_benar_sedang', 15),
                    'sulit' => (int) PengaturanAplikasi::getValue('poin_benar_sulit', 20),
                };
                
                // Bonus jawab cepat
                $batasJawabCepat = (int) PengaturanAplikasi::getValue('batas_jawab_cepat', 10);
                if ($waktuJawab && $waktuJawab <= $batasJawabCepat) {
                    $poin += (int) PengaturanAplikasi::getValue('poin_jawab_cepat', 5);
                }
            }
        } else {
            if ($paket) {
                $poin = $paket->poin_salah;
                $langkahTambahan = -1 * $paket->penalti_langkah;
            } else {
                $poin = (int) PengaturanAplikasi::getValue('poin_salah', -5);
            }
        }

        // Simpan jawaban
        JawabanPermainan::create([
            'permainan_id' => $permainan->id,
            'pemain_permainan_id' => $pemain->id,
            'soal_id' => $soal->id,
            'jawaban' => $jawaban,
            'is_benar' => $isBenar,
            'poin_diperoleh' => $poin,
            'waktu_jawab' => $waktuJawab,
        ]);

        // Update skor pemain
        $pemain->skor += $poin;
        if ($isBenar) {
            $pemain->jumlah_benar++;
            
            // Gamification: Tambah Bintang
            if ($pemain->user_id) {
                $user = \App\Models\User::find($pemain->user_id);
                if ($user) {
                    $bintangBenar = (int) PengaturanAplikasi::getValue('bintang_jawab_benar', 5);
                    $user->bintang += $bintangBenar;
                    if ($user->bintang >= ($user->level * 100)) {
                        $user->level++;
                    }
                    $user->save();
                }
            }
        } else {
            $pemain->jumlah_salah++;
        }
        $pemain->save();

        return [
            'is_benar' => $isBenar,
            'poin' => $poin,
            'langkah_tambahan' => $langkahTambahan,
            'skor_total' => $pemain->skor,
            'pembahasan' => ($paket && !$paket->tampilkan_pembahasan) ? null : $soal->pembahasan,
            'kunci_jawaban' => $soal->kunci_jawaban,
        ];
    }

    /**
     * Tambah poin untuk event ular/tangga
     */
    public function prosesEventPoin(PemainPermainan $pemain, string $event): void
    {
        if ($event === 'tangga') {
            $poin = (int) PengaturanAplikasi::getValue('poin_naik_tangga', 5);
            $pemain->skor += $poin;
        } elseif ($event === 'ular') {
            $poin = (int) PengaturanAplikasi::getValue('poin_turun_ular', -5);
            $pemain->skor += $poin;
        }
        $pemain->save();
    }

    /**
     * Cek apakah pemain menang
     */
    public function cekMenang(PemainPermainan $pemain, int $jumlahKotak): bool
    {
        return $pemain->posisi >= $jumlahKotak;
    }

    /**
     * Selesaikan permainan
     */
    public function selesaikanPermainan(Permainan $permainan, PemainPermainan $pemenang): void
    {
        // Tambah poin menang
        $poinMenang = (int) PengaturanAplikasi::getValue('poin_menang', 30);
        $pemenang->skor += $poinMenang;
        $pemenang->status = 'menang';
        $pemenang->save();

        // Gamification: Bintang Menang
        if ($pemenang->user_id) {
            $user = \App\Models\User::find($pemenang->user_id);
            if ($user) {
                $bintangMenang = (int) PengaturanAplikasi::getValue('bintang_menang', 50);
                $user->bintang += $bintangMenang;
                if ($user->bintang >= ($user->level * 100)) {
                    $user->level++;
                }
                $user->save();
            }
        }

        // Set pemain lain kalah
        $permainan->pemain()->where('id', '!=', $pemenang->id)->update(['status' => 'kalah']);

        // Selesaikan permainan
        $permainan->update([
            'status' => 'selesai',
            'selesai_pada' => now(),
            'pemenang_id' => $pemenang->user_id,
        ]);

        // Simpan hasil permainan
        $durasi = $permainan->dimulai_pada->diffInSeconds(now());
        $pemainList = $permainan->pemain()->orderByDesc('skor')->get();

        foreach ($pemainList as $index => $pemain) {
            HasilPermainan::create([
                'permainan_id' => $permainan->id,
                'pemain_permainan_id' => $pemain->id,
                'user_id' => $pemain->user_id,
                'skor_akhir' => $pemain->skor,
                'jumlah_benar' => $pemain->jumlah_benar,
                'jumlah_salah' => $pemain->jumlah_salah,
                'durasi_detik' => $durasi,
                'peringkat' => $index + 1,
                'status' => $pemain->status,
            ]);

            // Update leaderboard
            if ($pemain->user_id) {
                $this->updateLeaderboard($pemain, $permainan);
            }
        }
    }

    /**
     * Update leaderboard
     */
    private function updateLeaderboard(PemainPermainan $pemain, Permainan $permainan): void
    {
        $leaderboard = Leaderboard::firstOrCreate(
            [
                'user_id' => $pemain->user_id,
                'kelas_id' => $permainan->kelas_id,
                'mata_pelajaran_id' => $permainan->mata_pelajaran_id,
            ],
            [
                'total_skor' => 0,
                'total_menang' => 0,
                'total_permainan' => 0,
                'rata_rata_skor' => 0,
            ]
        );

        $leaderboard->total_skor += $pemain->skor;
        $leaderboard->total_permainan++;
        if ($pemain->status === 'menang') {
            $leaderboard->total_menang++;
        }
        $leaderboard->rata_rata_skor = $leaderboard->total_permainan > 0
            ? $leaderboard->total_skor / $leaderboard->total_permainan
            : 0;
        $leaderboard->save();
    }
}
