@extends('layouts.app')

@section('title', 'Riwayat Absensi — AbsensiKu')
@section('header_title', 'Riwayat Sesi Absensi')
@section('header_subtitle', 'Daftar riwayat sesi absensi yang telah Anda buat beserta rekap hasilnya')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slatecustom uppercase text-[11px] font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Kelas</th>
                        <th class="p-4">Waktu Pelaksanaan</th>
                        <th class="p-4">Jumlah Hadir</th>
                        <th class="p-4">Status Sesi</th>
                        <th class="p-4 text-center">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($sessions as $s)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-4 font-bold text-navy">{{ $s->tanggal->format('d M Y') }}</td>
                            <td class="p-4 font-bold text-navy">{{ $s->kelas ? $s->kelas->nama_kelas : '-' }}</td>
                            <td class="p-4 font-mono text-slatecustom">{{ $s->starts_at->format('H:i') }} - {{ $s->expires_at->format('H:i') }}</td>
                            <td class="p-4">
                                <span class="font-bold text-emeraldcustom">
                                    {{ $s->records->where('status', 'hadir')->count() }}
                                </span>
                                / {{ $s->records->count() }} Siswa
                            </td>
                            <td class="p-4">
                                @if(!$s->is_closed && !$s->isExpired())
                                    <span class="px-2.5 py-1 rounded-full font-bold bg-emeraldcustom/10 text-emeraldcustom">● Berjalan</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full font-bold bg-slate-200 text-slatecustom">Selesai</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('guru.absensi.session', $s->token) }}" class="px-3 py-1.5 bg-skybg text-cerulean font-bold rounded-lg hover:bg-cerulean hover:text-white transition">
                                    Buka Sesi →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slatecustom">Belum ada riwayat sesi absensi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $sessions->links() }}
        </div>
    </div>

</div>
@endsection
