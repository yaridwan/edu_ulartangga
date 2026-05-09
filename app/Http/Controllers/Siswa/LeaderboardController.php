<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Leaderboard;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Leaderboard::with(['user', 'kelas', 'mataPelajaran']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        $leaderboard = $query->orderByDesc('total_skor')->paginate(20);
        $kelas = Kelas::aktif()->get();
        $mapel = MataPelajaran::aktif()->get();

        return view('siswa.leaderboard', compact('leaderboard', 'kelas', 'mapel'));
    }
}
