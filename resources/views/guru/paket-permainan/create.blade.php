@extends('layouts.app')
@section('title', isset($paketPermainan) ? 'Edit Paket Permainan' : 'Buat Paket Permainan')
@section('page-title', isset($paketPermainan) ? 'Edit Paket Permainan' : 'Buat Paket Permainan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        @if($errors->any())
        <div class="bg-danger-50 text-danger-600 rounded-xl p-4 mb-6 text-sm">
            <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="{{ isset($paketPermainan) ? route('guru.paket-permainan.update', $paketPermainan) : route('guru.paket-permainan.store') }}" class="space-y-5">
            @csrf
            @if(isset($paketPermainan)) @method('PUT') @endif

            {{-- Judul --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Paket</label>
                <input name="judul" value="{{ old('judul', $paketPermainan->judul ?? '') }}" required placeholder="Contoh: Petualangan Pecahan Kelas IV" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="2" placeholder="Deskripsi singkat tentang paket permainan ini" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">{{ old('deskripsi', $paketPermainan->deskripsi ?? '') }}</textarea>
            </div>

            {{-- Mapel & Kelas --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Mata Pelajaran</label>
                    <select name="mata_pelajaran_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                        <option value="">Pilih</option>
                        @foreach($mapel as $m)
                        <option value="{{ $m->id }}" {{ old('mata_pelajaran_id', $paketPermainan->mata_pelajaran_id ?? '') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>
                    <select name="kelas_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                        <option value="">Pilih</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id', $paketPermainan->kelas_id ?? '') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Mode & Pemain --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Mode Permainan</label>
                    <select name="mode" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                        @foreach(['solo'=>'Solo (Sendiri)', 'lokal'=>'Lokal (Bersama)', 'komputer'=>'vs Komputer'] as $v => $l)
                        <option value="{{ $v }}" {{ old('mode', $paketPermainan->mode ?? 'solo') === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Maks Pemain</label>
                    <select name="maks_pemain" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                        @for($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" {{ old('maks_pemain', $paketPermainan->maks_pemain ?? 4) == $i ? 'selected' : '' }}>{{ $i }} Pemain</option>
                        @endfor
                    </select>
                </div>
            </div>

            {{-- Pengaturan Soal --}}
            <div class="border-t border-gray-100 pt-5">
                <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">📝 Pengaturan Soal</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Soal</label>
                        <input type="number" name="jumlah_soal" value="{{ old('jumlah_soal', $paketPermainan->jumlah_soal ?? 20) }}" min="1" max="100" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu Jawab (detik)</label>
                        <input type="number" name="waktu_jawab" value="{{ old('waktu_jawab', $paketPermainan->waktu_jawab ?? '') }}" min="5" max="300" placeholder="Kosongkan = tanpa batas" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>
            </div>

            {{-- Pengaturan Skor --}}
            <div class="border-t border-gray-100 pt-5">
                <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">⭐ Pengaturan Skor</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Poin Jawaban Benar</label>
                        <input type="number" name="poin_benar" value="{{ old('poin_benar', $paketPermainan->poin_benar ?? 10) }}" min="1" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Poin Jawaban Salah</label>
                        <input type="number" name="poin_salah" value="{{ old('poin_salah', $paketPermainan->poin_salah ?? -5) }}" max="0" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                        <p class="text-xs text-gray-400 mt-1">Gunakan angka negatif, misalnya -5</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Bonus Langkah (benar)</label>
                        <input type="number" name="bonus_langkah" value="{{ old('bonus_langkah', $paketPermainan->bonus_langkah ?? 0) }}" min="0" max="10" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                        <p class="text-xs text-gray-400 mt-1">Langkah tambahan jika jawaban benar</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Penalti Langkah (salah)</label>
                        <input type="number" name="penalti_langkah" value="{{ old('penalti_langkah', $paketPermainan->penalti_langkah ?? 0) }}" min="0" max="10" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                        <p class="text-xs text-gray-400 mt-1">Langkah mundur jika jawaban salah</p>
                    </div>
                </div>
            </div>

            {{-- Opsi Tambahan --}}
            <div class="border-t border-gray-100 pt-5">
                <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">⚙️ Opsi Tambahan</h3>
                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="tampilkan_pembahasan" value="0">
                        <input type="checkbox" name="tampilkan_pembahasan" value="1" {{ old('tampilkan_pembahasan', $paketPermainan->tampilkan_pembahasan ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-primary-500 focus:ring-primary-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Tampilkan Pembahasan</p>
                            <p class="text-xs text-gray-400">Tampilkan penjelasan setelah siswa menjawab</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="acak_soal" value="0">
                        <input type="checkbox" name="acak_soal" value="1" {{ old('acak_soal', $paketPermainan->acak_soal ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-primary-500 focus:ring-primary-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Acak Soal</p>
                            <p class="text-xs text-gray-400">Soal muncul secara acak pada setiap permainan</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Status (edit only) --}}
            @if(isset($paketPermainan))
            <div class="border-t border-gray-100 pt-5">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                    <option value="aktif" {{ $paketPermainan->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $paketPermainan->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            @endif

            {{-- Submit --}}
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold px-6 py-2.5 rounded-xl hover:shadow-lg hover:shadow-primary-500/25 transition-all hover:-translate-y-0.5">
                    💾 {{ isset($paketPermainan) ? 'Simpan Perubahan' : 'Buat Paket' }}
                </button>
                <a href="{{ route('guru.paket-permainan.index') }}" class="bg-gray-100 text-gray-600 font-semibold px-6 py-2.5 rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
