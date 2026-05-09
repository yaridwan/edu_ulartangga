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
                <div class="space-x-2">
                    <a href="{{ route('admin.mata-pelajaran.edit', $m) }}" class="text-primary-600 text-xs font-semibold hover:underline">Edit</a>
                    <form action="{{ route('admin.mata-pelajaran.destroy', $m) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-danger-500 text-xs font-semibold hover:underline">Hapus</button></form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $mapel->links() }}
</div>
@endsection
