@extends('layouts.app')
@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        @if($errors->any())
        <div class="bg-danger-50 text-danger-600 rounded-xl p-4 mb-6 text-sm">
            <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
            @csrf @method('PUT')
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label><input name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500"></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500"></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Password (kosongkan jika tidak diubah)</label><input type="password" name="password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500"></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Role</label><select name="role" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm">@foreach(['siswa','guru','admin'] as $r)<option value="{{ $r }}" {{ $user->role === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label><select name="kelas_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm"><option value="">-</option>@foreach($kelas as $k)<option value="{{ $k->id }}" {{ $user->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Status</label><select name="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm"><option value="aktif" {{ $user->status === 'aktif' ? 'selected' : '' }}>Aktif</option><option value="nonaktif" {{ $user->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option></select></div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-primary-500 text-white font-bold px-6 py-2.5 rounded-xl hover:bg-primary-600">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-100 text-gray-600 font-semibold px-6 py-2.5 rounded-xl hover:bg-gray-200">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
