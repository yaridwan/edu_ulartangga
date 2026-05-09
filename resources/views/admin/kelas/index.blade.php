@extends('layouts.app')
@section('title', 'Manajemen Kelas')
@section('page-title', 'Manajemen Kelas')

@section('content')
<div class="space-y-4">
    <div class="flex justify-end"><a href="{{ route('admin.kelas.create') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold px-5 py-2.5 rounded-xl hover:shadow-lg text-sm">+ Tambah Kelas</a></div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50"><tr><th class="px-5 py-3 text-left font-semibold">Nama Kelas</th><th class="px-5 py-3 text-left font-semibold">Tingkat</th><th class="px-5 py-3 text-left font-semibold">Siswa</th><th class="px-5 py-3 text-left font-semibold">Status</th><th class="px-5 py-3 text-right font-semibold">Aksi</th></tr></thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($kelas as $k)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-semibold">{{ $k->nama_kelas }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $k->tingkat }}</td>
                    <td class="px-5 py-3">{{ $k->siswa_count }} siswa</td>
                    <td class="px-5 py-3"><span class="px-2 py-1 text-xs font-bold rounded-full {{ $k->status === 'aktif' ? 'bg-success-50 text-success-600' : 'bg-gray-100 text-gray-500' }}">{{ ucfirst($k->status) }}</span></td>
                    <td class="px-5 py-3 text-right space-x-2">
                        <a href="{{ route('admin.kelas.edit', $k) }}" class="text-primary-600 hover:underline text-xs font-semibold">Edit</a>
                        <form action="{{ route('admin.kelas.destroy', $k) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-danger-500 hover:underline text-xs font-semibold">Hapus</button></form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $kelas->links() }}
</div>
@endsection
