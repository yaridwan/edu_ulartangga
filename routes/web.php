<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\MateriController;
use App\Http\Controllers\Guru\SoalController;
use App\Http\Controllers\Guru\PaketPermainanController;
use App\Http\Controllers\Guru\LaporanController as GuruLaporanController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\GameController;
use App\Http\Controllers\Siswa\LeaderboardController;
use App\Http\Controllers\Siswa\RiwayatController;
use App\Http\Controllers\Siswa\ProfileController;

// Public
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class);
    Route::resource('/kelas', KelasController::class);
    Route::resource('/mata-pelajaran', MataPelajaranController::class);
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

// Guru
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/materi', MateriController::class);
    Route::post('/soal/import', [SoalController::class, 'import'])->name('soal.import');
    Route::resource('/soal', SoalController::class);
    Route::resource('/paket-permainan', PaketPermainanController::class);
    Route::get('/laporan', [GuruLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{permainan}', [GuruLaporanController::class, 'show'])->name('laporan.show');
    Route::get('/laporan/{permainan}/pdf', [GuruLaporanController::class, 'exportPdf'])->name('laporan.pdf');
});

// Siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/game', [GameController::class, 'index'])->name('game.index');
    Route::post('/game/mulai', [GameController::class, 'mulai'])->name('game.mulai');
    Route::post('/game/mulai-paket/{paketPermainan}', [GameController::class, 'mulaiDariPaket'])->name('game.mulaiPaket');
    Route::get('/game/{permainan}', [GameController::class, 'main'])->name('game.main');
    Route::get('/hasil/{permainan}', [GameController::class, 'hasil'])->name('game.hasil');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profil/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
});
