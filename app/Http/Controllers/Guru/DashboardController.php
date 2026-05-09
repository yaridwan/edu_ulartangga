<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_soal' => Soal::where('guru_id', $user->id)->count(),
            'soal_aktif' => Soal::where('guru_id', $user->id)->where('status', 'aktif')->count(),
            'total_mapel' => MataPelajaran::aktif()->count(),
        ];

        $soalTerbaru = Soal::where('guru_id', $user->id)
            ->with(['mataPelajaran', 'kelas'])
            ->latest()
            ->take(5)
            ->get();

        return view('guru.dashboard', compact('stats', 'soalTerbaru'));
    }
}
