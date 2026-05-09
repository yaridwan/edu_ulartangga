@extends('layouts.app')
@section('title', $paketPermainan->judul)
@section('page-title', 'Detail Paket Permainan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900">{{ $paketPermainan->judul }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ $paketPermainan->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                <div class="flex flex-wrap gap-2 mt-3">
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-primary-50 text-primary-600">{{ $paketPermainan->mataPelajaran->nama ?? '-' }}</span>
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-600">{{ $paketPermainan->kelas->nama_kelas ?? '-' }}</span>
                    <span class="px-3 py-1 text-xs font-bold rounded-full {{ $paketPermainan->status === 'aktif' ? 'bg-success-50 text-success-600' : 'bg-gray-100 text-gray-500' }}">{{ ucfirst($paketPermainan->status) }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('guru.paket-permainan.edit', $paketPermainan) }}" class="bg-warning-50 text-warning-600 font-semibold px-4 py-2 rounded-xl text-sm hover:bg-warning-100 transition-colors">✏️ Edit</a>
                <a href="{{ route('guru.paket-permainan.index') }}" class="bg-gray-100 text-gray-600 font-semibold px-4 py-2 rounded-xl text-sm hover:bg-gray-200 transition-colors">← Kembali</a>
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
            <p class="text-3xl font-black text-primary-600">{{ $statistik['total_sesi'] }}</p>
            <p class="text-xs text-gray-500 font-medium mt-1">Total Sesi</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
            <p class="text-3xl font-black text-success-600">{{ $statistik['sesi_selesai'] }}</p>
            <p class="text-xs text-gray-500 font-medium mt-1">Sesi Selesai</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
            <p class="text-3xl font-black text-warning-600">{{ $statistik['soal_tersedia'] }}</p>
            <p class="text-xs text-gray-500 font-medium mt-1">Soal Tersedia</p>
        </div>
    </div>

    {{-- Konfigurasi --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">⚙️ Konfigurasi</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-y-4 gap-x-8 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Mode</span>
                    <span class="font-semibold text-gray-900">{{ ucfirst($paketPermainan->mode) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Maks Pemain</span>
                    <span class="font-semibold text-gray-900">{{ $paketPermainan->maks_pemain }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Jumlah Soal</span>
                    <span class="font-semibold text-gray-900">{{ $paketPermainan->jumlah_soal }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Waktu Jawab</span>
                    <span class="font-semibold text-gray-900">{{ $paketPermainan->waktu_jawab ? $paketPermainan->waktu_jawab . ' detik' : 'Tanpa batas' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Poin Benar</span>
                    <span class="font-semibold text-success-600">+{{ $paketPermainan->poin_benar }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Poin Salah</span>
                    <span class="font-semibold text-danger-500">{{ $paketPermainan->poin_salah }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Bonus Langkah</span>
                    <span class="font-semibold text-gray-900">{{ $paketPermainan->bonus_langkah ?: '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Penalti Langkah</span>
                    <span class="font-semibold text-gray-900">{{ $paketPermainan->penalti_langkah ?: '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Pembahasan</span>
                    <span class="font-semibold text-gray-900">{{ $paketPermainan->tampilkan_pembahasan ? 'Ya' : 'Tidak' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Acak Soal</span>
                    <span class="font-semibold text-gray-900">{{ $paketPermainan->acak_soal ? 'Ya' : 'Tidak' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Sesi --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">🎮 Riwayat Permainan</h3>
        </div>
        <div class="p-6">
            @forelse($paketPermainan->permainan as $p)
            <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                <div>
                    <p class="font-semibold text-sm text-gray-900">{{ $p->kode_permainan }}</p>
                    <p class="text-xs text-gray-500">{{ $p->created_at->format('d M Y H:i') }} • {{ $p->pemain->count() }} pemain</p>
                </div>
                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $p->status === 'selesai' ? 'bg-success-50 text-success-600' : ($p->status === 'berjalan' ? 'bg-warning-50 text-warning-600' : 'bg-gray-100 text-gray-500') }}">
                    {{ ucfirst($p->status) }}
                </span>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-6">Belum ada sesi permainan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
