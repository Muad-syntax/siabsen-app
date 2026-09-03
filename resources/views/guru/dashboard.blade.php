@extends('layouts.app')

@section('title', 'Dashboard Guru — AbsensiKu')
@section('header_title', 'Dashboard Pengajar')
@section('header_subtitle', 'Ringkasan kelas yang diajar, sesi absensi aktif, dan statistik kehadiran')

@section('content')
<div class="space-y-6">

    <!-- Hero Card Pengajar -->
    <div class="bg-navy text-white p-8 rounded-3xl shadow-lg relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="space-y-2 z-10">
            <span class="px-3 py-1 bg-cerulean/30 border border-cerulean/40 text-cerulean font-bold text-xs rounded-full">
                Halo, {{ Auth::user()->name }} 👋
            </span>
            <h2 class="text-2xl font-extrabold tracking-tight">Siap Memulai Jam Pelajaran Hari Ini?</h2>
            <p class="text-slate-300 text-xs sm:text-sm max-w-xl">
                Pilih kelas dan jalankan QR Code absensi instan di depan kelas agar siswa dapat melakukan pencatatan kehadiran.
            </p>
        </div>
        <a href="{{ route('guru.absensi.index') }}" class="z-10 px-6 py-3.5 bg-cerulean hover:bg-blue-700 text-white font-bold text-xs rounded-2xl transition shadow-lg shadow-cerulean/40 flex items-center space-x-2">
            <i class="fa-solid fa-qrcode text-base"></i>
            <span>Mulai Absensi QR</span>
        </a>
    </div>

    <!-- Quick Stats & Sesi Hari Ini -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Daftar Kelas yang Diajar -->
        <div class="lg:col-span-7 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                <h3 class="text-base font-bold text-navy">Kelas Yang Anda Ajar</h3>
                <span class="text-xs font-bold text-slatecustom">{{ $kelasList->count() }} Kelas</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($kelasList as $k)
                    <div class="p-4 bg-skybg rounded-2xl border border-slate-200/60 space-y-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[10px] font-extrabold uppercase text-cerulean bg-white px-2 py-0.5 rounded-md border border-slate-200">
                                    Tingkat {{ $k->tingkat }}
                                </span>
                                <h4 class="text-lg font-extrabold text-navy mt-1">{{ $k->nama_kelas }}</h4>
                            </div>
                            <span class="text-xs font-bold text-navy bg-white px-2.5 py-1 rounded-xl shadow-xs">
                                {{ $k->siswa->count() }} Siswa
                            </span>
                        </div>

                        <div class="pt-2 border-t border-slate-200/60 flex justify-between items-center text-xs">
                            <a href="{{ route('guru.siswa.index', $k->id) }}" class="text-cerulean font-bold hover:underline">
                                Kelola Siswa →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-6 text-center text-slatecustom text-xs">
                        Anda belum ditugaskan mengajar di kelas manapun.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Sesi Absensi Hari Ini -->
        <div class="lg:col-span-5 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                <h3 class="text-base font-bold text-navy">Sesi Absensi Hari Ini</h3>
                <a href="{{ route('guru.absensi.riwayat') }}" class="text-xs font-bold text-cerulean hover:underline">Histori →</a>
            </div>

            <div class="space-y-3 text-xs">
                @forelse($sesiHariIni as $s)
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 flex justify-between items-center">
                        <div>
                            <p class="font-bold text-navy text-sm">{{ $s->kelas ? $s->kelas->nama_kelas : 'Kelas' }}</p>
                            <p class="text-slatecustom text-[11px]">Waktu: {{ $s->starts_at->format('H:i') }} - {{ $s->expires_at->format('H:i') }}</p>
                        </div>
                        <div class="text-right">
                            @if(!$s->is_closed && !$s->isExpired())
                                <span class="px-2.5 py-1 bg-emeraldcustom/10 text-emeraldcustom font-bold rounded-full">● Aktif</span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-200 text-slatecustom font-bold rounded-full">Selesai</span>
                            @endif
                            <a href="{{ route('guru.absensi.session', $s->token) }}" class="block text-[11px] font-bold text-cerulean hover:underline mt-1">Lihat Sesi →</a>
                        </div>
                    </div>
                @empty
                    <div class="py-6 text-center text-slatecustom">Belum ada sesi absensi dibuat hari ini.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection