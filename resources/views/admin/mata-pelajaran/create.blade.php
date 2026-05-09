@extends('layouts.app')
@section('title', isset($mataPelajaran) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran')
@section('page-title', isset($mataPelajaran) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        @if($errors->any())<div class="bg-danger-50 text-danger-600 rounded-xl p-4 mb-6 text-sm"><ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ isset($mataPelajaran) ? route('admin.mata-pelajaran.update', $mataPelajaran) : route('admin.mata-pelajaran.store') }}" class="space-y-4">
            @csrf @if(isset($mataPelajaran)) @method('PUT') @endif
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label><input name="nama" value="{{ old('nama', $mataPelajaran->nama ?? '') }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500"></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Kode</label><input name="kode" value="{{ old('kode', $mataPelajaran->kode ?? '') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm"></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Warna</label><input type="color" name="warna" value="{{ old('warna', $mataPelajaran->warna ?? '#3b82f6') }}" class="w-20 h-10 border border-gray-200 rounded-xl cursor-pointer"></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label><textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm">{{ old('deskripsi', $mataPelajaran->deskripsi ?? '') }}</textarea></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Status</label><select name="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm"><option value="aktif" {{ old('status', $mataPelajaran->status ?? 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option><option value="nonaktif" {{ old('status', $mataPelajaran->status ?? '') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option></select></div>
            <div class="flex gap-3 pt-2"><button type="submit" class="bg-primary-500 text-white font-bold px-6 py-2.5 rounded-xl hover:bg-primary-600">Simpan</button><a href="{{ route('admin.mata-pelajaran.index') }}" class="bg-gray-100 text-gray-600 font-semibold px-6 py-2.5 rounded-xl hover:bg-gray-200">Batal</a></div>
        </form>
    </div>
</div>
@endsection
