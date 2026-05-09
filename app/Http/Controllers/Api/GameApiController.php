<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permainan;
use App\Models\PemainPermainan;
use App\Models\Soal;
use App\Services\GameService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GameApiController extends Controller
{
    protected GameService $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * Lempar dadu
     */
    public function lemparDadu(Request $request, Permainan $permainan): JsonResponse
    {
        if (!$permainan->isBerjalan()) {
            return response()->json(['error' => 'Permainan sudah selesai.'], 400);
        }

        $pemainId = $request->input('pemain_id');
        $pemain = PemainPermainan::findOrFail($pemainId);

        $angkaDadu = $this->gameService->lemparDadu();
        $posisiBaru = $this->gameService->hitungPosisiBaru($pemain->posisi, $angkaDadu, $permainan->jumlah_kotak);

        // Cek ular/tangga
        $papan = $permainan->papanPermainan;
        $eventData = $this->gameService->cekUlarTangga($papan, $posisiBaru);
        $posisiAkhir = $eventData['posisi_akhir'];

        // Proses poin event (ular/tangga)
        if ($eventData['event']) {
            $this->gameService->prosesEventPoin($pemain, $eventData['event']);
        }

        // Update posisi dan giliran
        $pemain->posisi = $posisiAkhir;
        $pemain->jumlah_giliran++;
        $pemain->save();

        // Cek apakah ada soal di kotak ini
        $adaSoal = $papan->isKotakSoal($posisiAkhir);

        // Cek apakah menang
        $menang = $this->gameService->cekMenang($pemain, $permainan->jumlah_kotak);

        if ($menang) {
            $this->gameService->selesaikanPermainan($permainan, $pemain);
        }

        return response()->json([
            'angka_dadu' => $angkaDadu,
            'posisi_sebelum' => $pemain->posisi - $angkaDadu, // approximate
            'posisi_setelah_dadu' => $posisiBaru,
            'posisi_akhir' => $posisiAkhir,
            'event' => $eventData['event'],
            'event_dari' => $eventData['dari'],
            'event_ke' => $eventData['ke'],
            'ada_soal' => $adaSoal && !$menang,
            'menang' => $menang,
            'skor' => $pemain->skor,
            'jumlah_giliran' => $pemain->jumlah_giliran,
        ]);
    }

    /**
     * Ambil soal untuk dijawab
     */
    public function ambilSoal(Permainan $permainan): JsonResponse
    {
        $soal = $this->gameService->ambilSoal($permainan);

        if (!$soal) {
            return response()->json(['error' => 'Tidak ada soal tersedia.'], 404);
        }

        return response()->json([
            'id' => $soal->id,
            'pertanyaan' => $soal->pertanyaan,
            'jenis_soal' => $soal->jenis_soal,
            'tingkat_kesulitan' => $soal->tingkat_kesulitan,
            'poin' => $soal->poin,
            'pilihan' => $soal->pilihanJawaban->map(fn($p) => [
                'label' => $p->label,
                'isi_pilihan' => $p->isi_pilihan,
            ]),
        ]);
    }

    /**
     * Jawab soal
     */
    public function jawabSoal(Request $request, Permainan $permainan): JsonResponse
    {
        $request->validate([
            'pemain_id' => 'required|exists:pemain_permainan,id',
            'soal_id' => 'required|exists:soal,id',
            'jawaban' => 'required|string',
            'waktu_jawab' => 'nullable|integer',
        ]);

        $pemain = PemainPermainan::findOrFail($request->pemain_id);
        $soal = Soal::findOrFail($request->soal_id);

        $hasil = $this->gameService->prosesJawaban(
            $permainan,
            $pemain,
            $soal,
            $request->jawaban,
            $request->waktu_jawab
        );

        // Terapkan bonus/penalti langkah jika ada
        if (isset($hasil['langkah_tambahan']) && $hasil['langkah_tambahan'] != 0) {
            $posisiBaru = $this->gameService->hitungPosisiBaru($pemain->posisi, $hasil['langkah_tambahan'], $permainan->jumlah_kotak);
            
            // Cek ular/tangga di posisi baru (opsional, tapi disarankan)
            $papan = $permainan->papanPermainan;
            $eventData = $this->gameService->cekUlarTangga($papan, $posisiBaru);
            $posisiAkhir = $eventData['posisi_akhir'];
            
            if ($eventData['event']) {
                $this->gameService->prosesEventPoin($pemain, $eventData['event']);
            }
            
            $pemain->posisi = $posisiAkhir;
            $pemain->save();
            
            $hasil['posisi_setelah_tambahan'] = $posisiAkhir;
            $hasil['event_tambahan'] = $eventData['event'];
            
            // Cek menang dari bonus langkah
            $menang = $this->gameService->cekMenang($pemain, $permainan->jumlah_kotak);
            if ($menang) {
                $this->gameService->selesaikanPermainan($permainan, $pemain);
                $hasil['menang'] = true;
            }
        }

        return response()->json($hasil);
    }

    /**
     * Status permainan
     */
    public function status(Permainan $permainan): JsonResponse
    {
        $permainan->load(['pemain', 'mataPelajaran', 'kelas']);

        return response()->json([
            'id' => $permainan->id,
            'status' => $permainan->status,
            'mode' => $permainan->mode,
            'pemain' => $permainan->pemain->map(fn($p) => [
                'id' => $p->id,
                'nama' => $p->nama_pemain,
                'tipe' => $p->tipe_pemain,
                'warna' => $p->warna_pion,
                'posisi' => $p->posisi,
                'skor' => $p->skor,
                'jumlah_benar' => $p->jumlah_benar,
                'jumlah_salah' => $p->jumlah_salah,
                'jumlah_giliran' => $p->jumlah_giliran,
                'status' => $p->status,
            ]),
        ]);
    }

    /**
     * Selesaikan permainan secara manual (keluar)
     */
    public function selesai(Request $request, Permainan $permainan): JsonResponse
    {
        if ($permainan->status !== 'berjalan') {
            return response()->json(['error' => 'Permainan sudah selesai.'], 400);
        }

        $permainan->update([
            'status' => 'batal',
            'selesai_pada' => now(),
        ]);

        return response()->json(['message' => 'Permainan dibatalkan.']);
    }
}
