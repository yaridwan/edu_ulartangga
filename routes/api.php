<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GameApiController;

// Game API menggunakan web middleware (session auth) agar kompatibel dengan login biasa
Route::middleware('web')->prefix('game')->group(function () {
    Route::post('/{permainan}/lempar-dadu', [GameApiController::class, 'lemparDadu']);
    Route::get('/{permainan}/soal', [GameApiController::class, 'ambilSoal']);
    Route::post('/{permainan}/jawab', [GameApiController::class, 'jawabSoal']);
    Route::get('/{permainan}/status', [GameApiController::class, 'status']);
    Route::post('/{permainan}/selesai', [GameApiController::class, 'selesai']);
});
