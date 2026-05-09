@extends('layouts.app')
@section('title', 'Leaderboard')
@section('page-title', '🏆 Leaderboard')

@section('content')
<div class="space-y-4">
    <form class="flex gap-2" method="GET">
        <select name="mata_pelajaran_id" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm"><option value="">Semua Mapel</option>@foreach($mapel as $m)<option value="{{ $m->id }}" {{ request('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>@endforeach</select>
        <select name="kelas_id" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm"><option value="">Semua Kelas</option>@foreach($kelas as $k)<option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>@endforeach</select>
        <button class="bg-primary-500 text-white px-4 py-2 rounded-xl text-sm font-semibold">Filter</button>
    </form>
    <div class="space-y-3">
        @forelse($leaderboard as $i => $l)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-4 hover:shadow-md transition-shadow {{ $leaderboard->firstItem() + $i <= 3 ? 'border-l-4 border-l-warning-400' : '' }}">
            <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-black {{ $leaderboard->firstItem() + $i === 1 ? 'bg-yellow-400 text-white' : ($leaderboard->firstItem() + $i === 2 ? 'bg-gray-300 text-white' : ($leaderboard->firstItem() + $i === 3 ? 'bg-orange-400 text-white' : 'bg-gray-100 text-gray-600')) }}">
                {{ $leaderboard->firstItem() + $i }}
            </div>
            <div class="flex-1"><p class="font-bold text-gray-900">{{ $l->user->name }}</p><p class="text-xs text-gray-500">{{ $l->kelas->nama_kelas }} • {{ $l->mataPelajaran->nama }}</p></div>
            <div class="text-right"><p class="text-xl font-black text-primary-600">{{ $l->total_skor }}</p><p class="text-xs text-gray-500">{{ $l->total_menang }} menang / {{ $l->total_permainan }} game</p></div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-400">Belum ada data leaderboard.</div>
        @endforelse
    </div>
    {{ $leaderboard->links() }}
</div>
@endsection
