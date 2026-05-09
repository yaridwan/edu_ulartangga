<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilPermainan;
use App\Models\Permainan;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = HasilPermainan::with(['permainan.mataPelajaran', 'permainan.kelas', 'user', 'pemainPermainan']);

        if ($request->filled('mata_pelajaran_id')) {
            $query->whereHas('permainan', fn($q) => $q->where('mata_pelajaran_id', $request->mata_pelajaran_id));
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('permainan', fn($q) => $q->where('kelas_id', $request->kelas_id));
        }

        $hasil = $query->latest()->paginate(20);

        return view('admin.laporan.index', compact('hasil'));
    }
}
