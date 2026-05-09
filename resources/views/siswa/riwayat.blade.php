@extends('layouts.app')
@section('title', 'Riwayat Permainan')
@section('page-title', 'Riwayat Permainan')

@section('content')
<div class="space-y-3">
    @forelse($riwayat as $r)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="font-bold text-gray-900">{{ $r->permainan->mataPelajaran->nama ?? '-' }}</p>
                <p class="text-sm text-gray-500">{{ $r->permainan->kelas->nama_kelas ?? '-' }} • {{ $r->created_at->format('d M Y H:i') }}</p>
                <div class="flex gap-4 text-xs text-gray-500 mt-2">
                    <span>✅ {{ $r->jumlah_benar }} benar</span>
                    <span>❌ {{ $r->jumlah_salah }} salah</span>
                    <span>⏱️ {{ gmdate('i:s', $r->durasi_detik) }}</span>
                    <span>🏅 Peringkat {{ $r->peringkat }}</span>
                </div>
            </div>
            <div class="text-right">
                <p class="text-2xl font-black text-primary-600">{{ $r->skor_akhir }}</p>
                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $r->status === 'menang' ? 'bg-success-50 text-success-600' : 'bg-gray-100 text-gray-500' }}">{{ $r->status === 'menang' ? '🏆 Menang' : ucfirst($r->status) }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-12 text-gray-400"><p class="text-lg mb-2">📋</p><p>Belum ada riwayat permainan.</p></div>
    @endforelse
    {{ $riwayat->links() }}
</div>
@endsection
