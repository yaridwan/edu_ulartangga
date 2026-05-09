<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use App\Models\PilihanJawaban;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\Materi;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    public function index(Request $request)
    {
        $query = Soal::where('guru_id', auth()->id())->with(['mataPelajaran', 'kelas', 'materi']);

        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('tingkat_kesulitan')) {
            $query->where('tingkat_kesulitan', $request->tingkat_kesulitan);
        }

        $soal = $query->latest()->paginate(15);
        $mapel = MataPelajaran::aktif()->get();
        $kelas = Kelas::aktif()->get();

        return view('guru.soal.index', compact('soal', 'mapel', 'kelas'));
    }

    public function create()
    {
        $mapel = MataPelajaran::aktif()->get();
        $kelas = Kelas::aktif()->get();
        $materi = Materi::aktif()->get();
        return view('guru.soal.create', compact('mapel', 'kelas', 'materi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'materi_id' => 'nullable|exists:materi,id',
            'jenis_soal' => 'required|in:pilihan_ganda,benar_salah,isian',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit',
            'pertanyaan' => 'required|string',
            'kunci_jawaban' => 'required|string',
            'pembahasan' => 'nullable|string',
            'poin' => 'required|integer|min:1',
            'pilihan' => 'required_if:jenis_soal,pilihan_ganda|array',
            'pilihan.*.label' => 'required_with:pilihan|string',
            'pilihan.*.isi_pilihan' => 'required_with:pilihan|string',
        ]);

        $soal = Soal::create([
            'guru_id' => auth()->id(),
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'kelas_id' => $request->kelas_id,
            'materi_id' => $request->materi_id,
            'jenis_soal' => $request->jenis_soal,
            'tingkat_kesulitan' => $request->tingkat_kesulitan,
            'pertanyaan' => $request->pertanyaan,
            'kunci_jawaban' => $request->kunci_jawaban,
            'pembahasan' => $request->pembahasan,
            'poin' => $request->poin,
            'status' => 'aktif',
        ]);

        if ($request->jenis_soal === 'pilihan_ganda' && $request->has('pilihan')) {
            foreach ($request->pilihan as $pilihan) {
                PilihanJawaban::create([
                    'soal_id' => $soal->id,
                    'label' => $pilihan['label'],
                    'isi_pilihan' => $pilihan['isi_pilihan'],
                    'is_benar' => $pilihan['label'] === $request->kunci_jawaban,
                ]);
            }
        }

        return redirect()->route('guru.soal.index')->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit(Soal $soal)
    {
        if ($soal->guru_id !== auth()->id()) {
            abort(403);
        }

        $soal->load('pilihanJawaban');
        $mapel = MataPelajaran::aktif()->get();
        $kelas = Kelas::aktif()->get();
        $materi = Materi::aktif()->get();

        return view('guru.soal.edit', compact('soal', 'mapel', 'kelas', 'materi'));
    }

    public function update(Request $request, Soal $soal)
    {
        if ($soal->guru_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'materi_id' => 'nullable|exists:materi,id',
            'jenis_soal' => 'required|in:pilihan_ganda,benar_salah,isian',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit',
            'pertanyaan' => 'required|string',
            'kunci_jawaban' => 'required|string',
            'pembahasan' => 'nullable|string',
            'poin' => 'required|integer|min:1',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $soal->update($request->only([
            'mata_pelajaran_id', 'kelas_id', 'materi_id', 'jenis_soal',
            'tingkat_kesulitan', 'pertanyaan', 'kunci_jawaban', 'pembahasan', 'poin', 'status',
        ]));

        if ($request->jenis_soal === 'pilihan_ganda' && $request->has('pilihan')) {
            $soal->pilihanJawaban()->delete();
            foreach ($request->pilihan as $pilihan) {
                PilihanJawaban::create([
                    'soal_id' => $soal->id,
                    'label' => $pilihan['label'],
                    'isi_pilihan' => $pilihan['isi_pilihan'],
                    'is_benar' => $pilihan['label'] === $request->kunci_jawaban,
                ]);
            }
        }

        return redirect()->route('guru.soal.index')->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Soal $soal)
    {
        if ($soal->guru_id !== auth()->id()) {
            abort(403);
        }

        $soal->delete();
        return redirect()->route('guru.soal.index')->with('success', 'Soal berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(
                new \App\Imports\SoalImport($request->mata_pelajaran_id, $request->kelas_id),
                $request->file('file_excel')
            );

            return redirect()->back()->with('success', 'Data soal berhasil diimpor!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }
}
