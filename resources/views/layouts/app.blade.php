<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard — AbsensiKu')</title>

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
    
    <style>
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="bg-skybg text-navy font-sans antialiased selection:bg-cerulean selection:text-white" x-data="{ mobileMenuOpen: false }">

    <div class="flex min-h-screen relative">

        <!-- Mobile Backdrop Overlay -->
        <div x-show="mobileMenuOpen" 
             @click="mobileMenuOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-navy/60 backdrop-blur-xs z-40 md:hidden"
             x-cloak></div>

        <!-- Sidebar Navigation -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-navy text-white flex flex-col transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:z-auto shadow-2xl md:shadow-xl border-r border-navy/20"
               :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            
            <!-- Logo -->
            <div class="p-5 border-b border-white/10 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-cerulean flex items-center justify-center text-white font-bold shadow-md shadow-cerulean/30">
                        <i class="fa-solid fa-qrcode text-lg"></i>
                    </div>
                    <div>
                        <a href="{{ url('/') }}" class="text-lg font-extrabold text-white tracking-tight">Absensi<span class="text-cerulean">Ku</span></a>
                        <p class="text-[10px] text-slate-300 uppercase tracking-widest font-semibold">Sekolah Digital</p>
                    </div>
                </div>

                <!-- Close button for mobile -->
                <button @click="mobileMenuOpen = false" class="md:hidden text-slate-300 hover:text-white p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation items per Role -->
            <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
                @php $user = Auth::user(); @endphp

                @if($user->isAdmin())
                    <div class="px-3 pt-2 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">Admin Panel</div>

                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-cerulean text-white shadow-md shadow-cerulean/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                        <span>Dashboard Admin</span>
                    </a>

                    <a href="{{ route('admin.guru.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.guru.*') ? 'bg-cerulean text-white shadow-md shadow-cerulean/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-chalkboard-user w-5 text-center"></i>
                        <span>Manajemen Guru</span>
                    </a>

                    <a href="{{ route('admin.kelas.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.kelas.*') ? 'bg-cerulean text-white shadow-md shadow-cerulean/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-school w-5 text-center"></i>
                        <span>Kelola Kelas</span>
                    </a>

                    <a href="{{ route('admin.siswa.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.siswa.*') ? 'bg-cerulean text-white shadow-md shadow-cerulean/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-users w-5 text-center"></i>
                        <span>Siswa Global</span>
                    </a>

                    <a href="{{ route('admin.laporan.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.laporan.*') ? 'bg-cerulean text-white shadow-md shadow-cerulean/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-file-lines w-5 text-center"></i>
                        <span>Laporan & Export</span>
                    </a>

                    <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.settings.*') ? 'bg-cerulean text-white shadow-md shadow-cerulean/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-sliders w-5 text-center"></i>
                        <span>Pengaturan Sekolah</span>
                    </a>
                @endif

                @if($user->isGuru())
                    <div class="px-3 pt-2 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">Guru Panel</div>

                    <a href="{{ route('guru.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('guru.dashboard') ? 'bg-cerulean text-white shadow-md shadow-cerulean/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-house w-5 text-center"></i>
                        <span>Dashboard Guru</span>
                    </a>

                    <a href="{{ route('guru.absensi.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('guru.absensi.*') ? 'bg-cerulean text-white shadow-md shadow-cerulean/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-qrcode w-5 text-center"></i>
                        <span>Mulai Absensi QR</span>
                    </a>

                    <a href="{{ route('guru.absensi.riwayat') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('guru.absensi.riwayat') ? 'bg-cerulean text-white shadow-md shadow-cerulean/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i>
                        <span>Riwayat Absensi</span>
                    </a>
                @endif

                @if($user->isSiswa())
                    <div class="px-3 pt-2 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">Siswa Panel</div>

                    <a href="{{ route('siswa.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('siswa.dashboard') ? 'bg-cerulean text-white shadow-md shadow-cerulean/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-house w-5 text-center"></i>
                        <span>Dashboard Siswa</span>
                    </a>

                    <a href="{{ route('siswa.riwayat') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('siswa.riwayat') ? 'bg-cerulean text-white shadow-md shadow-cerulean/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                        <span>Riwayat Kehadiran</span>
                    </a>

                    <a href="{{ route('siswa.profil') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('siswa.profil') ? 'bg-cerulean text-white shadow-md shadow-cerulean/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-user w-5 text-center"></i>
                        <span>Profil Saya</span>
                    </a>
                @endif
            </nav>

            <!-- User Profile Card & Logout -->
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-cerulean/30 text-white font-bold flex items-center justify-center border border-cerulean/40">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden flex-1">
                        <p class="text-xs font-bold text-white truncate">{{ $user->name }}</p>
                        <p class="text-[11px] text-slate-300 capitalize font-medium">{{ $user->role }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 py-2.5 px-3 rounded-xl text-xs font-bold text-rosecustom hover:bg-rosecustom/10 transition border border-rosecustom/20">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar (Logout)</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Container -->
        <div class="flex-1 flex flex-col min-w-0 w-full">
            <!-- Topbar -->
            <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-4 flex justify-between items-center sticky top-0 z-20">
                <div class="flex items-center space-x-3">
                    <!-- Hamburger Toggle Button for Mobile -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="md:hidden p-2 rounded-xl text-navy hover:bg-slate-100 transition focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <div>
                        <h1 class="text-base sm:text-lg font-bold text-navy">@yield('header_title', 'Dashboard')</h1>
                        <p class="text-[11px] sm:text-xs text-slatecustom hidden sm:block">@yield('header_subtitle', 'Selamat datang di Sistem Absensi Digital AbsensiKu')</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-xs font-bold text-navy hidden sm:block">{{ date('D, d M Y') }}</p>
                        <span class="text-[10px] px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider text-cerulean bg-skybg">
                            {{ strtoupper($user->role) }}
                        </span>
                    </div>
                </div>
            </header>

            <!-- Dynamic Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-6 overflow-x-hidden">
                @if(session('success'))
                    <div class="p-4 bg-emeraldcustom/10 border border-emeraldcustom/20 rounded-2xl text-xs font-semibold text-emerald-800 flex items-center space-x-3">
                        <i class="fa-solid fa-circle-check text-emeraldcustom text-base"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 bg-rosecustom/10 border border-rosecustom/20 rounded-2xl text-xs font-semibold text-rose-800 flex items-center space-x-3">
                        <i class="fa-solid fa-circle-exclamation text-rosecustom text-base"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

    </div>

    @stack('scripts')
</body>
</html>