@extends('layouts.app')
@section('title', 'Mata Pelajaran')
@section('page-title', 'Mata Pelajaran')

@section('content')
<div class="space-y-4">
    <div class="flex justify-end"><a href="{{ route('admin.mata-pelajaran.create') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold px-5 py-2.5 rounded-xl text-sm">+ Tambah</a></div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($mapel as $m)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-sm" style="background:{{ $m->warna ?? '#3b82f6' }}">{{ strtoupper(substr($m->kode ?? $m->nama, 0, 3)) }}</div>
                <div><h3 class="font-bold text-gray-900">{{ $m->nama }}</h3><p class="text-xs text-gray-500">{{ $m->soal_count }} soal</p></div>
            </div>
            <p class="text-sm text-gray-500 mb-3">{{ $m->deskripsi ?: 'Tidak ada deskripsi' }}</p>
            <div class="flex items-center justify-between">
                <span class="px-2 py-1 text-xs font-bold rounded-full {{ $m->status === 'aktif' ? 'bg-success-50 text-success-600' : 'bg-gray-100 text-gray-500' }}">{{ ucfirst($m->status) }}</span>
                <div class="flex gap-1.5">
                    <a href="{{ route('admin.mata-pelajaran.edit', $m) }}" title="Edit Mapel" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-50 text-primary-600 hover:bg-primary-100 hover:text-primary-700 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <form action="{{ route('admin.mata-pelajaran.destroy', $m) }}" method="POST" class="inline" onsubmit="return confirm('Hapus mapel ini?')">@csrf @method('DELETE')
                        <button type="submit" title="Hapus Mapel" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-danger-50 text-danger-500 hover:bg-danger-100 hover:text-danger-600 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $mapel->links() }}
</div>
@endsection
