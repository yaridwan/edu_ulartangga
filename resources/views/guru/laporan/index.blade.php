@extends('layouts.app')
@section('title', 'Laporan Hasil Belajar')
@section('page-title', 'Laporan Hasil Belajar')

@section('content')
<div class="space-y-6">
    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center text-xl">🎮</div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $stats['total_permainan'] }}</p>
                    <p class="text-xs text-gray-500 font-medium">Permainan Selesai</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-xl">📝</div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $stats['total_jawaban'] }}</p>
                    <p class="text-xs text-gray-500 font-medium">Total Jawaban</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-success-50 rounded-xl flex items-center justify-center text-xl">✅</div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $stats['jawaban_benar'] }}</p>
                    <p class="text-xs text-gray-500 font-medium">Jawaban Benar</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-warning-50 rounded-xl flex items-center justify-center text-xl">📊</div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $stats['persentase_benar'] }}%</p>
                    <p class="text-xs text-gray-500 font-medium">Persentase Benar</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
        <form class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Mata Pelajaran</label>
                <select name="mata_pelajaran_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                    <option value="">Semua</option>
                    @foreach($mapel as $m)
                    <option value="{{ $m->id }}" {{ request('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Kelas</label>
                <select name="kelas_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                    <option value="">Semua</option>
                    @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-primary-500 text-white font-semibold px-5 py-2 rounded-lg hover:bg-primary-600 text-sm">Filter</button>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kode</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mapel</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kelas</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Pemain</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Durasi</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($permainan as $p)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-4 text-sm font-mono font-semibold text-gray-900">{{ $p->kode_permainan }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600">{{ $p->mataPelajaran->nama ?? '-' }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600">{{ $p->kelas->nama_kelas ?? '-' }}</td>
                    <td class="px-5 py-4 text-center text-sm font-semibold">{{ $p->pemain->count() }}</td>
                    <td class="px-5 py-4 text-center text-sm text-gray-500">{{ $p->dimulai_pada?->format('d M Y H:i') ?? '-' }}</td>
                    <td class="px-5 py-4 text-center text-sm text-gray-500">
                        @if($p->dimulai_pada && $p->selesai_pada)
                            {{ $p->dimulai_pada->diffForHumans($p->selesai_pada, ['parts' => 1, 'short' => true]) }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-5 py-4 text-center">
                        <a href="{{ route('guru.laporan.show', $p) }}" class="text-primary-600 hover:text-primary-800 text-sm font-semibold">Detail →</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                        <div class="text-4xl mb-2">📋</div>
                        <p class="font-semibold">Belum ada data laporan</p>
                        <p class="text-sm mt-1">Laporan akan muncul setelah siswa menyelesaikan permainan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($permainan->hasPages())
        <div class="px-5 py-3 border-t border-gray-100">
            {{ $permainan->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
