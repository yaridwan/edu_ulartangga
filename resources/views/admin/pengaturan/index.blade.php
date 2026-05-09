@extends('layouts.app')
@section('title', 'Pengaturan Aplikasi')
@section('page-title', 'Pengaturan Aplikasi')

@section('content')
<form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf @method('PUT')

    @foreach($pengaturan as $group => $items)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-900 capitalize">{{ $group === 'umum' ? '⚙️ Umum' : ($group === 'game' ? '🎮 Aturan Game' : ($group === 'audio' ? '🔊 Audio' : '🎲 Papan')) }}</h3>
        </div>
        <div class="p-5 grid sm:grid-cols-2 gap-4">
            @foreach($items as $item)
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">{{ str_replace('_', ' ', ucfirst($item->key)) }}</label>
                @if($item->type === 'boolean')
                <select name="{{ $item->key }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                    <option value="1" {{ $item->value ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ !$item->value ? 'selected' : '' }}>Tidak</option>
                </select>
                @elseif($item->type === 'image')
                <input type="file" name="{{ $item->key }}" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                @elseif($item->type === 'number')
                <input type="number" name="{{ $item->key }}" value="{{ $item->value }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                @else
                <input type="text" name="{{ $item->key }}" value="{{ $item->value }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <button type="submit" class="bg-primary-500 text-white font-bold px-8 py-3 rounded-xl hover:bg-primary-600 transition-colors">💾 Simpan Pengaturan</button>
</form>
@endsection
