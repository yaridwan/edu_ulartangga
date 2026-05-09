@extends('layouts.app')
@section('title', isset($soal) ? 'Edit Soal' : 'Tambah Soal')
@section('page-title', isset($soal) ? 'Edit Soal' : 'Tambah Soal')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        @if($errors->any())
        <div class="bg-danger-50 text-danger-600 rounded-xl p-4 mb-6 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ isset($soal) ? route('guru.soal.update', $soal) : route('guru.soal.store') }}" class="space-y-5" id="soal-form">
            @csrf
            @if(isset($soal)) @method('PUT') @endif

            {{-- Mata Pelajaran & Kelas --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Mata Pelajaran</label>
                    <select name="mata_pelajaran_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                        <option value="">Pilih</option>
                        @foreach($mapel as $m)
                        <option value="{{ $m->id }}" {{ old('mata_pelajaran_id', $soal->mata_pelajaran_id ?? '') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>
                    <select name="kelas_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                        <option value="">Pilih</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id', $soal->kelas_id ?? '') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Jenis Soal, Kesulitan, Poin --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Soal</label>
                    <select name="jenis_soal" id="jenis-soal" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                        @foreach(['pilihan_ganda'=>'Pilihan Ganda','benar_salah'=>'Benar/Salah','isian'=>'Isian'] as $v => $l)
                        <option value="{{ $v }}" {{ old('jenis_soal', $soal->jenis_soal ?? 'pilihan_ganda') === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kesulitan</label>
                    <select name="tingkat_kesulitan" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                        @foreach(['mudah','sedang','sulit'] as $t)
                        <option value="{{ $t }}" {{ old('tingkat_kesulitan', $soal->tingkat_kesulitan ?? 'mudah') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Poin</label>
                    <input type="number" name="poin" value="{{ old('poin', $soal->poin ?? 10) }}" min="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                </div>
            </div>

            {{-- Pertanyaan --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Pertanyaan</label>
                <textarea name="pertanyaan" rows="3" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">{{ old('pertanyaan', $soal->pertanyaan ?? '') }}</textarea>
            </div>

            {{-- ============================================ --}}
            {{-- PILIHAN GANDA: 4 opsi A/B/C/D --}}
            {{-- ============================================ --}}
            <div id="section-pilihan-ganda" class="space-y-3">
                <label class="block text-sm font-semibold text-gray-700">Pilihan Jawaban</label>
                @php $pilihanList = isset($soal) ? $soal->pilihanJawaban : collect(); @endphp
                @foreach(['A','B','C','D'] as $i => $label)
                <div class="flex gap-2 items-center">
                    <input type="hidden" name="pilihan[{{ $i }}][label]" value="{{ $label }}">
                    <span class="w-9 h-10 bg-primary-100 rounded-lg flex items-center justify-center text-sm font-bold text-primary-700 shrink-0">{{ $label }}</span>
                    <input name="pilihan[{{ $i }}][isi_pilihan]" value="{{ old("pilihan.{$i}.isi_pilihan", $pilihanList[$i]->isi_pilihan ?? '') }}" placeholder="Isi pilihan {{ $label }}" class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                </div>
                @endforeach

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1 mt-3">Kunci Jawaban</label>
                    <select name="kunci_jawaban" id="kunci-pg" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                        @foreach(['A','B','C','D'] as $label)
                        <option value="{{ $label }}" {{ old('kunci_jawaban', $soal->kunci_jawaban ?? '') === $label ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Pilih huruf jawaban yang benar</p>
                </div>
            </div>

            {{-- ============================================ --}}
            {{-- BENAR/SALAH --}}
            {{-- ============================================ --}}
            <div id="section-benar-salah" class="space-y-3 hidden">
                <label class="block text-sm font-semibold text-gray-700">Kunci Jawaban</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="kunci_jawaban_bs" value="Benar" class="peer hidden" {{ old('kunci_jawaban', $soal->kunci_jawaban ?? '') === 'Benar' ? 'checked' : '' }}>
                        <div class="peer-checked:border-success-500 peer-checked:bg-success-50 border-2 border-gray-200 rounded-xl p-4 text-center transition-all hover:border-success-300">
                            <div class="text-2xl mb-1">✅</div>
                            <p class="font-bold text-sm">Benar</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="kunci_jawaban_bs" value="Salah" class="peer hidden" {{ old('kunci_jawaban', $soal->kunci_jawaban ?? '') === 'Salah' ? 'checked' : '' }}>
                        <div class="peer-checked:border-danger-500 peer-checked:bg-danger-50 border-2 border-gray-200 rounded-xl p-4 text-center transition-all hover:border-danger-300">
                            <div class="text-2xl mb-1">❌</div>
                            <p class="font-bold text-sm">Salah</p>
                        </div>
                    </label>
                </div>
                <p class="text-xs text-gray-400">Pilih jawaban yang benar untuk pertanyaan di atas</p>
            </div>

            {{-- ============================================ --}}
            {{-- ISIAN --}}
            {{-- ============================================ --}}
            <div id="section-isian" class="space-y-3 hidden">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kunci Jawaban</label>
                    <input type="text" name="kunci_jawaban_isian" id="kunci-isian" value="{{ old('kunci_jawaban', ($soal->jenis_soal ?? '') === 'isian' ? ($soal->kunci_jawaban ?? '') : '') }}" placeholder="Ketik jawaban yang benar" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                    <p class="text-xs text-gray-400 mt-1">Jawaban siswa akan dicocokkan dengan teks ini (tidak case-sensitive)</p>
                </div>
            </div>

            {{-- Hidden real kunci_jawaban field (populated by JS before submit) --}}
            <input type="hidden" name="kunci_jawaban" id="kunci-jawaban-final" value="{{ old('kunci_jawaban', $soal->kunci_jawaban ?? 'A') }}">

            {{-- Pembahasan --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Pembahasan</label>
                <textarea name="pembahasan" rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500" placeholder="Tuliskan penjelasan jawaban yang benar (opsional)">{{ old('pembahasan', $soal->pembahasan ?? '') }}</textarea>
            </div>

            {{-- Status (edit mode only) --}}
            @if(isset($soal))
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                    <option value="aktif" {{ $soal->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $soal->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            @endif

            {{-- Submit --}}
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold px-6 py-2.5 rounded-xl hover:shadow-lg hover:shadow-primary-500/25 transition-all hover:-translate-y-0.5">
                    💾 Simpan
                </button>
                <a href="{{ route('guru.soal.index') }}" class="bg-gray-100 text-gray-600 font-semibold px-6 py-2.5 rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function() {
    const jenisSoal = document.getElementById('jenis-soal');
    const sectionPG = document.getElementById('section-pilihan-ganda');
    const sectionBS = document.getElementById('section-benar-salah');
    const sectionIsian = document.getElementById('section-isian');
    const kunciFinal = document.getElementById('kunci-jawaban-final');

    function toggleSections() {
        const value = jenisSoal.value;

        // Hide all
        sectionPG.classList.add('hidden');
        sectionBS.classList.add('hidden');
        sectionIsian.classList.add('hidden');

        // Disable inputs in hidden sections so they don't submit
        sectionPG.querySelectorAll('input, select').forEach(el => el.disabled = true);
        sectionBS.querySelectorAll('input').forEach(el => el.disabled = true);
        sectionIsian.querySelectorAll('input').forEach(el => el.disabled = true);

        // Show & enable the active section
        if (value === 'pilihan_ganda') {
            sectionPG.classList.remove('hidden');
            sectionPG.querySelectorAll('input, select').forEach(el => el.disabled = false);
        } else if (value === 'benar_salah') {
            sectionBS.classList.remove('hidden');
            sectionBS.querySelectorAll('input').forEach(el => el.disabled = false);
        } else if (value === 'isian') {
            sectionIsian.classList.remove('hidden');
            sectionIsian.querySelectorAll('input').forEach(el => el.disabled = false);
        }
    }

    // Sync the correct kunci_jawaban value before form submit
    document.getElementById('soal-form').addEventListener('submit', function() {
        const value = jenisSoal.value;

        if (value === 'pilihan_ganda') {
            kunciFinal.value = document.getElementById('kunci-pg').value;
        } else if (value === 'benar_salah') {
            const checked = document.querySelector('input[name="kunci_jawaban_bs"]:checked');
            kunciFinal.value = checked ? checked.value : '';
        } else if (value === 'isian') {
            kunciFinal.value = document.getElementById('kunci-isian').value;
        }
    });

    // Listen for changes
    jenisSoal.addEventListener('change', toggleSections);

    // Initialize on load
    toggleSections();
})();
</script>
@endpush
@endsection
