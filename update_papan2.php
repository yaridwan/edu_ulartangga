<?php

$papan = App\Models\PapanPermainan::first();
if ($papan) {
    $papan->konfigurasi_tangga = [
        ['dari' => 5, 'ke' => 58],
        ['dari' => 14, 'ke' => 49],
        ['dari' => 53, 'ke' => 72],
        ['dari' => 64, 'ke' => 83],
    ];
    $papan->konfigurasi_ular = [
        ['dari' => 38, 'ke' => 20],
        ['dari' => 51, 'ke' => 10],
        ['dari' => 76, 'ke' => 54],
        ['dari' => 91, 'ke' => 73],
        ['dari' => 97, 'ke' => 61],
    ];
    // Add some random question cells scattered around
    $papan->kotak_soal = [6, 12, 18, 25, 31, 39, 45, 52, 60, 68, 74, 85, 90, 94];
    $papan->save();
    echo "Updated PapanPermainan for bg2.jpg";
} else {
    echo "PapanPermainan not found";
}
