<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilPermainan;
use App\Models\Leaderboard;
use App\Models\Permainan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_permainan' => HasilPermainan::where('user_id', $user->id)->count(),
            'total_menang' => HasilPermainan::where('user_id', $user->id)->where('status', 'menang')->count(),
            'skor_terakhir' => HasilPermainan::where('user_id', $user->id)->latest()->value('skor_akhir') ?? 0,
        ];

        $riwayat = HasilPermainan::where('user_id', $user->id)
            ->with(['permainan.mataPelajaran'])
            ->latest()
            ->take(5)
            ->get();

        $ranking = null;
        if ($user->kelas_id) {
            $ranking = Leaderboard::where('user_id', $user->id)->first();
        }

        return view('siswa.dashboard', compact('stats', 'riwayat', 'ranking'));
    }
}
