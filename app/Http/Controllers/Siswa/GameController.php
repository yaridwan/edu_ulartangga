<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\PapanPermainan;
use App\Models\PaketPermainan;
use App\Models\Permainan;
use App\Models\PemainPermainan;
use App\Models\HasilPermainan;
use App\Services\GameService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::aktif()->get();
        $kelas = Kelas::aktif()->get();
        $materi = \App\Models\Materi::where('status', 'aktif')->get();

        // Ambil paket permainan yang aktif
        $paketPermainan = PaketPermainan::aktif()
            ->with(['mataPelajaran', 'kelas', 'guru'])
            ->latest()
            ->get();

        return view('siswa.game.index', compact('mapel', 'kelas', 'materi', 'paketPermainan'));
    }

    /**
     * Mulai permainan dari form manual (mode lama)
     */
    public function mulai(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:solo,lokal,komputer',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'materi_id' => 'nullable|exists:materi,id',
            'jumlah_pemain' => 'required|integer|min:1|max:4',
        ]);

        $papan = PapanPermainan::aktif()->first();
        if (!$papan) {
            return back()->with('error', 'Papan permainan belum tersedia.');
        }

        $permainan = Permainan::create([
            'mode' => $request->mode,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'kelas_id' => $request->kelas_id,
            'materi_id' => $request->materi_id,
            'papan_permainan_id' => $papan->id,
            'jumlah_pemain' => $request->jumlah_pemain,
            'jumlah_kotak' => $papan->jumlah_kotak,
            'status' => 'berjalan',
            'dimulai_pada' => now(),
            'created_by' => auth()->id(),
        ]);

        $this->buatPemain($permainan, $request->mode, $request->jumlah_pemain, $request);

        return redirect()->route('siswa.game.main', $permainan);
    }

    /**
     * Mulai permainan dari paket permainan guru
     */
    public function mulaiDariPaket(PaketPermainan $paketPermainan)
    {
        if ($paketPermainan->status !== 'aktif') {
            return back()->with('error', 'Paket permainan tidak aktif.');
        }

        $papan = PapanPermainan::aktif()->first();
        if (!$papan) {
            return back()->with('error', 'Papan permainan belum tersedia.');
        }

        $permainan = Permainan::create([
            'paket_permainan_id' => $paketPermainan->id,
            'mode' => $paketPermainan->mode,
            'mata_pelajaran_id' => $paketPermainan->mata_pelajaran_id,
            'kelas_id' => $paketPermainan->kelas_id,
            'papan_permainan_id' => $papan->id,
            'jumlah_pemain' => $paketPermainan->mode === 'solo' ? 1 : $paketPermainan->maks_pemain,
            'jumlah_kotak' => $papan->jumlah_kotak,
            'status' => 'berjalan',
            'dimulai_pada' => now(),
            'created_by' => auth()->id(),
        ]);

        $jumlahPemain = $paketPermainan->mode === 'solo' ? 1 : $paketPermainan->maks_pemain;
        $this->buatPemain($permainan, $paketPermainan->mode, $jumlahPemain);

        return redirect()->route('siswa.game.main', $permainan);
    }

    /**
     * Helper: buat pemain untuk permainan
     */
    private function buatPemain(Permainan $permainan, string $mode, int $jumlahPemain, ?Request $request = null): void
    {
        $warnaPion = ['#3B82F6', '#EF4444', '#10B981', '#F59E0B'];

        // Pemain utama (siswa yang login)
        PemainPermainan::create([
            'permainan_id' => $permainan->id,
            'user_id' => auth()->id(),
            'nama_pemain' => auth()->user()->name,
            'tipe_pemain' => 'siswa',
            'warna_pion' => $warnaPion[0],
        ]);

        // Pemain tambahan
        for ($i = 1; $i < $jumlahPemain; $i++) {
            if ($mode === 'komputer') {
                PemainPermainan::create([
                    'permainan_id' => $permainan->id,
                    'nama_pemain' => 'Komputer ' . $i,
                    'tipe_pemain' => 'komputer',
                    'warna_pion' => $warnaPion[$i],
                ]);
            } else {
                $namaPemain = $request?->input("nama_pemain_{$i}", "Pemain " . ($i + 1)) ?? "Pemain " . ($i + 1);
                PemainPermainan::create([
                    'permainan_id' => $permainan->id,
                    'nama_pemain' => $namaPemain,
                    'tipe_pemain' => 'lokal',
                    'warna_pion' => $warnaPion[$i],
                ]);
            }
        }
    }

    public function main(Permainan $permainan)
    {
        $permainan->load(['pemain', 'mataPelajaran', 'kelas', 'papanPermainan', 'paketPermainan']);

        if ($permainan->status !== 'berjalan') {
            return redirect()->route('siswa.game.hasil', $permainan);
        }

        return view('siswa.game.play', compact('permainan'));
    }

    public function hasil(Permainan $permainan)
    {
        $permainan->load(['pemain', 'mataPelajaran', 'kelas', 'hasil.user']);

        $hasil = $permainan->hasil()->orderBy('peringkat')->get();

        return view('siswa.game.result', compact('permainan', 'hasil'));
    }
}
