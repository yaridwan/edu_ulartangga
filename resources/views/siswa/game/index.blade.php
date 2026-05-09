@extends('layouts.app')
@section('title', 'Mulai Bermain')
@section('page-title', 'Mulai Bermain')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Paket Permainan dari Guru --}}
    @if($paketPermainan->count() > 0)
    <div>
        <div class="flex items-center gap-2 mb-4">
            <h2 class="text-xl font-extrabold text-gray-900">📦 Paket Permainan</h2>
            <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-primary-100 text-primary-700">{{ $paketPermainan->count() }}</span>
        </div>
        <p class="text-gray-500 text-sm mb-4">Pilih paket permainan yang sudah disiapkan guru</p>

        <div class="grid sm:grid-cols-2 gap-4">
            @foreach($paketPermainan as $paket)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 overflow-hidden">
                <div class="p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $paket->judul }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5">oleh {{ $paket->guru->name ?? 'Guru' }}</p>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $paket->mode === 'solo' ? 'bg-blue-50 text-blue-600' : ($paket->mode === 'komputer' ? 'bg-purple-50 text-purple-600' : 'bg-orange-50 text-orange-600') }}">
                            {{ ucfirst($paket->mode) }}
                        </span>
                    </div>

                    @if($paket->deskripsi)
                    <p class="text-sm text-gray-500 mb-3">{{ Str::limit($paket->deskripsi, 80) }}</p>
                    @endif

                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-primary-50 text-primary-600">{{ $paket->mataPelajaran->nama ?? '-' }}</span>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">{{ $paket->kelas->nama_kelas ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-center mb-4">
                        <div class="bg-gray-50 rounded-lg p-2">
                            <p class="text-sm font-black text-gray-900">{{ $paket->jumlah_soal }}</p>
                            <p class="text-[10px] text-gray-500 font-medium">Soal</p>
                        </div>
                        <div class="bg-success-50 rounded-lg p-2">
                            <p class="text-sm font-black text-success-600">+{{ $paket->poin_benar }}</p>
                            <p class="text-[10px] text-gray-500 font-medium">Benar</p>
                        </div>
                        <div class="bg-danger-50 rounded-lg p-2">
                            <p class="text-sm font-black text-danger-500">{{ $paket->poin_salah }}</p>
                            <p class="text-[10px] text-gray-500 font-medium">Salah</p>
                        </div>
                    </div>

                    <form action="{{ route('siswa.game.mulaiPaket', $paket) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold py-3 rounded-xl hover:shadow-lg hover:shadow-primary-500/25 transition-all text-sm">
                            🎮 Mulai Bermain
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="relative">
        <hr class="border-gray-200">
        <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-gray-100 px-4 text-sm font-semibold text-gray-400">atau</span>
    </div>
    @endif

    {{-- Setup Manual --}}
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="text-center mb-6">
                <div class="text-5xl mb-3">🎲</div>
                <h2 class="text-2xl font-extrabold text-gray-900">Setup Permainan</h2>
                <p class="text-gray-500 mt-1">Buat permainan sendiri dengan pengaturan manual</p>
            </div>
            <form action="{{ route('siswa.game.mulai') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mode Permainan</label>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach([['solo','🧑','Sendiri','Latihan solo'],['lokal','👥','Bersama','2-4 pemain'],['komputer','🤖','Komputer','vs Bot']] as $m)
                        <label class="cursor-pointer">
                            <input type="radio" name="mode" value="{{ $m[0] }}" class="peer hidden" {{ $loop->first ? 'checked' : '' }}>
                            <div class="peer-checked:border-primary-500 peer-checked:bg-primary-50 border-2 border-gray-200 rounded-xl p-4 text-center transition-all hover:border-primary-300">
                                <div class="text-2xl mb-1">{{ $m[1] }}</div>
                                <p class="font-bold text-sm">{{ $m[2] }}</p>
                                <p class="text-xs text-gray-500">{{ $m[3] }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mata Pelajaran</label>
                    <select name="mata_pelajaran_id" id="mata_pelajaran_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
                        <option value="">Pilih mata pelajaran</option>
                        @foreach($mapel as $mp)
                        <option value="{{ $mp->id }}">{{ $mp->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                    <select name="kelas_id" id="kelas_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
                        <option value="">Pilih kelas</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ auth()->user()->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Materi (Opsional)</label>
                    <select name="materi_id" id="materi_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
                        <option value="">-- Semua Materi (Campuran) --</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Pilih materi spesifik atau biarkan kosong untuk campuran.</p>
                </div>
                <div id="jumlah-pemain-box" style="display:none">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Pemain</label>
                    <select name="jumlah_pemain" id="jumlah_pemain" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                        <option value="1">1</option><option value="2" selected>2</option><option value="3">3</option><option value="4">4</option>
                    </select>
                </div>
                <input type="hidden" name="jumlah_pemain" value="1" id="jumlah_hidden">
                <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold py-4 rounded-xl hover:shadow-lg transition-all text-lg">
                    🎮 Mulai Permainan!
                </button>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.querySelectorAll('input[name="mode"]').forEach(r => {
    r.addEventListener('change', function(){
        const box = document.getElementById('jumlah-pemain-box');
        const hidden = document.getElementById('jumlah_hidden');
        if(this.value === 'solo') { box.style.display='none'; hidden.value='1'; hidden.disabled=false; }
        else { box.style.display='block'; hidden.disabled=true; }
    });
});

// Logic for filtering materi
const materis = @json($materi);
const mapelSelect = document.getElementById('mata_pelajaran_id');
const kelasSelect = document.getElementById('kelas_id');
const materiSelect = document.getElementById('materi_id');

function updateMateri() {
    const mapelId = mapelSelect.value;
    const kelasId = kelasSelect.value;
    
    // Clear current options
    materiSelect.innerHTML = '<option value="">-- Semua Materi (Campuran) --</option>';
    
    if (mapelId && kelasId) {
        const filtered = materis.filter(m => m.mata_pelajaran_id == mapelId && m.kelas_id == kelasId);
        filtered.forEach(m => {
            const option = document.createElement('option');
            option.value = m.id;
            option.textContent = m.judul;
            materiSelect.appendChild(option);
        });
    }
}

mapelSelect.addEventListener('change', updateMateri);
kelasSelect.addEventListener('change', updateMateri);

// Initial call in case kelas is pre-selected
updateMateri();
</script>
@endpush
@endsection
