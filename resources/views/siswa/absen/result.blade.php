<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Hasil Absensi' }} — AbsensiKu</title>

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
                        ambercustom: '#F59E0B',
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

        <!-- Card Container -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 p-8 text-center space-y-6">

            @if($status === 'success')
                <div class="w-20 h-20 rounded-full bg-emeraldcustom/10 text-emeraldcustom flex items-center justify-center text-4xl mx-auto shadow-inner">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <div class="space-y-2">
                    <span class="px-3 py-1 bg-emeraldcustom/15 text-emeraldcustom text-xs font-extrabold rounded-full">✓ ABSEN BERHASIL</span>
                    <h1 class="text-2xl font-extrabold text-navy tracking-tight">{{ $title }}</h1>
                    <p class="text-xs text-slatecustom leading-relaxed">{{ $message }}</p>
                </div>

                @if(isset($record))
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-xs space-y-2 text-left">
                        <div class="flex justify-between">
                            <span class="text-slatecustom">Nama Siswa:</span>
                            <span class="font-bold text-navy">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slatecustom">Kelas:</span>
                            <span class="font-bold text-navy">{{ $session->kelas ? $session->kelas->nama_kelas : '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slatecustom">Pengajar:</span>
                            <span class="font-bold text-navy">{{ $session->guru ? $session->guru->name : '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slatecustom">Waktu Scan:</span>
                            <span class="font-bold text-emeraldcustom font-mono">{{ $record->scan_at->format('H:i:s') }} WIB</span>
                        </div>
                    </div>
                @endif

            @elseif($status === 'info')
                <div class="w-20 h-20 rounded-full bg-cerulean/10 text-cerulean flex items-center justify-center text-4xl mx-auto shadow-inner">
                    <i class="fa-solid fa-circle-info"></i>
                </div>

                <div class="space-y-2">
                    <span class="px-3 py-1 bg-cerulean/15 text-cerulean text-xs font-extrabold rounded-full">INFO PRESENSI</span>
                    <h1 class="text-2xl font-extrabold text-navy tracking-tight">{{ $title }}</h1>
                    <p class="text-xs text-slatecustom leading-relaxed">{{ $message }}</p>
                </div>

            @else
                <div class="w-20 h-20 rounded-full bg-rosecustom/10 text-rosecustom flex items-center justify-center text-4xl mx-auto shadow-inner">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>

                <div class="space-y-2">
                    <span class="px-3 py-1 bg-rosecustom/15 text-rosecustom text-xs font-extrabold rounded-full">GAGAL / KADALUARSA</span>
                    <h1 class="text-2xl font-extrabold text-navy tracking-tight">{{ $title }}</h1>
                    <p class="text-xs text-slatecustom leading-relaxed">{{ $message }}</p>
                </div>
            @endif

            <div class="pt-4 border-t border-slate-100">
                <a href="{{ route('siswa.dashboard') }}" class="w-full py-3.5 px-4 bg-navy hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition inline-block">
                    Ke Dashboard Siswa →
                </a>
            </div>

        </div>

    </div>

</body>
</html>
