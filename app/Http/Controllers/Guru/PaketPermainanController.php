<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\PaketPermainan;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\Soal;
use Illuminate\Http\Request;

class PaketPermainanController extends Controller
{
    public function index()
    {
        $paket = PaketPermainan::byGuru(auth()->id())
            ->with(['mataPelajaran', 'kelas'])
            ->withCount('permainan')
            ->latest()
            ->paginate(15);

        return view('guru.paket-permainan.index', compact('paket'));
    }

    public function create()
    {
        $mapel = MataPelajaran::aktif()->get();
        $kelas = Kelas::aktif()->get();
        return view('guru.paket-permainan.create', compact('mapel', 'kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mode' => 'required|in:solo,lokal,komputer',
            'maks_pemain' => 'required|integer|min:1|max:4',
            'jumlah_soal' => 'required|integer|min:1|max:100',
            'poin_benar' => 'required|integer|min:1',
            'poin_salah' => 'required|integer|max:0',
            'bonus_langkah' => 'required|integer|min:0|max:10',
            'penalti_langkah' => 'required|integer|min:0|max:10',
            'tampilkan_pembahasan' => 'boolean',
            'acak_soal' => 'boolean',
            'waktu_jawab' => 'nullable|integer|min:5|max:300',
        ]);

        $validated['guru_id'] = auth()->id();
        $validated['tampilkan_pembahasan'] = $request->boolean('tampilkan_pembahasan');
        $validated['acak_soal'] = $request->boolean('acak_soal');

        PaketPermainan::create($validated);

        return redirect()->route('guru.paket-permainan.index')
            ->with('success', 'Paket permainan berhasil dibuat.');
    }

    public function show(PaketPermainan $paketPermainan)
    {
        if ($paketPermainan->guru_id !== auth()->id()) {
            abort(403);
        }

        $paketPermainan->load(['mataPelajaran', 'kelas', 'permainan.pemain']);

        $soalTersedia = Soal::where('mata_pelajaran_id', $paketPermainan->mata_pelajaran_id)
            ->where('kelas_id', $paketPermainan->kelas_id)
            ->where('status', 'aktif')
            ->count();

        $statistik = [
            'total_sesi' => $paketPermainan->permainan->count(),
            'sesi_selesai' => $paketPermainan->permainan->where('status', 'selesai')->count(),
            'soal_tersedia' => $soalTersedia,
        ];

        return view('guru.paket-permainan.show', compact('paketPermainan', 'statistik'));
    }

    public function edit(PaketPermainan $paketPermainan)
    {
        if ($paketPermainan->guru_id !== auth()->id()) {
            abort(403);
        }

        $mapel = MataPelajaran::aktif()->get();
        $kelas = Kelas::aktif()->get();

        return view('guru.paket-permainan.edit', compact('paketPermainan', 'mapel', 'kelas'));
    }

    public function update(Request $request, PaketPermainan $paketPermainan)
    {
        if ($paketPermainan->guru_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mode' => 'required|in:solo,lokal,komputer',
            'maks_pemain' => 'required|integer|min:1|max:4',
            'jumlah_soal' => 'required|integer|min:1|max:100',
            'poin_benar' => 'required|integer|min:1',
            'poin_salah' => 'required|integer|max:0',
            'bonus_langkah' => 'required|integer|min:0|max:10',
            'penalti_langkah' => 'required|integer|min:0|max:10',
            'tampilkan_pembahasan' => 'boolean',
            'acak_soal' => 'boolean',
            'waktu_jawab' => 'nullable|integer|min:5|max:300',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $validated['tampilkan_pembahasan'] = $request->boolean('tampilkan_pembahasan');
        $validated['acak_soal'] = $request->boolean('acak_soal');

        $paketPermainan->update($validated);

        return redirect()->route('guru.paket-permainan.index')
            ->with('success', 'Paket permainan berhasil diperbarui.');
    }

    public function destroy(PaketPermainan $paketPermainan)
    {
        if ($paketPermainan->guru_id !== auth()->id()) {
            abort(403);
        }

        if ($paketPermainan->permainan()->where('status', 'berjalan')->exists()) {
            return back()->with('error', 'Tidak bisa menghapus paket yang masih memiliki permainan aktif.');
        }

        $paketPermainan->delete();

        return redirect()->route('guru.paket-permainan.index')
            ->with('success', 'Paket permainan berhasil dihapus.');
    }
}
