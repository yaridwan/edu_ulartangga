@extends('layouts.app')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        @if($errors->any())
        <div class="bg-danger-50 text-danger-600 rounded-xl p-4 mb-6 text-sm">
            <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label><input name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500"></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Email</label><input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500"></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Password</label><input type="password" name="password" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500"></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Role</label><select name="role" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm"><option value="siswa">Siswa</option><option value="guru">Guru</option><option value="admin">Admin</option></select></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Kelas (untuk Siswa)</label><select name="kelas_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm"><option value="">-</option>@foreach($kelas as $k)<option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Status</label><select name="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm"><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option></select></div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-primary-500 text-white font-bold px-6 py-2.5 rounded-xl hover:bg-primary-600 transition-colors">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-100 text-gray-600 font-semibold px-6 py-2.5 rounded-xl hover:bg-gray-200">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
