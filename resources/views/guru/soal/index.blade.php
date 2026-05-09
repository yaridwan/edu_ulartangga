@extends('layouts.app')
@section('title', 'Bank Soal')
@section('page-title', 'Bank Soal')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <form class="flex gap-2" method="GET">
            <select name="mata_pelajaran_id" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm"><option value="">Semua Mapel</option>@foreach($mapel as $m)<option value="{{ $m->id }}" {{ request('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>@endforeach</select>
            <select name="kelas_id" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm"><option value="">Semua Kelas</option>@foreach($kelas as $k)<option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>@endforeach</select>
            <select name="tingkat_kesulitan" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm"><option value="">Semua Level</option>@foreach(['mudah','sedang','sulit'] as $t)<option value="{{ $t }}" {{ request('tingkat_kesulitan') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>@endforeach</select>
            <button class="bg-primary-500 text-white px-4 py-2 rounded-xl text-sm font-semibold">Filter</button>
        </form>
        <div class="flex gap-2">
            <button onclick="document.getElementById('import-modal').classList.remove('hidden')" class="bg-white border border-gray-200 text-gray-700 font-bold px-4 py-2.5 rounded-xl text-sm hover:bg-gray-50 flex items-center gap-2">
                📊 Import Excel
            </button>
            <a href="{{ route('guru.soal.create') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold px-5 py-2.5 rounded-xl text-sm flex items-center gap-2">
                + Tambah Soal
            </a>
        </div>
    </div>
    <div class="space-y-3">
        @forelse($soal as $s)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <p class="font-semibold text-gray-900 mb-1">{{ Str::limit($s->pertanyaan, 100) }}</p>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="bg-primary-50 text-primary-700 px-2 py-0.5 rounded-full font-medium">{{ $s->mataPelajaran->nama }}</span>
                        <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $s->kelas->nama_kelas }}</span>
                        <span class="px-2 py-0.5 rounded-full font-medium {{ $s->tingkat_kesulitan === 'mudah' ? 'bg-success-50 text-success-600' : ($s->tingkat_kesulitan === 'sedang' ? 'bg-warning-50 text-warning-600' : 'bg-danger-50 text-danger-600') }}">{{ ucfirst($s->tingkat_kesulitan) }}</span>
                        <span class="bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">{{ $s->poin }} poin</span>
                    </div>
                </div>
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('guru.soal.edit', $s) }}" class="text-primary-600 text-xs font-semibold hover:underline">Edit</a>
                    <form action="{{ route('guru.soal.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">@csrf @method('DELETE')<button class="text-danger-500 text-xs font-semibold hover:underline">Hapus</button></form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-400"><p class="text-lg mb-2">📝</p><p>Belum ada soal. <a href="{{ route('guru.soal.create') }}" class="text-primary-600 hover:underline">Buat soal pertama!</a></p></div>
        @endforelse
    </div>
    {{ $soal->links() }}
</div>

{{-- Import Modal --}}
<div id="import-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 animate-slide-up overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-900">Import Soal via Excel</h3>
            <button onclick="document.getElementById('import-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <form action="{{ route('guru.soal.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Mata Pelajaran</label>
                <select name="mata_pelajaran_id" required class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($mapel as $m)
                        <option value="{{ $m->id }}">{{ $m->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                <select name="kelas_id" required class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">File Excel/CSV</label>
                <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                <p class="text-xs text-gray-500 mt-2">Format kolom baris pertama (header): <b>pertanyaan, jenis_soal, tingkat_kesulitan, kunci_jawaban, pembahasan, poin, pilihan_a, pilihan_b, pilihan_c, pilihan_d, pilihan_e</b>.</p>
            </div>
            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-primary-500 text-white font-bold px-5 py-2.5 rounded-xl text-sm hover:bg-primary-600 w-full">
                    Mulai Import
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
