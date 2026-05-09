@extends('layouts.app')
@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')

@section('content')
<div class="space-y-6">
    {{-- Welcome & Play Button --}}
    <div class="bg-gradient-to-r from-primary-500 to-primary-700 rounded-3xl p-6 text-white relative overflow-hidden shadow-lg shadow-primary-500/25">
        <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mt-20 blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <a href="{{ route('siswa.profile.index') }}" class="group relative block shrink-0">
                    <div class="w-20 h-20 bg-white rounded-full p-1.5 shadow-inner transition-transform group-hover:scale-105">
                        <img src="{{ auth()->user()->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed='.auth()->user()->name.'&backgroundColor=b6e3f4' }}" class="w-full h-full rounded-full object-cover">
                    </div>
                    <div class="absolute -bottom-2 -right-2 bg-warning-400 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm border-2 border-primary-600" title="Level Anda">
                        {{ auth()->user()->level }}
                    </div>
                </a>
                <div>
                    <h2 class="text-2xl font-extrabold mb-1 drop-shadow-sm">Halo, {{ auth()->user()->name }}! 👋</h2>
                    <div class="flex items-center gap-4 text-primary-100 text-sm">
                        <span class="flex items-center gap-1 bg-black/20 px-3 py-1 rounded-full"><span class="text-warning-300">⭐</span> {{ number_format(auth()->user()->bintang) }} Bintang</span>
                        <a href="{{ route('siswa.profile.index') }}" class="hover:text-white hover:underline transition-colors">Edit Profil</a>
                    </div>
                </div>
            </div>
            <div class="shrink-0">
                <a href="{{ route('siswa.game.index') }}" class="inline-flex items-center gap-2 bg-white text-primary-700 font-bold px-8 py-4 rounded-xl hover:shadow-xl transition-all hover:-translate-y-1 text-lg">
                    🎮 Main Sekarang
                </a>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
            <p class="text-3xl font-black text-primary-600">{{ $stats['skor_terakhir'] }}</p>
            <p class="text-xs text-gray-500 font-medium mt-1">Skor Terakhir</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
            <p class="text-3xl font-black text-success-600">{{ $stats['total_permainan'] }}</p>
            <p class="text-xs text-gray-500 font-medium mt-1">Total Permainan</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
            <p class="text-3xl font-black text-warning-600">{{ $stats['total_menang'] }}</p>
            <p class="text-xs text-gray-500 font-medium mt-1">Total Menang</p>
        </div>
    </div>

    {{-- Riwayat --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-900">📋 Riwayat Permainan</h3>
            <a href="{{ route('siswa.riwayat.index') }}" class="text-sm text-primary-600 font-semibold hover:underline">Lihat semua →</a>
        </div>
        <div class="p-5">
            @forelse($riwayat as $r)
            <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                <div>
                    <p class="font-semibold text-sm text-gray-900">{{ $r->permainan->mataPelajaran->nama ?? '-' }}</p>
                    <p class="text-xs text-gray-500">Skor: {{ $r->skor_akhir }} • {{ $r->created_at->diffForHumans() }}</p>
                </div>
                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $r->status === 'menang' ? 'bg-success-50 text-success-600' : 'bg-gray-100 text-gray-500' }}">
                    {{ $r->status === 'menang' ? '🏆 Menang' : ucfirst($r->status) }}
                </span>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-6">Belum ada riwayat permainan. <a href="{{ route('siswa.game.index') }}" class="text-primary-600 hover:underline">Mulai bermain!</a></p>
            @endforelse
        </div>
    </div>
</div>
@endsection
