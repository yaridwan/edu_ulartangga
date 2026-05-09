@extends('layouts.app')
@section('title', 'Profil & Gamifikasi')
@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Status Card --}}
    <div class="bg-gradient-to-br from-primary-500 to-primary-700 rounded-3xl p-8 text-white shadow-xl shadow-primary-500/30 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/10 rounded-full blur-3xl -ml-20 -mb-20"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
            <div class="shrink-0 relative group">
                <div class="w-32 h-32 rounded-full border-4 border-white/50 bg-white shadow-inner overflow-hidden flex items-center justify-center p-2">
                    <img src="{{ $user->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed='.$user->name.'&backgroundColor=b6e3f4' }}" alt="Avatar" class="w-full h-full object-contain">
                </div>
                <div class="absolute -bottom-3 -right-3 bg-warning-400 text-white w-12 h-12 rounded-full flex items-center justify-center font-black text-xl border-4 border-primary-600 shadow-lg" title="Level Anda">
                    {{ $user->level }}
                </div>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-3xl font-black mb-1 drop-shadow-sm">{{ $user->name }}</h2>
                <p class="text-primary-100 font-medium mb-4">{{ $user->kelas->nama_kelas }} • Siswa Edu Ular Tangga</p>
                
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                    <div class="bg-black/20 backdrop-blur rounded-2xl px-5 py-3 flex items-center gap-3">
                        <span class="text-2xl drop-shadow-md">⭐</span>
                        <div>
                            <p class="text-xs text-primary-200 font-semibold uppercase tracking-wider">Bintang</p>
                            <p class="text-2xl font-bold">{{ number_format($user->bintang) }}</p>
                        </div>
                    </div>
                    <div class="bg-black/20 backdrop-blur rounded-2xl px-5 py-3 flex items-center gap-3">
                        <span class="text-2xl drop-shadow-md">🎮</span>
                        <div>
                            <p class="text-xs text-primary-200 font-semibold uppercase tracking-wider">Game Dimainkan</p>
                            <p class="text-2xl font-bold">{{ $user->pemainPermainan()->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Avatar Selection --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold text-gray-900 mb-2">Pilih Avatar Baru</h3>
        <p class="text-gray-500 text-sm mb-6">Pilih karakter favoritmu untuk ditampilkan di papan permainan dan papan peringkat!</p>
        
        <form action="{{ route('siswa.profile.avatar') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-6">
                @foreach($avatars as $avatar)
                <label class="cursor-pointer group relative">
                    <input type="radio" name="avatar" value="{{ $avatar }}" class="peer sr-only" {{ $user->avatar === $avatar ? 'checked' : '' }}>
                    <div class="rounded-2xl border-2 border-gray-100 p-4 transition-all duration-200 peer-checked:border-primary-500 peer-checked:bg-primary-50 peer-checked:shadow-md group-hover:border-primary-300">
                        <img src="{{ $avatar }}" class="w-full aspect-square object-contain mx-auto transition-transform duration-300 group-hover:scale-110">
                        <div class="absolute top-2 right-2 w-6 h-6 bg-primary-500 text-white rounded-full flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity scale-0 peer-checked:scale-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
            <div class="flex justify-end border-t border-gray-100 pt-6">
                <button type="submit" class="bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold px-8 py-3.5 rounded-xl hover:shadow-lg hover:shadow-primary-500/25 transition-all transform hover:-translate-y-0.5">
                    💾 Simpan Avatar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
