@extends('layouts.app')

@section('title', 'Laporan & Export Absensi — AbsensiKu')
@section('header_title', 'Laporan Kehadiran Siswa')
@section('header_subtitle', 'Filter laporan absensi per kelas, rentang tanggal, dan unduh format PDF/Excel')

@section('content')
<div class="space-y-6">

    <!-- Filter Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end text-xs">
            <div>
                <label class="block font-bold text-navy uppercase mb-1">Pilih Kelas</label>
                <select name="kelas_id" class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }} (Tingkat {{ $k->tingkat }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-navy uppercase mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none">
            </div>

            <div>
                <label class="block font-bold text-navy uppercase mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none">
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="flex-1 py-3 px-4 bg-cerulean text-white font-bold rounded-xl transition shadow-md shadow-cerulean/20">
                    <i class="fa-solid fa-filter mr-1"></i> Tampilkan
                </button>
            </div>
        </form>

        <!-- Export Buttons -->
        <div class="pt-4 border-t border-slate-100 flex flex-wrap gap-3 justify-between items-center text-xs">
            <span class="text-slatecustom">Export hasil pencarian saat ini:</span>
            <div class="flex space-x-3">
                <a href="{{ route('admin.laporan.export.pdf', request()->all()) }}" class="px-4 py-2.5 bg-rosecustom/10 text-rosecustom hover:bg-rosecustom hover:text-white font-bold rounded-xl transition">
                    <i class="fa-solid fa-file-pdf mr-1.5"></i> Export PDF
                </a>
                <a href="{{ route('admin.laporan.export.excel', request()->all()) }}" class="px-4 py-2.5 bg-emeraldcustom/10 text-emeraldcustom hover:bg-emeraldcustom hover:text-white font-bold rounded-xl transition">
                    <i class="fa-solid fa-file-excel mr-1.5"></i> Export Excel (.csv)
                </a>
            </div>
        </div>
    </div>

    <!-- Ringkasan Stat Status -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm text-center">
            <p class="text-[11px] font-bold text-slatecustom uppercase">Hadir</p>
            <p class="text-xl font-extrabold text-emeraldcustom">{{ $rekap['hadir'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm text-center">
            <p class="text-[11px] font-bold text-slatecustom uppercase">Izin</p>
            <p class="text-xl font-extrabold text-ambercustom">{{ $rekap['izin'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm text-center">
            <p class="text-[11px] font-bold text-slatecustom uppercase">Sakit</p>
            <p class="text-xl font-extrabold text-cerulean">{{ $rekap['sakit'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm text-center">
            <p class="text-[11px] font-bold text-slatecustom uppercase">Alpha</p>
            <p class="text-xl font-extrabold text-rosecustom">{{ $rekap['alpha'] }}</p>
        </div>
    </div>

    <!-- Tabel Rekap -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slatecustom uppercase text-[11px] font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Siswa</th>
                        <th class="p-4">NIS</th>
                        <th class="p-4">Kelas</th>
                        <th class="p-4">Status Kehadiran</th>
                        <th class="p-4">Waktu Scan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($records as $r)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-4 text-navy font-bold">{{ $r->tanggal->format('d M Y') }}</td>
                            <td class="p-4 font-bold text-navy">{{ $r->siswa ? $r->siswa->name : '-' }}</td>
                            <td class="p-4 font-mono text-slatecustom">{{ $r->siswa ? $r->siswa->nis : '-' }}</td>
                            <td class="p-4 text-navy">{{ $r->kelas ? $r->kelas->nama_kelas : '-' }}</td>
                            <td class="p-4">
                                @switch($r->status)
                                    @case('hadir')
                                        <span class="px-2.5 py-1 rounded-full font-bold bg-emeraldcustom/15 text-emeraldcustom">✓ HADIR</span>
                                        @break
                                    @case('izin')
                                        <span class="px-2.5 py-1 rounded-full font-bold bg-ambercustom/15 text-ambercustom">~ IZIN</span>
                                        @break
                                    @case('sakit')
                                        <span class="px-2.5 py-1 rounded-full font-bold bg-cerulean/15 text-cerulean">+ SAKIT</span>
                                        @break
                                    @case('alpha')
                                        <span class="px-2.5 py-1 rounded-full font-bold bg-rosecustom/15 text-rosecustom">✗ ALPHA</span>
                                        @break
                                    @default
                                        <span class="px-2.5 py-1 rounded-full font-bold bg-slate-200 text-slatecustom">BELUM HADIR</span>
                                @endswitch
                            </td>
                            <td class="p-4 font-mono text-slatecustom">
                                {{ $r->scan_at ? $r->scan_at->format('H:i:s') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slatecustom">Belum ada data kehadiran pada rentang tanggal ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $records->links() }}
        </div>
    </div>

</div>
@endsection
