<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Soal;
use App\Models\Permainan;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pengguna' => User::count(),
            'total_guru' => User::where('role', 'guru')->count(),
            'total_siswa' => User::where('role', 'siswa')->count(),
            'total_soal' => Soal::count(),
            'total_permainan' => Permainan::count(),
            'total_mapel' => MataPelajaran::count(),
        ];

        $permainanTerbaru = Permainan::with(['mataPelajaran', 'creator'])
            ->latest()
            ->take(5)
            ->get();

        $siswaAktif = User::where('role', 'siswa')
            ->where('status', 'aktif')
            ->withCount('hasilPermainan')
            ->orderByDesc('hasil_permainan_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'permainanTerbaru', 'siswaAktif'));
    }
}
