@extends('layouts.app')
@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard Guru')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center text-xl">📝</div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $stats['total_soal'] }}</p>
                    <p class="text-xs text-gray-500 font-medium">Total Soal</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-success-50 rounded-xl flex items-center justify-center text-xl">✅</div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $stats['soal_aktif'] }}</p>
                    <p class="text-xs text-gray-500 font-medium">Soal Aktif</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-warning-50 rounded-xl flex items-center justify-center text-xl">📚</div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $stats['total_mapel'] }}</p>
                    <p class="text-xs text-gray-500 font-medium">Mata Pelajaran</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('guru.soal.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold px-5 py-3 rounded-xl hover:shadow-lg transition-all hover:-translate-y-0.5">
            ➕ Tambah Soal
        </a>
        <a href="{{ route('guru.materi.create') }}" class="inline-flex items-center gap-2 bg-white text-gray-700 font-semibold px-5 py-3 rounded-xl border border-gray-200 hover:border-primary-300 transition-all">
            📄 Tambah Materi
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">📝 Soal Terbaru</h3>
        </div>
        <div class="p-5">
            @forelse($soalTerbaru as $soal)
            <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm text-gray-900 truncate">{{ Str::limit($soal->pertanyaan, 60) }}</p>
                    <p class="text-xs text-gray-500">{{ $soal->mataPelajaran->nama ?? '-' }} • {{ $soal->kelas->nama_kelas ?? '-' }} • {{ ucfirst($soal->tingkat_kesulitan) }}</p>
                </div>
                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $soal->status === 'aktif' ? 'bg-success-50 text-success-600' : 'bg-gray-100 text-gray-500' }}">
                    {{ ucfirst($soal->status) }}
                </span>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-6">Belum ada soal. <a href="{{ route('guru.soal.create') }}" class="text-primary-600 hover:underline">Buat soal pertama</a></p>
            @endforelse
        </div>
    </div>
</div>
@endsection
