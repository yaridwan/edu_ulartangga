<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function index()
    {
        $materi = Materi::with(['mataPelajaran', 'kelas'])->latest()->paginate(15);
        return view('guru.materi.index', compact('materi'));
    }

    public function create()
    {
        $mapel = MataPelajaran::aktif()->get();
        $kelas = Kelas::aktif()->get();
        return view('guru.materi.create', compact('mapel', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Materi::create($request->only(['mata_pelajaran_id', 'kelas_id', 'judul', 'deskripsi', 'status']));
        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Materi $materi)
    {
        $mapel = MataPelajaran::aktif()->get();
        $kelas = Kelas::aktif()->get();
        return view('guru.materi.edit', compact('materi', 'mapel', 'kelas'));
    }

    public function update(Request $request, Materi $materi)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $materi->update($request->only(['mata_pelajaran_id', 'kelas_id', 'judul', 'deskripsi', 'status']));
        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        $materi->delete();
        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil dihapus.');
    }
}
