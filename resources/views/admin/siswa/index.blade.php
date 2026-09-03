@extends('layouts.app')

@section('title', 'Siswa Global — AbsensiKu')
@section('header_title', 'Manajemen Siswa Global')
@section('header_subtitle', 'Lihat dan cari seluruh data siswa terdaftar dari semua kelas')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <form method="GET" action="{{ route('admin.siswa.index') }}" class="flex-1 max-w-md relative">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama siswa, NIS, atau email..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-cerulean/40">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slatecustom text-xs"></i>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slatecustom uppercase text-[11px] font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-4">Nama Siswa</th>
                        <th class="p-4">NIS</th>
                        <th class="p-4">Email Login</th>
                        <th class="p-4">Kelas Terdaftar</th>
                        <th class="p-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($siswa as $s)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-4 flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-cerulean/10 text-cerulean font-bold flex items-center justify-center">
                                    {{ strtoupper(substr($s->name, 0, 1)) }}
                                </div>
                                <span class="font-bold text-navy text-sm">{{ $s->name }}</span>
                            </td>
                            <td class="p-4 font-mono text-slatecustom">{{ $s->nis ?? '-' }}</td>
                            <td class="p-4 text-navy">{{ $s->email }}</td>
                            <td class="p-4">
                                @forelse($s->kelasAsStudent as $k)
                                    <span class="px-2 py-1 rounded bg-skybg text-cerulean font-bold text-[11px] mr-1">
                                        {{ $k->nama_kelas }}
                                    </span>
                                @empty
                                    <span class="text-slatecustom italic">Belum masuk kelas</span>
                                @endforelse
                            </td>
                            <td class="p-4">
                                @if($s->is_active)
                                    <span class="px-2.5 py-1 rounded-full font-bold bg-emeraldcustom/10 text-emeraldcustom">
                                        ● Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full font-bold bg-rosecustom/10 text-rosecustom">
                                        ● Non-aktif
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slatecustom">Belum ada siswa terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $siswa->links() }}
        </div>
    </div>

</div>
@endsection
