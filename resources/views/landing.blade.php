@extends('layouts.guest')
@section('title', 'Edu Ular Tangga — Belajar Jadi Lebih Seru')
@section('description', 'Mainkan ular tangga digital, jawab soal, kumpulkan poin, dan jadilah juara kelas.')

@section('content')
{{-- Navbar --}}
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🎲</span>
                <span class="font-extrabold text-xl bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">Edu Ular Tangga</span>
            </div>
            <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">
                <a href="#fitur" class="hover:text-primary-600 transition-colors">Fitur</a>
                <a href="#cara-bermain" class="hover:text-primary-600 transition-colors">Cara Bermain</a>
                <a href="#manfaat" class="hover:text-primary-600 transition-colors">Manfaat</a>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    @php
                        $dashboardRoute = 'landing';
                        if (auth()->user()->role === 'admin') $dashboardRoute = 'admin.dashboard';
                        elseif (auth()->user()->role === 'guru') $dashboardRoute = 'guru.dashboard';
                        elseif (auth()->user()->role === 'siswa') $dashboardRoute = 'siswa.dashboard';
                    @endphp
                    <a href="{{ route($dashboardRoute) }}" class="text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg hover:shadow-primary-500/25 transition-all duration-200 hover:-translate-y-0.5">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-semibold text-danger-600 hover:text-danger-800 transition-colors px-4 py-2">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-primary-600 transition-colors px-4 py-2">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg hover:shadow-primary-500/25 transition-all duration-200 hover:-translate-y-0.5">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Hero Section --}}
<section class="relative pt-32 pb-20 px-4 overflow-hidden bg-gradient-to-br from-primary-50 via-white to-warning-50">
    <div class="absolute top-20 left-10 w-72 h-72 bg-primary-200/30 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-warning-200/30 rounded-full blur-3xl"></div>

    <div class="max-w-7xl mx-auto relative">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="animate-slide-up">
                <div class="inline-flex items-center gap-2 bg-primary-100 text-primary-700 text-sm font-semibold px-4 py-2 rounded-full mb-6">
                    <span>🎓</span> Platform Edukasi Interaktif
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 leading-tight mb-6">
                    Belajar Jadi<br>
                    <span class="bg-gradient-to-r from-primary-500 via-accent-500 to-warning-500 bg-clip-text text-transparent">Lebih Seru</span><br>
                    dengan Ular Tangga
                </h1>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-lg">
                    Mainkan ular tangga digital, jawab soal, kumpulkan poin, dan jadilah juara kelas. Belajar sambil bermain jadi menyenangkan!
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    @auth
                        <a href="{{ route($dashboardRoute) }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold px-8 py-4 rounded-2xl hover:shadow-xl hover:shadow-primary-500/25 transition-all duration-300 hover:-translate-y-1 text-lg">
                            🚀 Lanjut ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold px-8 py-4 rounded-2xl hover:shadow-xl hover:shadow-primary-500/25 transition-all duration-300 hover:-translate-y-1 text-lg">
                            🎮 Mulai Bermain
                        </a>
                    @endauth
                    <a href="#cara-bermain" class="inline-flex items-center justify-center gap-2 bg-white text-gray-700 font-semibold px-8 py-4 rounded-2xl border-2 border-gray-200 hover:border-primary-300 hover:text-primary-600 transition-all duration-200">
                        📖 Cara Bermain
                    </a>
                </div>
            </div>
            <div class="relative animate-float hidden lg:block z-10 perspective-1000">
                <div class="relative bg-[#8b4513] rounded-3xl p-3 sm:p-4 shadow-2xl border-[6px] border-[#5c2e0b] transform -rotate-2 hover:rotate-0 hover:scale-105 transition-all duration-500 max-w-md mx-auto">
                    {{-- Board Image --}}
                    <img src="{{ asset('images/bg2.jpg') }}" alt="Papan Ular Tangga" class="w-full h-auto rounded-xl shadow-inner" />
                    
                    {{-- Decorative Floating Dice (Scaled up slightly) --}}
                    <div class="absolute -bottom-8 -right-8 w-20 h-20 rounded-xl shadow-[0_10px_25px_rgba(0,0,0,0.4)] animate-bounce" style="background-image: url('{{ asset('images/dice.webp') }}'); background-size: 633px; background-position: 608px 176px; transform: rotate(15deg); animation-duration: 3s;"></div>
                    
                    {{-- Decorative Floating Piece (Green) --}}
                    <div class="absolute -top-6 -left-6 w-16 h-16 rounded-full shadow-[0_10px_20px_rgba(0,0,0,0.4)]" style="background-image: url('{{ asset('images/pieces.jpg') }}'); background-size: 243px 150px; background-position: -87px -87px; border: 4px solid white; transform: rotate(-10deg); animation: float-slow 4s infinite ease-in-out;"></div>
                </div>
                
                {{-- Glow background effect behind the board --}}
                <div class="absolute -z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-to-tr from-primary-400 to-warning-400 opacity-40 blur-3xl rounded-full scale-125"></div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes float-slow {
    0%, 100% { transform: translateY(0) rotate(-10deg); }
    50% { transform: translateY(-15px) rotate(-5deg); }
}
</style>

{{-- Fitur Section --}}
<section id="fitur" class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">Fitur Unggulan</h2>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">Edu Ular Tangga hadir dengan fitur lengkap untuk pengalaman belajar yang menyenangkan</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $fitur = [
                    ['icon' => '🎲', 'title' => 'Dadu Digital', 'desc' => 'Lempar dadu dengan animasi 3D yang menarik. Setiap lemparan menentukan langkahmu!', 'color' => 'primary'],
                    ['icon' => '📝', 'title' => 'Bank Soal', 'desc' => 'Ribuan soal dari berbagai mata pelajaran dan tingkat kesulitan.', 'color' => 'success'],
                    ['icon' => '🏆', 'title' => 'Leaderboard', 'desc' => 'Bersaing dengan teman sekelas dan lihat siapa juara!', 'color' => 'warning'],
                    ['icon' => '📊', 'title' => 'Laporan Lengkap', 'desc' => 'Pantau perkembangan belajar dengan laporan detail.', 'color' => 'danger'],
                    ['icon' => '🎮', 'title' => '3 Mode Bermain', 'desc' => 'Bermain sendiri, bersama teman, atau melawan komputer.', 'color' => 'accent'],
                    ['icon' => '🎯', 'title' => 'Skor & Poin', 'desc' => 'Kumpulkan poin dari setiap jawaban benar dan raih prestasi.', 'color' => 'primary'],
                ];
            @endphp
            @foreach($fitur as $f)
            <div class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-{{ $f['color'] }}-200 hover:shadow-xl hover:shadow-{{ $f['color'] }}-100/50 transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 bg-{{ $f['color'] }}-100 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                    {{ $f['icon'] }}
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $f['title'] }}</h3>
                <p class="text-gray-500 leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Cara Bermain --}}
<section id="cara-bermain" class="py-20 px-4 bg-gradient-to-br from-primary-50 to-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">Cara Bermain</h2>
            <p class="text-lg text-gray-500">Mudah dan menyenangkan — ikuti langkah berikut</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $steps = [
                    ['num' => '1', 'icon' => '🔐', 'title' => 'Daftar & Login', 'desc' => 'Buat akun dan masuk ke dashboard siswa.'],
                    ['num' => '2', 'icon' => '📚', 'title' => 'Pilih Mata Pelajaran', 'desc' => 'Pilih mata pelajaran dan kelas yang ingin dipelajari.'],
                    ['num' => '3', 'icon' => '🎲', 'title' => 'Lempar Dadu', 'desc' => 'Lempar dadu, gerakkan pion, dan jawab soal yang muncul.'],
                    ['num' => '4', 'icon' => '🏅', 'title' => 'Jadi Juara!', 'desc' => 'Kumpulkan poin dan capai garis finish untuk menang.'],
                ];
            @endphp
            @foreach($steps as $step)
            <div class="relative text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center text-white text-2xl font-black mx-auto mb-4 shadow-lg shadow-primary-500/25">
                    {{ $step['num'] }}
                </div>
                <div class="text-3xl mb-3">{{ $step['icon'] }}</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                <p class="text-gray-500 text-sm">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Manfaat --}}
<section id="manfaat" class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-6">Mengapa Edu Ular Tangga?</h2>
                <div class="space-y-5">
                    @php
                        $benefits = [
                            ['icon' => '✨', 'title' => 'Belajar Sambil Bermain', 'desc' => 'Siswa tidak merasa sedang belajar karena dikemas dalam permainan.'],
                            ['icon' => '📈', 'title' => 'Meningkatkan Motivasi', 'desc' => 'Sistem skor dan leaderboard membuat siswa ingin terus bermain dan belajar.'],
                            ['icon' => '🧠', 'title' => 'Memperkuat Pemahaman', 'desc' => 'Pembahasan di setiap soal membantu siswa memahami materi lebih baik.'],
                            ['icon' => '👩‍🏫', 'title' => 'Membantu Guru', 'desc' => 'Guru dapat membuat soal dan memantau perkembangan siswa dengan mudah.'],
                        ];
                    @endphp
                    @foreach($benefits as $b)
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 bg-success-50 rounded-xl flex items-center justify-center text-lg shrink-0">{{ $b['icon'] }}</div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1">{{ $b['title'] }}</h3>
                            <p class="text-gray-500 text-sm">{{ $b['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-gradient-to-br from-success-50 to-primary-50 rounded-3xl p-10 text-center">
                <div class="text-6xl mb-4">🎓</div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-2xl p-5 shadow-sm">
                        <div class="text-3xl font-black text-primary-600">100+</div>
                        <div class="text-sm text-gray-500">Kotak Permainan</div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm">
                        <div class="text-3xl font-black text-success-600">6</div>
                        <div class="text-sm text-gray-500">Mata Pelajaran</div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm">
                        <div class="text-3xl font-black text-warning-600">3</div>
                        <div class="text-sm text-gray-500">Mode Bermain</div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm">
                        <div class="text-3xl font-black text-danger-500">∞</div>
                        <div class="text-sm text-gray-500">Keseruan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 px-4 bg-gradient-to-r from-primary-600 to-primary-800">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">Siap Bermain dan Belajar?</h2>
        <p class="text-lg text-primary-200 mb-8">Daftar sekarang dan jadilah juara kelas!</p>
        @auth
            <a href="{{ route($dashboardRoute) }}" class="inline-flex items-center gap-2 bg-white text-primary-700 font-bold px-8 py-4 rounded-2xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 text-lg">
                🚀 Lanjut ke Dashboard
            </a>
        @else
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-primary-700 font-bold px-8 py-4 rounded-2xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 text-lg">
                🚀 Daftar Gratis
            </a>
        @endauth
    </div>
</section>

{{-- Footer --}}
<footer class="bg-gray-900 text-gray-400 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xl">🎲</span>
                <span class="font-bold text-white">Edu Ular Tangga</span>
            </div>
            <p class="text-sm">© {{ date('Y') }} Edu Ular Tangga. Game Edukatif untuk Sekolah Indonesia.</p>
        </div>
    </div>
</footer>
@endsection
