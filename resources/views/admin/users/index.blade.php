@extends('layouts.app')
@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <form class="flex gap-2" method="GET">
            <input name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 w-60">
            <select name="role" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                <option value="">Semua Role</option>
                @foreach(['admin','guru','siswa'] as $r)
                <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
            <button class="bg-primary-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-primary-600">Filter</button>
        </form>
        <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold px-5 py-2.5 rounded-xl hover:shadow-lg transition-all text-sm">+ Tambah</a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr><th class="px-5 py-3 text-left font-semibold">Nama</th><th class="px-5 py-3 text-left font-semibold">Email</th><th class="px-5 py-3 text-left font-semibold">Role</th><th class="px-5 py-3 text-left font-semibold">Status</th><th class="px-5 py-3 text-right font-semibold">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $u)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-semibold">{{ $u->name }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $u->email }}</td>
                    <td class="px-5 py-3"><span class="px-2 py-1 text-xs font-bold rounded-full {{ $u->role === 'admin' ? 'bg-purple-100 text-purple-700' : ($u->role === 'guru' ? 'bg-primary-100 text-primary-700' : 'bg-success-50 text-success-600') }}">{{ ucfirst($u->role) }}</span></td>
                    <td class="px-5 py-3"><span class="px-2 py-1 text-xs font-bold rounded-full {{ $u->status === 'aktif' ? 'bg-success-50 text-success-600' : 'bg-gray-100 text-gray-500' }}">{{ ucfirst($u->status) }}</span></td>
                    <td class="px-5 py-3 text-right space-x-2">
                        <a href="{{ route('admin.users.edit', $u) }}" class="text-primary-600 hover:underline text-xs font-semibold">Edit</a>
                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengguna ini?')">@csrf @method('DELETE')<button class="text-danger-500 hover:underline text-xs font-semibold">Hapus</button></form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
