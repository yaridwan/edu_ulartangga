@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center text-xl">👥</div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $stats['total_pengguna'] }}</p>
                    <p class="text-xs text-gray-500 font-medium">Total Pengguna</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-success-50 rounded-xl flex items-center justify-center text-xl">👩‍🏫</div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $stats['total_guru'] }}</p>
                    <p class="text-xs text-gray-500 font-medium">Total Guru</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-warning-50 rounded-xl flex items-center justify-center text-xl">👨‍🎓</div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $stats['total_siswa'] }}</p>
                    <p class="text-xs text-gray-500 font-medium">Total Siswa</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-danger-50 rounded-xl flex items-center justify-center text-xl">📝</div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $stats['total_soal'] }}</p>
                    <p class="text-xs text-gray-500 font-medium">Total Soal</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-xl">🎮</div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $stats['total_permainan'] }}</p>
                    <p class="text-xs text-gray-500 font-medium">Total Permainan</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-xl">📚</div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $stats['total_mapel'] }}</p>
                    <p class="text-xs text-gray-500 font-medium">Mata Pelajaran</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        {{-- Permainan Terbaru --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-900">🎮 Permainan Terbaru</h3>
            </div>
            <div class="p-5">
                @forelse($permainanTerbaru as $p)
                <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                    <div>
                        <p class="font-semibold text-sm text-gray-900">{{ $p->kode_permainan }}</p>
                        <p class="text-xs text-gray-500">{{ $p->mataPelajaran->nama ?? '-' }} • {{ $p->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $p->status === 'selesai' ? 'bg-success-50 text-success-600' : ($p->status === 'berjalan' ? 'bg-warning-50 text-warning-600' : 'bg-gray-100 text-gray-500') }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </div>
                @empty
                <p class="text-gray-400 text-sm text-center py-6">Belum ada permainan.</p>
                @endforelse
            </div>
        </div>

        {{-- Siswa Aktif --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-900">🏆 Siswa Paling Aktif</h3>
            </div>
            <div class="p-5">
                @forelse($siswaAktif as $index => $s)
                <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center text-sm font-bold text-primary-700">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-gray-900">{{ $s->name }}</p>
                            <p class="text-xs text-gray-500">{{ $s->kelas->nama_kelas ?? '-' }}</p>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-primary-600">{{ $s->hasil_permainan_count }} game</span>
                </div>
                @empty
                <p class="text-gray-400 text-sm text-center py-6">Belum ada data siswa.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
