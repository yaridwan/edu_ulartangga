<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Edu Ular Tangga')</title>
    <meta name="description" content="@yield('description', 'Belajar Jadi Lebih Seru dengan Edu Ular Tangga - Game Edukatif Berbasis Web')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">

    @if(session('success'))
    <div class="toast" id="toast-success">
        <div class="flex items-center gap-3 bg-success-500 text-white px-5 py-3 rounded-xl shadow-lg">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
            <button onclick="this.closest('.toast').remove()" class="ml-2 hover:opacity-75">✕</button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="toast" id="toast-error">
        <div class="flex items-center gap-3 bg-danger-500 text-white px-5 py-3 rounded-xl shadow-lg">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            <span class="font-medium">{{ session('error') }}</span>
            <button onclick="this.closest('.toast').remove()" class="ml-2 hover:opacity-75">✕</button>
        </div>
    </div>
    @endif

    @yield('content')

    <script>
        // Auto-dismiss toast after 4s
        setTimeout(() => {
            document.querySelectorAll('.toast').forEach(t => t.remove());
        }, 4000);
    </script>
    @stack('scripts')
</body>
</html>
