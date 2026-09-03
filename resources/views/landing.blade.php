@extends('layouts.landing')

@section('title', 'AbsensiKu — Sistem Absensi Digital Sekolah Berbasis QR Code')

@section('content')
<!-- Hero Section -->
<section class="relative py-16 lg:py-24 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center space-x-2 bg-cerulean/10 text-cerulean text-xs font-bold px-3 py-1.5 rounded-full">
                    <i class="fa-solid fa-bolt text-ambercustom"></i>
                    <span>Sistem Absensi Digital Sekolah V1.0</span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-navy tracking-tight leading-tight">
                    Absensi Lebih Mudah & Akurat dengan <span class="text-cerulean">Scan QR Code</span>
                </h1>
                <p class="text-base sm:text-lg text-slatecustom leading-relaxed">
                    Gantikan pencatatan kertas manual. Guru dapat membuka sesi absensi dengan QR Code unik dan siswa langsung scan dari perangkat seluler secara real-time.
                </p>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-3 sm:space-y-0 sm:space-x-4 pt-2">
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-6 py-3.5 text-base font-bold text-white bg-cerulean hover:bg-blue-700 rounded-xl transition shadow-lg shadow-cerulean/30">
                        <span>Masuk ke Aplikasi</span>
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#fitur" class="inline-flex justify-center items-center px-6 py-3.5 text-base font-semibold text-navy bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition">
                        <span>Pelajari Fitur</span>
                    </a>
                </div>

                <div class="pt-6 grid grid-cols-3 gap-4 border-t border-slate-200/80">
                    <div>
                        <p class="text-2xl font-extrabold text-navy">100%</p>
                        <p class="text-xs text-slatecustom font-medium">Digital & Real-time</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-navy">QR TTL</p>
                        <p class="text-xs text-slatecustom font-medium">Batas Waktu Akurat</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-navy">Export</p>
                        <p class="text-xs text-slatecustom font-medium">PDF & Excel Rekap</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="relative bg-white p-6 rounded-3xl shadow-xl border border-slate-100 space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-emeraldcustom/10 text-emeraldcustom flex items-center justify-center font-bold">
                                <i class="fa-solid fa-qrcode"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-navy">Sesi Absensi Aktif</h3>
                                <p class="text-xs text-slatecustom">Kelas X-IPA-1 · Informatika</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emeraldcustom/15 text-emeraldcustom">
                            ● Live
                        </span>
                    </div>

                    <!-- Mockup QR -->
                    <div class="bg-skybg p-6 rounded-2xl border border-blue-100 flex flex-col items-center justify-center text-center">
                        <div class="w-44 h-44 bg-white p-3 rounded-2xl shadow-md border border-slate-200 flex items-center justify-center mb-3">
                            <div class="w-full h-full border-2 border-dashed border-cerulean/40 rounded-xl flex items-center justify-center bg-cerulean/5">
                                <i class="fa-solid fa-qrcode text-7xl text-cerulean"></i>
                            </div>
                        </div>
                        <div class="w-full max-w-xs space-y-1">
                            <div class="flex justify-between text-xs font-semibold text-slatecustom">
                                <span>Pembaruan QR Sesi</span>
                                <span class="text-cerulean font-bold font-mono">05:00</span>
                            </div>
                            <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                                <div class="bg-cerulean h-full w-4/5 rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between items-center p-2.5 bg-slate-50 rounded-xl">
                            <span class="font-medium text-navy">Ahmad Rizky (X-IPA-1)</span>
                            <span class="px-2 py-0.5 rounded text-emeraldcustom bg-emeraldcustom/10 font-bold">✓ Hadir 08:02</span>
                        </div>
                        <div class="flex justify-between items-center p-2.5 bg-slate-50 rounded-xl">
                            <span class="font-medium text-navy">Ani Rahayu (X-IPA-1)</span>
                            <span class="px-2 py-0.5 rounded text-emeraldcustom bg-emeraldcustom/10 font-bold">✓ Hadir 08:04</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Fitur Unggulan (3 kolom) -->
<section id="fitur" class="py-16 bg-white border-y border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-navy">Fitur Unggulan AbsensiKu</h2>
            <p class="text-sm sm:text-base text-slatecustom mt-2">Dirancang khusus untuk mempermudah tugas guru, admin sekolah, dan siswa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-skybg p-8 rounded-2xl border border-slate-100 hover:border-cerulean/30 transition">
                <div class="w-12 h-12 rounded-xl bg-cerulean text-white flex items-center justify-center text-xl mb-6 shadow-md shadow-cerulean/20">
                    <i class="fa-solid fa-qrcode"></i>
                </div>
                <h3 class="text-lg font-bold text-navy mb-2">Absensi QR Code Dinamis</h3>
                <p class="text-sm text-slatecustom leading-relaxed">
                    Guru menghasilkan QR Code dengan batas waktu (TTL) untuk mencegah penipuan lokasi dan screenshot QR.
                </p>
            </div>

            <div class="bg-skybg p-8 rounded-2xl border border-slate-100 hover:border-cerulean/30 transition">
                <div class="w-12 h-12 rounded-xl bg-emeraldcustom text-white flex items-center justify-center text-xl mb-6 shadow-md shadow-emeraldcustom/20">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3 class="text-lg font-bold text-navy mb-2">Rekap & Laporan Otomatis</h3>
                <p class="text-sm text-slatecustom leading-relaxed">
                    Data kehadiran tercatat otomatis dan siap di-export ke PDF atau Excel kapan saja untuk laporan bulanan.
                </p>
            </div>

            <div class="bg-skybg p-8 rounded-2xl border border-slate-100 hover:border-cerulean/30 transition">
                <div class="w-12 h-12 rounded-xl bg-navy text-white flex items-center justify-center text-xl mb-6 shadow-md shadow-navy/20">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <h3 class="text-lg font-bold text-navy mb-2">Kontrol Multi-Role Akses</h3>
                <p class="text-sm text-slatecustom leading-relaxed">
                    Akses terpisah antara Kepala Sekolah (Admin), Guru Pengajar, dan Siswa sesuai wewenang masing-masing.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Cara Kerja (4 langkah bernomor) -->
<section id="cara-kerja" class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-navy">Alur Cara Kerja</h2>
            <p class="text-sm sm:text-base text-slatecustom mt-2">Hanya butuh 4 langkah praktis dalam setiap sesi jam pelajaran.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 relative">
                <div class="w-10 h-10 rounded-full bg-cerulean text-white font-mono font-bold text-lg flex items-center justify-center mb-4">1</div>
                <h4 class="font-bold text-navy text-base mb-2">Guru Buka Sesi</h4>
                <p class="text-xs text-slatecustom leading-relaxed">Guru memilih kelas dan menekan tombol Mulai Absensi di layar laptop/layar proyektor.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 relative">
                <div class="w-10 h-10 rounded-full bg-cerulean text-white font-mono font-bold text-lg flex items-center justify-center mb-4">2</div>
                <h4 class="font-bold text-navy text-base mb-2">QR Code Tampil</h4>
                <p class="text-xs text-slatecustom leading-relaxed">QR Code unik dibuat otomatis oleh sistem lengkap dengan timer hitung mundur.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 relative">
                <div class="w-10 h-10 rounded-full bg-cerulean text-white font-mono font-bold text-lg flex items-center justify-center mb-4">3</div>
                <h4 class="font-bold text-navy text-base mb-2">Siswa Scan QR</h4>
                <p class="text-xs text-slatecustom leading-relaxed">Siswa mengarahkan kamera HP ke QR Code yang ditampilkan guru.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 relative">
                <div class="w-10 h-10 rounded-full bg-cerulean text-white font-mono font-bold text-lg flex items-center justify-center mb-4">4</div>
                <h4 class="font-bold text-navy text-base mb-2">Kehadiran Tercatat</h4>
                <p class="text-xs text-slatecustom leading-relaxed">Sistem memverifikasi token dan mengubah status siswa menjadi Hadir secara instan.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimoni / Quotes -->
<section class="py-16 bg-navy text-white">
    <div class="max-w-4xl mx-auto px-4 text-center space-y-6">
        <i class="fa-solid fa-quote-left text-4xl text-cerulean/50"></i>
        <blockquote class="text-lg sm:text-xl font-medium leading-relaxed italic text-slate-100">
            "Dengan AbsensiKu, rekapitulasi absensi sekolah kami tidak lagi memakan waktu berhari-hari di akhir bulan. Semua data terintegrasi akurat dan transparan bagi seluruh pengajar."
        </blockquote>
        <div>
            <p class="font-bold text-white text-base">Drs. H. Ahmad Sudrajat, M.Pd.</p>
            <p class="text-xs text-slate-400">Kepala Sekolah</p>
        </div>
    </div>
</section>

<!-- Bottom CTA -->
<section class="py-16 bg-white text-center">
    <div class="max-w-3xl mx-auto px-4 space-y-6">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-navy">Siap Memulai Absensi Digital?</h2>
        <p class="text-slatecustom text-sm sm:text-base">Silakan masuk menggunakan akun yang telah diberikan oleh Administrator Sekolah.</p>
        <div>
            <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 text-base font-bold text-white bg-cerulean hover:bg-blue-700 rounded-xl transition shadow-lg shadow-cerulean/30">
                <span>Masuk ke AbsensiKu</span>
                <i class="fa-solid fa-right-to-bracket ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection
