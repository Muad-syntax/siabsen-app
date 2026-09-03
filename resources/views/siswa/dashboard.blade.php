@extends('layouts.app')

@section('title', 'Dashboard Siswa — AbsensiKu')
@section('header_title', 'Dashboard Siswa')
@section('header_subtitle', 'Ringkasan tingkat presensi kehadiran dan informasi kelas terdaftar')

@section('content')
<div class="space-y-6">

    <!-- Greeting Banner -->
    <div class="bg-navy text-white p-8 rounded-3xl shadow-lg relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="space-y-2 z-10">
            <span class="px-3 py-1 bg-cerulean/30 border border-cerulean/40 text-cerulean font-bold text-xs rounded-full">
                Siswa · {{ $kelas ? $kelas->nama_kelas : 'Belum Ada Kelas' }}
            </span>
            <h2 class="text-2xl font-extrabold tracking-tight">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
            <p class="text-slate-300 text-xs sm:text-sm max-w-xl">
                Gunakan kamera ponsel Anda untuk memindai QR Code yang ditampilkan oleh guru saat jam pelajaran berlangsung.
            </p>
        </div>
        <div class="z-10 bg-white/10 p-4 rounded-2xl border border-white/15 text-center">
            <p class="text-[11px] uppercase font-bold text-slate-300">Tingkat Kehadiran</p>
            <p class="text-3xl font-extrabold text-white mt-1">{{ $persenHadir }}%</p>
        </div>
    </div>

    <!-- Stat Cards (4 Status) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm text-center">
            <div class="w-10 h-10 rounded-2xl bg-emeraldcustom/10 text-emeraldcustom font-bold flex items-center justify-center mx-auto mb-2">
                <i class="fa-solid fa-check text-lg"></i>
            </div>
            <p class="text-xs font-bold text-slatecustom uppercase">Hadir</p>
            <p class="text-2xl font-extrabold text-navy mt-1">{{ $stats['hadir'] }}</p>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm text-center">
            <div class="w-10 h-10 rounded-2xl bg-ambercustom/10 text-ambercustom font-bold flex items-center justify-center mx-auto mb-2">
                <i class="fa-solid fa-envelope-open-text text-lg"></i>
            </div>
            <p class="text-xs font-bold text-slatecustom uppercase">Izin</p>
            <p class="text-2xl font-extrabold text-navy mt-1">{{ $stats['izin'] }}</p>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm text-center">
            <div class="w-10 h-10 rounded-2xl bg-cerulean/10 text-cerulean font-bold flex items-center justify-center mx-auto mb-2">
                <i class="fa-solid fa-notes-medical text-lg"></i>
            </div>
            <p class="text-xs font-bold text-slatecustom uppercase">Sakit</p>
            <p class="text-2xl font-extrabold text-navy mt-1">{{ $stats['sakit'] }}</p>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm text-center">
            <div class="w-10 h-10 rounded-2xl bg-rosecustom/10 text-rosecustom font-bold flex items-center justify-center mx-auto mb-2">
                <i class="fa-solid fa-xmark text-lg"></i>
            </div>
            <p class="text-xs font-bold text-slatecustom uppercase">Alpha</p>
            <p class="text-2xl font-extrabold text-navy mt-1">{{ $stats['alpha'] }}</p>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
            <h3 class="text-base font-bold text-navy">Riwayat Kehadiran Terbaru</h3>
            <a href="{{ route('siswa.riwayat') }}" class="text-xs font-bold text-cerulean hover:underline">Lihat Semua →</a>
        </div>

        <div class="divide-y divide-slate-100 text-xs font-medium">
            @forelse($riwayatTerbaru as $r)
                <div class="py-3 flex justify-between items-center">
                    <div>
                        <p class="font-bold text-navy text-sm">{{ $r->tanggal->format('d M Y') }}</p>
                        <p class="text-slatecustom text-[11px]">Kelas: {{ $r->kelas ? $r->kelas->nama_kelas : '-' }}</p>
                    </div>
                    <div>
                        @switch($r->status)
                            @case('hadir')
                                <span class="px-3 py-1 rounded-full font-bold bg-emeraldcustom/15 text-emeraldcustom">✓ Hadir ({{ $r->scan_at ? $r->scan_at->format('H:i') : '-' }})</span>
                                @break
                            @case('izin')
                                <span class="px-3 py-1 rounded-full font-bold bg-ambercustom/15 text-ambercustom">~ Izin</span>
                                @break
                            @case('sakit')
                                <span class="px-3 py-1 rounded-full font-bold bg-cerulean/15 text-cerulean">+ Sakit</span>
                                @break
                            @case('alpha')
                                <span class="px-3 py-1 rounded-full font-bold bg-rosecustom/15 text-rosecustom">✗ Alpha</span>
                                @break
                            @default
                                <span class="px-3 py-1 rounded-full font-bold bg-slate-200 text-slatecustom">Belum Hadir</span>
                        @endswitch
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-slatecustom">Belum ada riwayat absensi.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection