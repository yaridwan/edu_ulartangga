<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::withCount('soal')->latest()->paginate(15);
        return view('admin.mata-pelajaran.index', compact('mapel'));
    }

    public function create()
    {
        return view('admin.mata-pelajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        MataPelajaran::create($request->only(['nama', 'kode', 'deskripsi', 'warna', 'status']));
        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        return view('admin.mata-pelajaran.edit', compact('mataPelajaran'));
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $mataPelajaran->update($request->only(['nama', 'kode', 'deskripsi', 'warna', 'status']));
        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        if ($mataPelajaran->soal()->count() > 0) {
            return back()->with('error', 'Mata pelajaran ini masih memiliki soal.');
        }

        $mataPelajaran->delete();
        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
