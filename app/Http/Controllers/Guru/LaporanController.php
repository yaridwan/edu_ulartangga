<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\HasilPermainan;
use App\Models\Permainan;
use App\Models\JawabanPermainan;
use App\Models\Soal;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil permainan yang menggunakan soal dari guru ini
        $guruId = auth()->id();

        $query = Permainan::with(['mataPelajaran', 'kelas', 'pemain'])
            ->where('status', 'selesai')
            ->whereHas('jawaban.soal', fn($q) => $q->where('guru_id', $guruId));

        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $permainan = $query->latest()->paginate(15);
        $mapel = MataPelajaran::aktif()->get();
        $kelas = Kelas::aktif()->get();

        // Statistik umum
        $totalPermainan = Permainan::where('status', 'selesai')
            ->whereHas('jawaban.soal', fn($q) => $q->where('guru_id', $guruId))
            ->count();

        $totalJawaban = JawabanPermainan::whereHas('soal', fn($q) => $q->where('guru_id', $guruId))->count();
        $jawabanBenar = JawabanPermainan::whereHas('soal', fn($q) => $q->where('guru_id', $guruId))->where('is_benar', true)->count();

        $stats = [
            'total_permainan' => $totalPermainan,
            'total_jawaban' => $totalJawaban,
            'jawaban_benar' => $jawabanBenar,
            'persentase_benar' => $totalJawaban > 0 ? round(($jawabanBenar / $totalJawaban) * 100) : 0,
        ];

        return view('guru.laporan.index', compact('permainan', 'mapel', 'kelas', 'stats'));
    }

    public function show(Permainan $permainan)
    {
        $guruId = auth()->id();

        $permainan->load([
            'mataPelajaran',
            'kelas',
            'pemain' => fn($q) => $q->orderByDesc('skor'),
            'jawaban' => fn($q) => $q->whereHas('soal', fn($sq) => $sq->where('guru_id', $guruId)),
            'jawaban.soal',
            'jawaban.pemainPermainan',
        ]);

        // Soal yang paling sering salah
        $soalSalah = JawabanPermainan::where('permainan_id', $permainan->id)
            ->where('is_benar', false)
            ->whereHas('soal', fn($q) => $q->where('guru_id', $guruId))
            ->selectRaw('soal_id, COUNT(*) as total_salah')
            ->groupBy('soal_id')
            ->orderByDesc('total_salah')
            ->limit(5)
            ->with('soal')
            ->get();

        // Statistik per pemain
        $statistikPemain = [];
        foreach ($permainan->pemain as $pemain) {
            $jawabanPemain = $permainan->jawaban->where('pemain_permainan_id', $pemain->id);
            $statistikPemain[$pemain->id] = [
                'total' => $jawabanPemain->count(),
                'benar' => $jawabanPemain->where('is_benar', true)->count(),
                'salah' => $jawabanPemain->where('is_benar', false)->count(),
                'rata_waktu' => round($jawabanPemain->avg('waktu_jawab') ?? 0),
            ];
        }

        return view('guru.laporan.show', compact('permainan', 'soalSalah', 'statistikPemain'));
    }

    public function exportPdf(Permainan $permainan)
    {
        $guruId = auth()->id();

        $permainan->load([
            'mataPelajaran',
            'kelas',
            'pemain' => fn($q) => $q->orderByDesc('skor'),
            'jawaban' => fn($q) => $q->whereHas('soal', fn($sq) => $sq->where('guru_id', $guruId)),
            'jawaban.soal',
            'jawaban.pemainPermainan',
        ]);

        $statistikPemain = [];
        foreach ($permainan->pemain as $pemain) {
            $jawabanPemain = $permainan->jawaban->where('pemain_permainan_id', $pemain->id);
            $statistikPemain[$pemain->id] = [
                'total' => $jawabanPemain->count(),
                'benar' => $jawabanPemain->where('is_benar', true)->count(),
                'salah' => $jawabanPemain->where('is_benar', false)->count(),
                'rata_waktu' => round($jawabanPemain->avg('waktu_jawab') ?? 0),
            ];
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('guru.laporan.pdf', compact('permainan', 'statistikPemain'));
        
        return $pdf->download('Laporan_Permainan_'.$permainan->id.'.pdf');
    }
}
