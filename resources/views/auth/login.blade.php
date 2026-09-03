<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Sistem — AbsensiKu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
                        rosecustom: '#F43F5E',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-skybg text-navy font-sans min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center space-x-3 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-cerulean flex items-center justify-center text-white text-2xl shadow-lg shadow-cerulean/30">
                    <i class="fa-solid fa-qrcode"></i>
                </div>
                <span class="text-2xl font-extrabold text-navy tracking-tight">Absensi<span class="text-cerulean">Ku</span></span>
            </a>
            <h1 class="text-xl font-bold text-navy">Selamat Datang Kembali</h1>
            <p class="text-xs text-slatecustom mt-1">Masukkan kredensial akun sekolah Anda untuk masuk</p>
        </div>

        <!-- Card Container -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 p-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emeraldcustom/10 border border-emeraldcustom/20 rounded-2xl text-xs text-emerald-800 font-medium flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-emeraldcustom text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-rosecustom/10 border border-rosecustom/20 rounded-2xl text-xs text-rose-800 font-medium flex items-center space-x-2">
                    <i class="fa-solid fa-circle-exclamation text-rosecustom text-sm"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slatecustom">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-cerulean/40 focus:border-cerulean transition placeholder:text-slate-400"
                               placeholder="nama@absensiku.sch.id">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-bold text-navy uppercase tracking-wider">Password</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slatecustom">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input type="password" name="password" required
                               class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-cerulean/40 focus:border-cerulean transition placeholder:text-slate-400"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-cerulean focus:ring-cerulean border-slate-300">
                        <span class="text-slatecustom font-medium">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 bg-cerulean hover:bg-blue-700 text-white font-bold text-sm rounded-xl transition shadow-lg shadow-cerulean/30 flex items-center justify-center space-x-2">
                    <span>Masuk ke Sistem</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <div class="pt-4 border-t border-slate-100 text-center">
                <p class="text-xs text-slatecustom">
                    Akun ditentukan oleh Administrator Sekolah.<br>
                    <a href="{{ url('/') }}" class="text-cerulean font-semibold hover:underline mt-1 inline-block">← Kembali ke Halaman Utama</a>
                </p>
            </div>
        </div>

        <div class="mt-6 text-center text-xs text-slatecustom">
            &copy; {{ date('Y') }} AbsensiKu · Sistem Absensi Digital
        </div>
    </div>

</body>
</html>