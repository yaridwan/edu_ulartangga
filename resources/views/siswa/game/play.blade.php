@extends('layouts.guest')
@section('title', 'Bermain — Edu Ular Tangga')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-purple-50" id="game-app">
    {{-- Decorative Background Blobs --}}
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob"></div>
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-32 left-1/2 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob animation-delay-4000"></div>

    {{-- Content Wrapper to stay above blobs --}}
    <div class="relative z-10">
        {{-- Header --}}
        <header class="bg-white/70 backdrop-blur-md border-b border-white/50 px-4 py-3 shadow-[0_4px_30px_rgba(0,0,0,0.05)]">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-xl">🎲</span>
                    <span class="font-bold text-primary-800 drop-shadow-sm">Edu Ular Tangga</span>
                    <span class="text-sm text-gray-400">|</span>
                    <span class="text-sm font-semibold text-gray-600">{{ $permainan->mataPelajaran->nama }}</span>
                    <span class="text-sm text-gray-400">•</span>
                    <span class="text-sm text-gray-500">{{ $permainan->kelas->nama_kelas }}</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 bg-white/80 px-3 py-1.5 rounded-xl border border-primary-100 shadow-sm backdrop-blur">
                        <span class="text-lg">⏱️</span>
                        <span id="timer" class="text-base font-mono font-bold text-primary-700 tracking-wider">00:00</span>
                    </div>
                    <button type="button" onclick="document.getElementById('exit-modal').classList.remove('hidden')" class="flex items-center gap-2 text-sm text-white bg-red-500 hover:bg-red-600 px-5 py-2.5 rounded-xl font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 border border-red-600 relative z-50 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </div>
            </div>
        </header>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Board + Dice --}}
            <div class="lg:col-span-2 space-y-4">
                {{-- Legend --}}
                <div class="flex flex-wrap gap-3 text-xs font-semibold bg-white/80 backdrop-blur p-3 rounded-xl border border-white/50 shadow-sm inline-flex">
                    <span class="flex items-center gap-1"><span class="inline-block w-4 h-4 rounded bg-gradient-to-br from-red-200 to-red-300 border border-red-400"></span> Ular 🐍</span>
                    <span class="flex items-center gap-1"><span class="inline-block w-4 h-4 rounded bg-gradient-to-br from-green-200 to-green-300 border border-green-400"></span> Tangga 🪜</span>
                    <span class="flex items-center gap-1"><span class="inline-block w-4 h-4 rounded bg-gradient-to-br from-yellow-200 to-yellow-300 border border-yellow-400"></span> Soal ❓</span>
                    <span class="flex items-center gap-1"><span class="inline-block w-4 h-4 rounded bg-gradient-to-br from-purple-300 to-purple-400 border border-purple-500"></span> Finish 🏁</span>
                </div>

                {{-- Board --}}
                <div class="bg-[#8b4513] rounded-2xl shadow-xl p-3 sm:p-4 border-[6px] border-[#5c2e0b] relative">
                    <div class="game-board rounded-lg shadow-inner" id="game-board" style="background-image: url('{{ asset("images/bg2.jpg") }}');"></div>
                </div>

                {{-- Dice Area --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                    <div class="dice-wrapper">
                        <div class="dice-box" id="dice-box" onclick="rollDice()"></div>
                        <div class="dice-value-label" id="dice-value">-</div>
                        <button id="roll-btn" onclick="rollDice()" class="bg-gradient-to-r from-accent-500 to-accent-600 text-white font-bold px-8 py-3 rounded-xl hover:shadow-lg transition-all text-lg disabled:opacity-50 disabled:cursor-not-allowed">
                            🎲 Lempar Dadu
                        </button>
                    </div>
                    <p id="dice-info" class="text-center text-sm text-gray-400 mt-1">Klik dadu atau tombol untuk melempar</p>
                </div>
            </div>

            {{-- Side Panel --}}
            <div class="space-y-4">
                {{-- Current Turn --}}
                <div class="bg-[#8b4513] rounded-2xl p-4 text-white text-center border-4 border-[#5c2e0b]" id="turn-banner">
                    <p class="text-sm font-medium opacity-80">Giliran</p>
                    <p class="text-xl font-extrabold drop-shadow-md" id="turn-name">-</p>
                </div>

                {{-- Players --}}
                <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm border border-gray-100 p-4">
                    <h3 class="font-bold text-gray-900 mb-3">👥 Pemain</h3>
                    <div id="player-list" class="space-y-2"></div>
                </div>

                {{-- Activity Log --}}
                <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm border border-gray-100 p-4">
                    <h3 class="font-bold text-gray-900 mb-3">📋 Aktivitas</h3>
                    <div id="activity-log" class="space-y-1.5 max-h-52 overflow-y-auto text-sm"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Question Modal --}}
    <div id="question-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden">
        <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-lg w-full mx-4 animate-bounce-in">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-lg text-gray-900">❓ Pertanyaan</h3>
                <div class="flex items-center gap-2">
                    <span id="q-type-badge" class="px-2.5 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-600"></span>
                    <span id="q-difficulty" class="px-2.5 py-1 text-xs font-bold rounded-full"></span>
                </div>
            </div>
            <p id="q-text" class="text-gray-800 mb-5 leading-relaxed text-[15px]"></p>

            {{-- Pilihan Ganda options --}}
            <div id="q-options-pg" class="space-y-2 mb-4 hidden"></div>

            {{-- Benar/Salah options --}}
            <div id="q-options-bs" class="grid grid-cols-2 gap-3 mb-4 hidden">
                <button type="button" id="btn-benar" class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all hover:border-green-400 hover:bg-green-50 group">
                    <div class="text-3xl mb-1">✅</div>
                    <p class="font-bold text-sm text-gray-700 group-hover:text-green-700">Benar</p>
                </button>
                <button type="button" id="btn-salah" class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all hover:border-red-400 hover:bg-red-50 group">
                    <div class="text-3xl mb-1">❌</div>
                    <p class="font-bold text-sm text-gray-700 group-hover:text-red-700">Salah</p>
                </button>
            </div>

            {{-- Isian input --}}
            <div id="q-options-isian" class="mb-4 hidden">
                <label class="block text-sm font-semibold text-gray-600 mb-2">Tulis jawabanmu:</label>
                <input type="text" id="q-isian-input" placeholder="Ketik jawaban di sini..." class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" autocomplete="off">
                <button type="button" id="btn-submit-isian" class="mt-3 w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold py-3 rounded-xl hover:shadow-lg hover:shadow-primary-500/25 transition-all text-sm">
                    ✅ Kirim Jawaban
                </button>
            </div>

            <div id="q-timer-bar" class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                <div id="q-timer-fill" class="h-full bg-primary-500 rounded-full transition-all duration-1000" style="width:100%"></div>
            </div>
        </div>
    </div>

    {{-- Result Modal --}}
    <div id="result-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden" data-langkah-tambahan="0" data-posisi-setelah="0" data-event-tambahan="" data-menang="0">
        <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-md w-full mx-4 animate-bounce-in text-center">
            <div id="result-icon" class="text-6xl mb-3"></div>
            <h3 id="result-title" class="text-2xl font-extrabold mb-2"></h3>
            <p id="result-text" class="text-gray-600 mb-2"></p>
            <p id="result-explanation" class="text-sm text-gray-500 bg-gray-50 rounded-xl p-3 mb-4 text-left"></p>
            <button onclick="closeResultModal()" class="bg-primary-500 text-white font-bold px-6 py-3 rounded-xl hover:bg-primary-600 transition-colors">
                Lanjutkan
            </button>
        </div>
    </div>

    {{-- Win Modal --}}
    <div id="win-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 animate-bounce-in text-center">
            <div class="text-7xl mb-4">🏆</div>
            <h2 class="text-3xl font-black text-gray-900 mb-2">Permainan Selesai!</h2>
            <p id="win-text" class="text-gray-600 mb-6"></p>
            <div class="flex gap-3 justify-center">
                <a href="{{ route('siswa.game.hasil', $permainan) }}" class="bg-primary-500 text-white font-bold px-6 py-3 rounded-xl hover:bg-primary-600">Lihat Hasil</a>
                <a href="{{ route('siswa.game.index') }}" class="bg-gray-100 text-gray-700 font-bold px-6 py-3 rounded-xl hover:bg-gray-200">Main Lagi</a>
            </div>
        </div>
    </div>
    {{-- Exit Modal --}}
    <div id="exit-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 animate-bounce-in text-center">
            <div class="text-6xl mb-4">⚠️</div>
            <h2 class="text-2xl font-black text-gray-900 mb-2">Yakin Ingin Keluar?</h2>
            <p class="text-gray-600 mb-6 text-sm">Permainan saat ini akan dibatalkan dan skor tidak akan disimpan.</p>
            <div class="flex gap-3 justify-center">
                <button type="button" onclick="document.getElementById('exit-modal').classList.add('hidden')" class="bg-gray-100 text-gray-700 font-bold px-6 py-3 rounded-xl hover:bg-gray-200 transition-colors flex-1 cursor-pointer">Batal</button>
                <button type="button" onclick="doExitGame()" class="bg-red-500 text-white font-bold px-6 py-3 rounded-xl hover:bg-red-600 transition-colors flex-1 cursor-pointer">Ya, Keluar</button>
            </div>
        </div>
    </div>

    {{-- End Content Wrapper --}}
</div>

@push('scripts')
<style>
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob {
    animation: blob 7s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
.animation-delay-4000 {
    animation-delay: 4s;
}

/* Fallback styles in case Vite caches app.css */
.pion {
    width: 35px !important;
    height: 35px !important;
    border-radius: 50% !important;
    border: 2px solid white !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.5) !important;
    position: absolute !important;
    z-index: 30 !important;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
    background-image: url('{{ asset("images/pieces.jpg") }}') !important;
    background-repeat: no-repeat !important;
    background-size: 136px 84px !important;
    pointer-events: none !important;
}
.pion-0 { background-position: 0px -49px !important; }
.pion-1 { background-position: -49px -49px !important; }
.pion-2 { background-position: -101px 0px !important; }
.pion-3 { background-position: -101px -49px !important; }
.pion-4 { background-position: 0px 0px !important; }
.pion.active-turn { box-shadow: 0px 0px 7px 4px goldenrod !important; }

.dice-box {
    width: 50px !important;
    height: 50px !important;
    background-image: url('{{ asset("images/dice.webp") }}') !important;
    background-size: 396px !important;
    background-position: 380px 110px; /* Removed !important to allow JS updates */
    /* Remove background-repeat: no-repeat to allow wrapping */
    border-radius: 5px !important;
    border: 1px solid black !important;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2) !important;
    cursor: pointer !important;
    transition: transform 0.15s ease !important;
}
</style>
<script>
const GAME_DATA = {
    permainanId: {{ $permainan->id }},
    jumlahKotak: {{ $permainan->jumlah_kotak }},
    pemain: @json($permainan->pemain),
    papan: @json($permainan->papanPermainan),
    csrfToken: '{{ csrf_token() }}',
};

let currentPlayerIndex = 0;
let isRolling = false;
let gameTimer = 0;

// ===== TIMER =====
const timerInterval = setInterval(() => {
    gameTimer++;
    const m = String(Math.floor(gameTimer / 60)).padStart(2, '0');
    const s = String(gameTimer % 60).padStart(2, '0');
    document.getElementById('timer').textContent = m + ':' + s;
}, 1000);

// ===== DICE DOT PATTERNS =====
const DICE_POSITIONS = {
    1: '380px 110px',
    2: '318px 110px',
    3: '256px 110px',
    4: '195px 110px',
    5: '133px 110px',
    6: '71px 110px'
};

function renderDice(value) {
    if (value >= 1 && value <= 6) {
        // Use setProperty with !important if needed, but since we removed !important from CSS, normal works
        document.getElementById('dice-box').style.setProperty('background-position', DICE_POSITIONS[value], 'important');
    }
    document.getElementById('dice-value').textContent = value >= 1 ? value : '-';
}

// ===== BUILD BOARD =====
function buildBoard() {
    const board = document.getElementById('game-board');
    board.innerHTML = '';

    const snakes = GAME_DATA.papan.konfigurasi_ular;
    const ladders = GAME_DATA.papan.konfigurasi_tangga;
    const snakeHeads = snakes.map(u => u.dari);
    const snakeTails = snakes.map(u => u.ke);
    const ladderBottoms = ladders.map(t => t.dari);
    const ladderTops = ladders.map(t => t.ke);
    const questionCells = GAME_DATA.papan.kotak_soal || [];

    // Build snake/ladder lookup for tooltips
    const snakeMap = {};
    snakes.forEach(s => { snakeMap[s.dari] = s.ke; });
    const ladderMap = {};
    ladders.forEach(l => { ladderMap[l.dari] = l.ke; });

    // Generate zig-zag cell order (bottom-left to top)
    const cells = [];
    for (let row = 9; row >= 0; row--) {
        if (row % 2 === 1) {
            for (let col = 9; col >= 0; col--) cells.push(row * 10 + col + 1);
        } else {
            for (let col = 0; col < 10; col++) cells.push(row * 10 + col + 1);
        }
    }

    cells.forEach(num => {
        const cell = document.createElement('div');
        cell.className = 'game-cell';
        cell.id = 'cell-' + num;

        let icon = '';
        let extraClass = '';
        let tooltip = '';

        if (num === GAME_DATA.jumlahKotak) {
            extraClass = 'finish-cell';
            icon = '🏁';
            tooltip = 'FINISH!';
        } else if (snakeHeads.includes(num)) {
            extraClass = 'snake-head';
            icon = '🐍';
            tooltip = 'Ular! Turun ke ' + snakeMap[num];
        } else if (snakeTails.includes(num)) {
            extraClass = 'snake-tail';
        } else if (ladderBottoms.includes(num)) {
            extraClass = 'ladder-bottom';
            icon = '🪜';
            tooltip = 'Tangga! Naik ke ' + ladderMap[num];
        } else if (ladderTops.includes(num)) {
            extraClass = 'ladder-top';
        } else if (questionCells.includes(num)) {
            extraClass = 'question-cell';
            icon = '❓';
            tooltip = 'Kotak soal';
        } else if (num % 2 === 0) {
            extraClass = 'even-cell';
        }

        cell.classList.add(extraClass || '_');
        if (tooltip) cell.title = tooltip;

        cell.innerHTML = `<span class="cell-number">${num}</span>${icon ? '<span class="cell-icon">' + icon + '</span>' : ''}`;
        board.appendChild(cell);
    });
}

// ===== RENDER PLAYERS =====
function renderPlayers() {
    const list = document.getElementById('player-list');
    list.innerHTML = '';

    GAME_DATA.pemain.forEach((p, i) => {
        const isActive = i === currentPlayerIndex;
        list.innerHTML += `
            <div class="flex items-center gap-3 p-2.5 rounded-xl transition-all ${isActive ? 'bg-primary-50 border-2 border-primary-300 shadow-sm' : 'border border-transparent'}">
                <div class="w-9 h-9 rounded-full shrink-0 shadow-md pion-${i % 5}" style="border: 3px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.25); background-image: url('{{ asset("images/pieces.jpg") }}'); background-repeat: no-repeat; background-size: 136px 84px;"></div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-sm truncate ${isActive ? 'text-primary-700' : 'text-gray-700'}">${p.nama_pemain}</p>
                    <p class="text-xs text-gray-400">Posisi: <b class="text-gray-600">${p.posisi}</b> &nbsp;|&nbsp; Skor: <b class="text-primary-600">${p.skor}</b></p>
                </div>
                ${isActive ? '<span class="text-xs font-bold text-primary-500 bg-primary-100 px-2 py-0.5 rounded-full shrink-0">Giliran</span>' : ''}
            </div>`;
    });

    // Update turn banner
    const cp = GAME_DATA.pemain[currentPlayerIndex];
    document.getElementById('turn-name').textContent = cp.nama_pemain;

    // Update pions on board
    document.querySelectorAll('.pion').forEach(p => p.remove());

    // Count how many players on each cell for stacking
    const cellCounts = {};
    GAME_DATA.pemain.forEach((p) => {
        const renderPos = p.posisi === 0 ? 1 : p.posisi;
        cellCounts[renderPos] = (cellCounts[renderPos] || 0);
    });

    const cellIndexes = {};
    GAME_DATA.pemain.forEach((p, i) => {
        const renderPos = p.posisi === 0 ? 1 : p.posisi;
        const cell = document.getElementById('cell-' + renderPos);
        if (cell) {
            const idx = cellIndexes[renderPos] || 0;
            cellIndexes[renderPos] = idx + 1;

            const pion = document.createElement('div');
            pion.className = 'pion pion-' + (i % 5);
            if (i === currentPlayerIndex) {
                pion.classList.add('active-turn');
            }

            // Offset multiple pions on same cell
            const offsets = [
                { top: '-4px', left: '-4px' },
                { top: '-4px', right: '-4px', left: 'auto' },
                { bottom: '-4px', left: '-4px', top: 'auto' },
                { bottom: '-4px', right: '-4px', top: 'auto', left: 'auto' },
            ];
            const off = offsets[idx % 4];
            Object.assign(pion.style, off);

            // If player hasn't started, place them slightly below cell 1
            if (p.posisi === 0) {
                pion.style.top = 'auto';
                pion.style.bottom = '-20px';
                pion.style.opacity = '0.8';
            }

            pion.title = p.nama_pemain;
            cell.appendChild(pion);
        }
    });

    // Also show starting position indicator if posisi = 0
    GAME_DATA.pemain.forEach((p) => {
        if (p.posisi === 0) {
            const cell = document.getElementById('cell-1');
            if (cell) {
                // don't render on board — they haven't started yet
            }
        }
    });
}

// ===== ACTIVITY LOG =====
function addLog(msg) {
    const log = document.getElementById('activity-log');
    const entry = document.createElement('div');
    entry.className = 'py-1.5 px-2.5 bg-gray-50 rounded-lg text-xs text-gray-600 animate-slide-up';
    entry.innerHTML = msg;
    log.prepend(entry);
    // Keep max 30 entries
    while (log.children.length > 30) log.removeChild(log.lastChild);
}

// ===== AUDIO SYSTEM =====
const audioFiles = {
    roll: new Audio('/audio/roll.mp3'),
    move: new Audio('/audio/move.mp3'),
    rise: new Audio('/audio/rise.mp3'),
    fall: new Audio('/audio/fall.mp3'),
    bonus: new Audio('/audio/bonus.mp3')
};

function playAudio(type) {
    if (audioFiles[type]) {
        audioFiles[type].currentTime = 0;
        audioFiles[type].play().catch(e => console.log('Audio ignored:', e));
    }
}

// ===== ROLL DICE =====
async function rollDice() {
    if (isRolling) return;
    isRolling = true;

    const btn = document.getElementById('roll-btn');
    const diceBox = document.getElementById('dice-box');
    const info = document.getElementById('dice-info');

    btn.disabled = true;
    diceBox.classList.add('rolling');
    info.textContent = 'Melempar...';
    
    playAudio('roll');

    // Quick animation: randomize dots
    const animInterval = setInterval(() => {
        renderDice(Math.floor(Math.random() * 6) + 1);
    }, 80);

    const player = GAME_DATA.pemain[currentPlayerIndex];

    try {
        const res = await fetch(`/api/game/${GAME_DATA.permainanId}/lempar-dadu`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': GAME_DATA.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ pemain_id: player.id })
        });

        if (!res.ok) throw new Error('API error: ' + res.status);
        const data = await res.json();

        // Stop animation after delay
        setTimeout(() => {
            clearInterval(animInterval);
            diceBox.classList.remove('rolling');
            renderDice(data.angka_dadu);
            
            if (data.angka_dadu === 6) playAudio('bonus');
            else playAudio('move');

            const posSebelum = player.posisi;
            info.textContent = `${player.nama_pemain} dapat ${data.angka_dadu} → Posisi ${data.posisi_akhir}`;
            addLog(`<b style="color:${player.warna_pion}">${player.nama_pemain}</b> melempar dadu: <b>${data.angka_dadu}</b>`);

            player.posisi = data.posisi_akhir;
            player.skor = data.skor;

            if (data.event === 'tangga') {
                playAudio('rise');
                addLog(`🪜 <b>${player.nama_pemain}</b> naik tangga dari ${data.event_dari} ke <b>${data.event_ke}</b>!`);
            }
            if (data.event === 'ular') {
                playAudio('fall');
                addLog(`🐍 <b>${player.nama_pemain}</b> turun ular dari ${data.event_dari} ke <b>${data.event_ke}</b>!`);
            }

            renderPlayers();

            if (data.menang) {
                clearInterval(timerInterval);
                document.getElementById('win-text').textContent = `${player.nama_pemain} memenangkan permainan!`;
                document.getElementById('win-modal').classList.remove('hidden');
                return;
            }

            if (data.ada_soal) {
                setTimeout(() => loadQuestion(), 500);
            } else {
                setTimeout(() => nextTurn(), 500);
            }
        }, 600);
    } catch (e) {
        console.error('Dice error:', e);
        clearInterval(animInterval);
        diceBox.classList.remove('rolling');
        info.textContent = 'Error! Coba lagi.';
        btn.disabled = false;
        isRolling = false;
    }
}

// ===== QUESTION SYSTEM =====
async function loadQuestion() {
    try {
        const res = await fetch(`/api/game/${GAME_DATA.permainanId}/soal`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': GAME_DATA.csrfToken }
        });
        const soal = await res.json();
        if (soal.error) { nextTurn(); return; }
        showQuestion(soal);
    } catch (e) { nextTurn(); }
}

let questionStartTime;
let currentSoalId = null;
let questionTimerInterval = null;
const QUESTION_TIME_LIMIT = 30; // 30 detik untuk menjawab

function showQuestion(soal) {
    questionStartTime = Date.now();
    currentSoalId = soal.id;

    // Timer Logic
    if (questionTimerInterval) clearInterval(questionTimerInterval);
    const fill = document.getElementById('q-timer-fill');
    fill.style.transition = 'none'; // Reset transition instantly
    fill.style.width = '100%';
    fill.className = 'h-full bg-primary-500 rounded-full';
    
    // Force reflow to apply instant reset, then add transition for smooth ticking
    void fill.offsetWidth; 
    fill.style.transition = 'width 1s linear, background-color 0.3s ease';

    let timeLeft = QUESTION_TIME_LIMIT;
    questionTimerInterval = setInterval(() => {
        timeLeft--;
        const percentage = (timeLeft / QUESTION_TIME_LIMIT) * 100;
        fill.style.width = Math.max(0, percentage) + '%';
        
        if (percentage <= 20) {
            fill.className = 'h-full bg-danger-500 rounded-full';
        } else if (percentage <= 50) {
            fill.className = 'h-full bg-warning-500 rounded-full';
        }
        
        if (timeLeft <= 0) {
            clearInterval(questionTimerInterval);
            // Time's up!
            answerQuestion(soal.id, '');
        }
    }, 1000);

    document.getElementById('q-text').textContent = soal.pertanyaan;

    // Difficulty badge
    const diff = document.getElementById('q-difficulty');
    diff.textContent = soal.tingkat_kesulitan.charAt(0).toUpperCase() + soal.tingkat_kesulitan.slice(1);
    diff.className = 'px-2.5 py-1 text-xs font-bold rounded-full ' +
        (soal.tingkat_kesulitan === 'mudah' ? 'bg-success-50 text-success-600' :
         soal.tingkat_kesulitan === 'sedang' ? 'bg-warning-50 text-warning-600' : 'bg-danger-50 text-danger-600');

    // Type badge
    const typeBadge = document.getElementById('q-type-badge');
    const typeLabels = { pilihan_ganda: 'Pilihan Ganda', benar_salah: 'Benar / Salah', isian: 'Isian' };
    typeBadge.textContent = typeLabels[soal.jenis_soal] || soal.jenis_soal;

    // Hide all option sections first
    document.getElementById('q-options-pg').classList.add('hidden');
    document.getElementById('q-options-bs').classList.add('hidden');
    document.getElementById('q-options-isian').classList.add('hidden');

    const jenis = soal.jenis_soal;

    if (jenis === 'pilihan_ganda') {
        // ===== PILIHAN GANDA =====
        const opts = document.getElementById('q-options-pg');
        opts.innerHTML = '';
        if (soal.pilihan && soal.pilihan.length > 0) {
            soal.pilihan.forEach(p => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'w-full text-left p-3 border-2 border-gray-200 rounded-xl hover:border-primary-400 hover:bg-primary-50 transition-all font-medium text-sm';
                btn.innerHTML = `<span class="font-bold text-primary-600 mr-2">${p.label}.</span> ${p.isi_pilihan}`;
                btn.onclick = () => answerQuestion(soal.id, p.label);
                opts.appendChild(btn);
            });
        }
        opts.classList.remove('hidden');

    } else if (jenis === 'benar_salah') {
        // ===== BENAR / SALAH =====
        const bsSection = document.getElementById('q-options-bs');
        document.getElementById('btn-benar').onclick = () => answerQuestion(soal.id, 'Benar');
        document.getElementById('btn-salah').onclick = () => answerQuestion(soal.id, 'Salah');
        bsSection.classList.remove('hidden');

    } else if (jenis === 'isian') {
        // ===== ISIAN =====
        const isianSection = document.getElementById('q-options-isian');
        const isianInput = document.getElementById('q-isian-input');
        isianInput.value = '';

        document.getElementById('btn-submit-isian').onclick = () => {
            const jawaban = isianInput.value.trim();
            if (!jawaban) {
                isianInput.classList.add('border-red-400');
                isianInput.placeholder = 'Jawaban tidak boleh kosong!';
                isianInput.focus();
                return;
            }
            answerQuestion(soal.id, jawaban);
        };

        // Also allow Enter key to submit
        isianInput.onkeydown = (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('btn-submit-isian').click();
            }
            isianInput.classList.remove('border-red-400');
        };

        isianSection.classList.remove('hidden');
        // Auto-focus the input after a small delay (for animation)
        setTimeout(() => isianInput.focus(), 300);

    } else {
        // Fallback: show pilihan if available
        const opts = document.getElementById('q-options-pg');
        opts.innerHTML = '';
        if (soal.pilihan && soal.pilihan.length > 0) {
            soal.pilihan.forEach(p => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'w-full text-left p-3 border-2 border-gray-200 rounded-xl hover:border-primary-400 hover:bg-primary-50 transition-all font-medium text-sm';
                btn.innerHTML = `<span class="font-bold text-primary-600 mr-2">${p.label}.</span> ${p.isi_pilihan}`;
                btn.onclick = () => answerQuestion(soal.id, p.label);
                opts.appendChild(btn);
            });
        }
        opts.classList.remove('hidden');
    }

    document.getElementById('question-modal').classList.remove('hidden');
}

async function answerQuestion(soalId, jawaban) {
    if (questionTimerInterval) clearInterval(questionTimerInterval);

    const player = GAME_DATA.pemain[currentPlayerIndex];
    const waktu = Math.round((Date.now() - questionStartTime) / 1000);
    document.getElementById('question-modal').classList.add('hidden');

    try {
        const res = await fetch(`/api/game/${GAME_DATA.permainanId}/jawab`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': GAME_DATA.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ pemain_id: player.id, soal_id: soalId, jawaban: jawaban, waktu_jawab: waktu })
        });
        const data = await res.json();

        player.skor = data.skor_total;
        renderPlayers();

        document.getElementById('result-icon').textContent = data.is_benar ? '🎉' : '😔';
        document.getElementById('result-title').textContent = data.is_benar ? 'Jawaban Benar!' : 'Jawaban Salah';
        document.getElementById('result-title').className = 'text-2xl font-extrabold mb-2 ' + (data.is_benar ? 'text-success-600' : 'text-danger-500');
        document.getElementById('result-text').textContent = (data.poin > 0 ? '+' : '') + data.poin + ' poin';
        document.getElementById('result-explanation').textContent = data.pembahasan || 'Jawaban benar: ' + data.kunci_jawaban;

        addLog(`${data.is_benar ? '✅' : '❌'} <b>${player.nama_pemain}</b> menjawab ${data.is_benar ? 'benar' : 'salah'} (${data.poin > 0 ? '+' : ''}${data.poin})`);

        document.getElementById('result-modal').classList.remove('hidden');
        
        // Store extra data for when the modal is closed
        document.getElementById('result-modal').dataset.langkahTambahan = data.langkah_tambahan || 0;
        document.getElementById('result-modal').dataset.posisiSetelah = data.posisi_setelah_tambahan || player.posisi;
        document.getElementById('result-modal').dataset.eventTambahan = data.event_tambahan || '';
        document.getElementById('result-modal').dataset.menang = data.menang ? '1' : '0';

    } catch (e) { nextTurn(); }
}

function closeResultModal() {
    const modal = document.getElementById('result-modal');
    modal.classList.add('hidden');
    
    const player = GAME_DATA.pemain[currentPlayerIndex];
    const langkah = parseInt(modal.dataset.langkahTambahan || '0');
    const menang = modal.dataset.menang === '1';
    
    if (langkah !== 0) {
        player.posisi = parseInt(modal.dataset.posisiSetelah || player.posisi);
        const arah = langkah > 0 ? 'Maju' : 'Mundur';
        addLog(`⚡ ${arah} ${Math.abs(langkah)} langkah ke kotak ${player.posisi}`);
        
        const eventTambahan = modal.dataset.eventTambahan;
        if (eventTambahan === 'tangga') {
            playAudio('rise');
            addLog(`🪜 Naik tangga dari bonus!`);
        } else if (eventTambahan === 'ular') {
            playAudio('fall');
            addLog(`🐍 Turun ular dari penalti!`);
        } else {
            playAudio('move');
        }
        
        renderPlayers();
    }
    
    if (menang) {
        clearInterval(timerInterval);
        document.getElementById('win-text').textContent = `${player.nama_pemain} memenangkan permainan!`;
        document.getElementById('win-modal').classList.remove('hidden');
        return;
    }
    
    nextTurn();
}

// ===== TURN MANAGEMENT =====
function nextTurn() {
    currentPlayerIndex = (currentPlayerIndex + 1) % GAME_DATA.pemain.length;
    isRolling = false;
    document.getElementById('roll-btn').disabled = false;
    document.getElementById('dice-info').textContent = `Giliran ${GAME_DATA.pemain[currentPlayerIndex].nama_pemain} — klik dadu!`;
    renderPlayers();

    // Computer player auto-roll
    if (GAME_DATA.pemain[currentPlayerIndex].tipe_pemain === 'komputer') {
        document.getElementById('dice-info').textContent = 'Komputer sedang berpikir...';
        document.getElementById('roll-btn').disabled = true;
        setTimeout(() => rollDice(), 1200);
    }
}

function doExitGame() {
    document.getElementById('exit-modal').classList.add('hidden');
    fetch(`/api/game/${GAME_DATA.permainanId}/selesai`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': GAME_DATA.csrfToken, 'Accept': 'application/json' }
    }).then(() => window.location.href = '{{ route("siswa.dashboard") }}');
}

// ===== INIT =====
buildBoard();
renderPlayers();
renderDice(0);
addLog('🎮 Permainan dimulai! Selamat bermain!');
addLog(`Giliran pertama: <b>${GAME_DATA.pemain[0].nama_pemain}</b>`);
</script>
@endpush
@endsection
