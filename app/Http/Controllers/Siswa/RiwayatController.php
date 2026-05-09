<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilPermainan;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = HasilPermainan::where('user_id', auth()->id())
            ->with(['permainan.mataPelajaran', 'permainan.kelas'])
            ->latest()
            ->paginate(15);

        return view('siswa.riwayat', compact('riwayat'));
    }
}
