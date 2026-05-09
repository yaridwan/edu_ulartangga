<?php

$papan = App\Models\PapanPermainan::first();
if ($papan) {
    $papan->konfigurasi_tangga = [
        ['dari' => 1, 'ke' => 38],
        ['dari' => 4, 'ke' => 14],
        ['dari' => 8, 'ke' => 30],
        ['dari' => 21, 'ke' => 42],
        ['dari' => 28, 'ke' => 76],
        ['dari' => 50, 'ke' => 67],
        ['dari' => 71, 'ke' => 92],
        ['dari' => 80, 'ke' => 99]
    ];
    $papan->konfigurasi_ular = [
        ['dari' => 32, 'ke' => 10],
        ['dari' => 36, 'ke' => 6],
        ['dari' => 48, 'ke' => 26],
        ['dari' => 62, 'ke' => 18],
        ['dari' => 88, 'ke' => 24],
        ['dari' => 95, 'ke' => 56],
        ['dari' => 97, 'ke' => 78]
    ];
    // Add some random question cells
    $papan->kotak_soal = [5, 12, 17, 23, 29, 35, 41, 46, 53, 59, 65, 74, 82, 89, 94];
    $papan->save();
    echo "Updated PapanPermainan";
} else {
    echo "PapanPermainan not found";
}
