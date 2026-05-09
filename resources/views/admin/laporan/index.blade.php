@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100"><h3 class="font-bold text-gray-900">📊 Laporan Hasil Permainan</h3></div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50"><tr><th class="px-5 py-3 text-left font-semibold">Pemain</th><th class="px-5 py-3 text-left font-semibold">Mapel</th><th class="px-5 py-3 text-left font-semibold">Skor</th><th class="px-5 py-3 text-left font-semibold">Benar/Salah</th><th class="px-5 py-3 text-left font-semibold">Status</th><th class="px-5 py-3 text-left font-semibold">Tanggal</th></tr></thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($hasil as $h)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-semibold">{{ $h->user->name ?? $h->pemainPermainan->nama_pemain ?? '-' }}</td>
                <td class="px-5 py-3 text-gray-500">{{ $h->permainan->mataPelajaran->nama ?? '-' }}</td>
                <td class="px-5 py-3 font-bold text-primary-600">{{ $h->skor_akhir }}</td>
                <td class="px-5 py-3"><span class="text-success-600">{{ $h->jumlah_benar }}</span> / <span class="text-danger-500">{{ $h->jumlah_salah }}</span></td>
                <td class="px-5 py-3"><span class="px-2 py-1 text-xs font-bold rounded-full {{ $h->status === 'menang' ? 'bg-success-50 text-success-600' : 'bg-gray-100 text-gray-500' }}">{{ ucfirst($h->status) }}</span></td>
                <td class="px-5 py-3 text-gray-500 text-xs">{{ $h->created_at->format('d M Y H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-8 text-center text-gray-400">Belum ada data laporan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $hasil->links() }}</div>
@endsection
