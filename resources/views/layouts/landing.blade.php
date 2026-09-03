<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AbsensiKu — Sistem Absensi Digital Sekolah')</title>

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#0F2D4A',
                        cerulean: '#2563EB',
                        skybg: '#EFF6FF',
                        slatecustom: '#64748B',
                        emeraldcustom: '#10B981',
                        ambercustom: '#F59E0B',
                        rosecustom: '#F43F5E',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-skybg text-navy font-sans antialiased selection:bg-cerulean selection:text-white flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ url('/') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-cerulean flex items-center justify-center text-white shadow-md shadow-cerulean/30">
                        <i class="fa-solid fa-qrcode text-xl"></i>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-navy">Absensi<span class="text-cerulean">Ku</span></span>
                </a>

                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-xl text-white bg-cerulean hover:bg-blue-700 transition shadow-md shadow-cerulean/20">
                            <span>Ke Dashboard</span>
                            <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-semibold rounded-xl text-white bg-cerulean hover:bg-blue-700 transition shadow-md shadow-cerulean/20">
                            <span>Masuk</span>
                            <i class="fa-solid fa-right-to-bracket ml-2 text-xs"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-navy text-white py-12 border-t border-navy">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-cerulean flex items-center justify-center text-white">
                            <i class="fa-solid fa-qrcode"></i>
                        </div>
                        <span class="text-lg font-bold text-white">AbsensiKu</span>
                    </div>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        Sistem absensi digital sekolah berbasis QR Code instan, akurat, dan dapat dipantau secara real-time.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Akses Cepat</h3>
                    <ul class="space-y-2 text-sm text-slate-300">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Halaman Login</a></li>
                        <li><a href="#fitur" class="hover:text-white transition">Fitur Utama</a></li>
                        <li><a href="#cara-kerja" class="hover:text-white transition">Cara Kerja</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Kontak Internal</h3>
                    <p class="text-sm text-slate-300 mb-1"><i class="fa-solid fa-building mr-2 text-cerulean"></i> Tim Admin Sekolah</p>
                    <p class="text-sm text-slate-300"><i class="fa-solid fa-envelope mr-2 text-cerulean"></i> support@absensiku.sch.id</p>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-700/60 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} AbsensiKu. All rights reserved. Sekolah Digital Indonesia.
            </div>
        </div>
    </footer>

</body>
</html>
