@extends('layouts.app')

@section('title', 'Dashboard Admin — AbsensiKu')
@section('header_title', 'Dashboard Administrator')
@section('header_subtitle', 'Ringkasan data sekolah, statistik kehadiran, dan manajemen master data')

@section('content')
<div class="space-y-6">

    <!-- Stat Cards (4 kolom) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Stat Total Siswa -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-cerulean/10 text-cerulean flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slatecustom uppercase tracking-wider">Total Siswa</p>
                <p class="text-2xl font-extrabold text-navy">{{ number_format($totalSiswa) }}</p>
            </div>
        </div>

        <!-- Stat Total Guru -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-emeraldcustom/10 text-emeraldcustom flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slatecustom uppercase tracking-wider">Total Guru</p>
                <p class="text-2xl font-extrabold text-navy">{{ number_format($totalGuru) }}</p>
            </div>
        </div>

        <!-- Stat Total Kelas -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-ambercustom/10 text-ambercustom flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-school"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slatecustom uppercase tracking-wider">Total Kelas</p>
                <p class="text-2xl font-extrabold text-navy">{{ number_format($totalKelas) }}</p>
            </div>
        </div>

        <!-- Stat Kehadiran Hari Ini -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-skybg text-cerulean border border-cerulean/20 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slatecustom uppercase tracking-wider">Hadir Hari Ini</p>
                <p class="text-2xl font-extrabold text-navy">{{ $persenKehadiran }}%</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Persentase Kehadiran Per Kelas -->
        <div class="lg:col-span-8 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-navy">Persentase Kehadiran Kelas (Hari Ini)</h3>
                    <p class="text-xs text-slatecustom">Rekap kehadiran siswa per kelas hari ini</p>
                </div>
                <a href="{{ route('admin.laporan.index') }}" class="text-xs font-bold text-cerulean hover:underline">
                    Lihat Laporan Lengkap →
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($kelasList as $k)
                    <div class="py-3.5 flex items-center justify-between space-x-4">
                        <div class="w-1/3">
                            <p class="text-sm font-bold text-navy">{{ $k->nama_kelas }}</p>
                            <p class="text-xs text-slatecustom">Wali: {{ $k->waliKelas ? $k->waliKelas->name : '-' }}</p>
                        </div>
                        <div class="flex-1 max-w-xs space-y-1">
                            <div class="flex justify-between text-xs font-semibold text-slatecustom">
                                <span>Tingkat {{ $k->tingkat }}</span>
                                <span class="text-navy font-bold">{{ $k->persen_hadir }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-cerulean h-full rounded-full" style="width: {{ $k->persen_hadir }}%"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-6 text-center text-slatecustom text-sm">Belum ada data kelas aktif.</div>
                @endforelse
            </div>
        </div>

        <!-- Panel Akses Cepat & Guru Terbaru -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Card Quick Action -->
            <div class="bg-navy text-white p-6 rounded-3xl shadow-md space-y-4">
                <h3 class="text-base font-bold text-white">Tindakan Cepat Admin</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.guru.index') }}" class="w-full flex items-center justify-between p-3 bg-white/10 hover:bg-white/20 rounded-2xl text-xs font-semibold transition">
                        <span><i class="fa-solid fa-user-plus mr-2 text-cerulean"></i> Tambah Akun Guru</span>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                    <a href="{{ route('admin.kelas.index') }}" class="w-full flex items-center justify-between p-3 bg-white/10 hover:bg-white/20 rounded-2xl text-xs font-semibold transition">
                        <span><i class="fa-solid fa-plus mr-2 text-emeraldcustom"></i> Buat Kelas Baru</span>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                    <a href="{{ route('admin.laporan.export.excel') }}" class="w-full flex items-center justify-between p-3 bg-white/10 hover:bg-white/20 rounded-2xl text-xs font-semibold transition">
                        <span><i class="fa-solid fa-file-excel mr-2 text-ambercustom"></i> Export Rekap Excel</span>
                        <i class="fa-solid fa-download text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Card Daftar Guru -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-navy">Guru Terdaftar</h3>
                <div class="space-y-3">
                    @forelse($guruTerbaru as $g)
                        <div class="flex items-center space-x-3 text-xs">
                            <div class="w-8 h-8 rounded-full bg-cerulean/10 text-cerulean flex items-center justify-center font-bold">
                                {{ strtoupper(substr($g->name, 0, 1)) }}
                            </div>
                            <div class="overflow-hidden flex-1">
                                <p class="font-bold text-navy truncate">{{ $g->name }}</p>
                                <p class="text-slatecustom text-[11px]">NIP: {{ $g->nip ?? '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slatecustom">Belum ada guru.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>
@endsection