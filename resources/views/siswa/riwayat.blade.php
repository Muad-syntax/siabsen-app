@extends('layouts.app')

@section('title', 'Riwayat Kehadiran — AbsensiKu')
@section('header_title', 'Riwayat Kehadiran Saya')
@section('header_subtitle', 'Catatan histori absensi dan status kehadiran Anda di setiap mata pelajaran/kelas')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slatecustom uppercase text-[11px] font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Kelas</th>
                        <th class="p-4">Status Kehadiran</th>
                        <th class="p-4">Waktu Scan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($records as $r)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-4 font-bold text-navy">{{ $r->tanggal->format('d M Y') }}</td>
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
                                {{ $r->scan_at ? $r->scan_at->format('H:i:s') . ' WIB' : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slatecustom">Belum ada data riwayat absensi.</td>
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
