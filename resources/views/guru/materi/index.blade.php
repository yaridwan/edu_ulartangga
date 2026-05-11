@extends('layouts.app')
@section('title', 'Materi')
@section('page-title', 'Materi')

@section('content')
<div class="space-y-4">
    <div class="flex justify-end"><a href="{{ route('guru.materi.create') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold px-5 py-2.5 rounded-xl text-sm">+ Tambah Materi</a></div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50"><tr><th class="px-5 py-3 text-left font-semibold">Judul</th><th class="px-5 py-3 text-left font-semibold">Mapel</th><th class="px-5 py-3 text-left font-semibold">Kelas</th><th class="px-5 py-3 text-left font-semibold">Status</th><th class="px-5 py-3 text-right font-semibold">Aksi</th></tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($materi as $m)
                <tr class="hover:bg-gray-50"><td class="px-5 py-3 font-semibold">{{ $m->judul }}</td><td class="px-5 py-3 text-gray-500">{{ $m->mataPelajaran->nama }}</td><td class="px-5 py-3 text-gray-500">{{ $m->kelas->nama_kelas }}</td><td class="px-5 py-3"><span class="px-2 py-1 text-xs font-bold rounded-full {{ $m->status === 'aktif' ? 'bg-success-50 text-success-600' : 'bg-gray-100 text-gray-500' }}">{{ ucfirst($m->status) }}</span></td><td class="px-5 py-3"><div class="flex gap-1.5 justify-end"><a href="{{ route('guru.materi.edit', $m) }}" title="Edit Materi" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-50 text-primary-600 hover:bg-primary-100 hover:text-primary-700 transition-all duration-200"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a><form action="{{ route('guru.materi.destroy', $m) }}" method="POST" class="inline" onsubmit="return confirm('Hapus materi ini?')">@csrf @method('DELETE')<button type="submit" title="Hapus Materi" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-danger-50 text-danger-500 hover:bg-danger-100 hover:text-danger-600 transition-all duration-200"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form></div></td></tr>
                @empty
                <tr><td colspan="5" class="px-5 py-8 text-center text-gray-400">Belum ada materi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $materi->links() }}
</div>
@endsection
