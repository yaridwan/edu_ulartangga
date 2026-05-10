@extends('layouts.guest')
@section('title', 'Daftar — Edu Ular Tangga')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 via-white to-success-50 px-4 py-12">
    <div class="w-full max-w-md relative animate-slide-up">
        <div class="text-center mb-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 mb-4">
                @if(\App\Models\PengaturanAplikasi::getValue('logo'))
                    <img src="{{ Storage::url(\App\Models\PengaturanAplikasi::getValue('logo')) }}" alt="Logo" class="h-16 w-auto mx-auto">
                @else
                    <span class="text-4xl">🎲</span>
                @endif
            </a>
            <h1 class="text-2xl font-extrabold text-gray-900">Daftar Akun Baru</h1>
            <p class="text-gray-500 mt-1">Bergabung dan mulai bermain!</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-8 border border-gray-100">
            @if($errors->any())
            <div class="bg-danger-50 text-danger-600 rounded-xl p-4 mb-6 text-sm font-medium">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors text-sm" placeholder="Nama lengkap">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors text-sm" placeholder="email@contoh.com">
                </div>

                <div>
                    <label for="kelas_id" class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                    <select id="kelas_id" name="kelas_id" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors text-sm">
                        <option value="">Pilih kelas</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors text-sm" placeholder="Min. 6 karakter">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors text-sm" placeholder="Ulangi password">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold py-3.5 rounded-xl hover:shadow-lg hover:shadow-primary-500/25 transition-all duration-200 hover:-translate-y-0.5">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary-600 font-semibold hover:underline">Masuk</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
