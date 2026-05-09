@extends('layouts.app')
@section('title', 'Paket Permainan')
@section('page-title', 'Paket Permainan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <p class="text-gray-500 text-sm">Kelola paket permainan yang dapat dimainkan siswa</p>
        <a href="{{ route('guru.paket-permainan.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold px-5 py-2.5 rounded-xl hover:shadow-lg transition-all hover:-translate-y-0.5">
            ➕ Buat Paket Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Judul</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mapel</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kelas</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Mode</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Soal</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Sesi</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($paket as $p)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-4">
                        <a href="{{ route('guru.paket-permainan.show', $p) }}" class="font-semibold text-sm text-gray-900 hover:text-primary-600">{{ $p->judul }}</a>
                        @if($p->deskripsi)
                        <p class="text-xs text-gray-400 truncate max-w-xs">{{ Str::limit($p->deskripsi, 50) }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-600">{{ $p->mataPelajaran->nama ?? '-' }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600">{{ $p->kelas->nama_kelas ?? '-' }}</td>
                    <td class="px-5 py-4 text-center">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $p->mode === 'solo' ? 'bg-blue-50 text-blue-600' : ($p->mode === 'komputer' ? 'bg-purple-50 text-purple-600' : 'bg-orange-50 text-orange-600') }}">
                            {{ ucfirst($p->mode) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-center text-sm font-semibold text-gray-700">{{ $p->jumlah_soal }}</td>
                    <td class="px-5 py-4 text-center text-sm font-semibold text-primary-600">{{ $p->permainan_count }}</td>
                    <td class="px-5 py-4 text-center">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $p->status === 'aktif' ? 'bg-success-50 text-success-600' : 'bg-gray-100 text-gray-500' }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('guru.paket-permainan.show', $p) }}" class="p-2 text-gray-400 hover:text-primary-600 rounded-lg hover:bg-primary-50" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('guru.paket-permainan.edit', $p) }}" class="p-2 text-gray-400 hover:text-warning-600 rounded-lg hover:bg-warning-50" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('guru.paket-permainan.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')">
                                @csrf @method('DELETE')
                                <button class="p-2 text-gray-400 hover:text-danger-600 rounded-lg hover:bg-danger-50" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-12 text-center text-gray-400">
                        <div class="text-4xl mb-2">📦</div>
                        <p class="font-semibold">Belum ada paket permainan</p>
                        <p class="text-sm mt-1">Buat paket permainan pertama untuk siswa</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($paket->hasPages())
        <div class="px-5 py-3 border-t border-gray-100">
            {{ $paket->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
