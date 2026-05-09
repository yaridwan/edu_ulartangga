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
                <tr class="hover:bg-gray-50"><td class="px-5 py-3 font-semibold">{{ $m->judul }}</td><td class="px-5 py-3 text-gray-500">{{ $m->mataPelajaran->nama }}</td><td class="px-5 py-3 text-gray-500">{{ $m->kelas->nama_kelas }}</td><td class="px-5 py-3"><span class="px-2 py-1 text-xs font-bold rounded-full {{ $m->status === 'aktif' ? 'bg-success-50 text-success-600' : 'bg-gray-100 text-gray-500' }}">{{ ucfirst($m->status) }}</span></td><td class="px-5 py-3 text-right space-x-2"><a href="{{ route('guru.materi.edit', $m) }}" class="text-primary-600 text-xs font-semibold hover:underline">Edit</a><form action="{{ route('guru.materi.destroy', $m) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-danger-500 text-xs font-semibold hover:underline">Hapus</button></form></td></tr>
                @empty
                <tr><td colspan="5" class="px-5 py-8 text-center text-gray-400">Belum ada materi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $materi->links() }}
</div>
@endsection
