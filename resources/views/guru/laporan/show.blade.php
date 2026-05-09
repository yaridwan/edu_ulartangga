@extends('layouts.app')
@section('title', 'Detail Laporan')
@section('page-title', 'Detail Laporan Permainan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900">{{ $permainan->kode_permainan }}</h2>
                <div class="flex flex-wrap gap-2 mt-2">
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-primary-50 text-primary-600">{{ $permainan->mataPelajaran->nama ?? '-' }}</span>
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-600">{{ $permainan->kelas->nama_kelas ?? '-' }}</span>
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-success-50 text-success-600">{{ ucfirst($permainan->status) }}</span>
                </div>
                <p class="text-sm text-gray-500 mt-2">
                    {{ $permainan->dimulai_pada?->format('d M Y H:i') }} —
                    {{ $permainan->selesai_pada?->format('H:i') }}
                    @if($permainan->dimulai_pada && $permainan->selesai_pada)
                        ({{ $permainan->dimulai_pada->diff($permainan->selesai_pada)->format('%i menit %s detik') }})
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('guru.laporan.pdf', $permainan) }}" target="_blank" class="bg-white text-gray-700 border border-gray-200 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
                    📄 Cetak PDF
                </a>
                <a href="{{ route('guru.laporan.index') }}" class="bg-gray-100 text-gray-600 font-semibold px-4 py-2 rounded-xl text-sm hover:bg-gray-200">← Kembali</a>
            </div>
        </div>
    </div>

    {{-- Ranking Pemain --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">🏆 Ranking Pemain</h3>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @foreach($permainan->pemain as $index => $pemain)
                <div class="flex items-center gap-4 p-4 rounded-xl {{ $index === 0 ? 'bg-yellow-50 border border-yellow-200' : 'bg-gray-50' }}">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg font-black {{ $index === 0 ? 'bg-yellow-400 text-white' : ($index === 1 ? 'bg-gray-300 text-white' : 'bg-orange-300 text-white') }}">
                        {{ $index + 1 }}
                    </div>
                    <div class="w-8 h-8 rounded-full shadow" style="background: {{ $pemain->warna_pion }}"></div>
                    <div class="flex-1">
                        <p class="font-bold text-sm text-gray-900">{{ $pemain->nama_pemain }}</p>
                        <p class="text-xs text-gray-500">{{ ucfirst($pemain->tipe_pemain) }} • Posisi akhir: {{ $pemain->posisi }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-black text-primary-600">{{ $pemain->skor }} pts</p>
                        @if(isset($statistikPemain[$pemain->id]))
                        <p class="text-xs text-gray-500">
                            ✅ {{ $statistikPemain[$pemain->id]['benar'] }} &nbsp;
                            ❌ {{ $statistikPemain[$pemain->id]['salah'] }} &nbsp;
                            ⏱️ ~{{ $statistikPemain[$pemain->id]['rata_waktu'] }}s
                        </p>
                        @endif
                    </div>
                    @if($pemain->status === 'menang')
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700">🏆 Menang</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Soal Paling Sering Salah --}}
    @if($soalSalah->count() > 0)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">⚠️ Soal Paling Sering Salah</h3>
        </div>
        <div class="p-6 space-y-3">
            @foreach($soalSalah as $item)
            <div class="flex items-start gap-3 p-3 bg-danger-50 rounded-xl">
                <div class="w-8 h-8 bg-danger-100 rounded-lg flex items-center justify-center text-sm font-bold text-danger-600 shrink-0">
                    {{ $item->total_salah }}x
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ Str::limit($item->soal->pertanyaan ?? '-', 100) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Jawaban benar: <b>{{ $item->soal->kunci_jawaban ?? '-' }}</b> • {{ ucfirst($item->soal->tingkat_kesulitan ?? '-') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Detail Jawaban --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">📝 Detail Jawaban</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pemain</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Soal</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Jawaban</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Poin</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($permainan->jawaban as $j)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-sm font-medium text-gray-900">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full" style="background: {{ $j->pemainPermainan->warna_pion ?? '#ccc' }}"></div>
                                {{ $j->pemainPermainan->nama_pemain ?? '-' }}
                            </div>
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-600 max-w-xs truncate">{{ Str::limit($j->soal->pertanyaan ?? '-', 60) }}</td>
                        <td class="px-5 py-3 text-sm text-center font-mono">{{ $j->jawaban }}</td>
                        <td class="px-5 py-3 text-center">
                            <span class="px-2 py-1 text-xs font-bold rounded-full {{ $j->is_benar ? 'bg-success-50 text-success-600' : 'bg-danger-50 text-danger-600' }}">
                                {{ $j->is_benar ? '✅ Benar' : '❌ Salah' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-sm text-center font-bold {{ $j->poin_diperoleh > 0 ? 'text-success-600' : 'text-danger-500' }}">
                            {{ $j->poin_diperoleh > 0 ? '+' : '' }}{{ $j->poin_diperoleh }}
                        </td>
                        <td class="px-5 py-3 text-sm text-center text-gray-500">{{ $j->waktu_jawab ? $j->waktu_jawab . 's' : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-gray-400">Tidak ada data jawaban.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
