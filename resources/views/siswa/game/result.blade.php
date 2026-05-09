@extends('layouts.app')
@section('title', 'Hasil Permainan')
@section('page-title', 'Hasil Permainan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
        <div class="text-6xl mb-4">🏆</div>
        <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Permainan Selesai!</h2>
        <p class="text-gray-500">{{ $permainan->mataPelajaran->nama }} • {{ $permainan->kelas->nama_kelas }}</p>
        <p class="text-sm text-gray-400 mt-1">Kode: {{ $permainan->kode_permainan }}</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">📊 Hasil Pemain</h3>
        </div>
        <div class="p-5 space-y-3">
            @foreach($hasil as $h)
            <div class="flex items-center gap-4 p-4 rounded-xl {{ $h->status === 'menang' ? 'bg-warning-50 border border-warning-200' : 'bg-gray-50' }}">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg font-black {{ $h->peringkat === 1 ? 'bg-warning-500 text-white' : 'bg-gray-200 text-gray-600' }}">
                    {{ $h->peringkat }}
                </div>
                <div class="flex-1">
                    <p class="font-bold text-gray-900">{{ $h->pemainPermainan->nama_pemain }} {!! $h->status === 'menang' ? '🏆' : '' !!}</p>
                    <div class="flex gap-4 text-xs text-gray-500 mt-1">
                        <span>✅ {{ $h->jumlah_benar }} benar</span>
                        <span>❌ {{ $h->jumlah_salah }} salah</span>
                        <span>⏱️ {{ gmdate('i:s', $h->durasi_detik) }}</span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-black text-primary-600">{{ $h->skor_akhir }}</p>
                    <p class="text-xs text-gray-500">poin</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="flex gap-3 justify-center">
        <a href="{{ route('siswa.game.index') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold px-6 py-3 rounded-xl hover:shadow-lg transition-all">🎮 Main Lagi</a>
        <a href="{{ route('siswa.dashboard') }}" class="bg-gray-100 text-gray-700 font-semibold px-6 py-3 rounded-xl hover:bg-gray-200 transition-colors">← Dashboard</a>
    </div>
</div>
@endsection
