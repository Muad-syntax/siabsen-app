@extends('layouts.app')

@section('title', 'Kelola Siswa — ' . $kelas->nama_kelas)
@section('header_title', 'Kelola Siswa Kelas ' . $kelas->nama_kelas)
@section('header_subtitle', 'Tambah siswa secara manual atau import massal via file CSV')

@section('content')
<div x-data="{ modalTambah: false, modalImport: false }" class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <form method="GET" action="{{ route('guru.siswa.index', $kelas->id) }}" class="flex-1 max-w-md relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIS siswa..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-cerulean/40">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slatecustom text-xs"></i>
        </form>

        <div class="flex space-x-3">
            <button @click="modalImport = true" class="inline-flex items-center justify-center px-4 py-2.5 bg-emeraldcustom hover:bg-emerald-600 text-white font-bold text-xs rounded-xl transition shadow-md shadow-emeraldcustom/20">
                <i class="fa-solid fa-file-csv mr-2"></i>
                <span>Import CSV</span>
            </button>
            <button @click="modalTambah = true" class="inline-flex items-center justify-center px-4 py-2.5 bg-cerulean hover:bg-blue-700 text-white font-bold text-xs rounded-xl transition shadow-md shadow-cerulean/20">
                <i class="fa-solid fa-user-plus mr-2"></i>
                <span>+ Tambah Siswa</span>
            </button>
        </div>
    </div>

    <!-- Table Siswa -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slatecustom uppercase text-[11px] font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-4">Nama Siswa</th>
                        <th class="p-4">NIS</th>
                        <th class="p-4">Email Login</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($kelas->siswa as $s)
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
                                @if($s->is_active)
                                    <span class="px-2.5 py-1 rounded-full font-bold bg-emeraldcustom/10 text-emeraldcustom">● Aktif</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full font-bold bg-rosecustom/10 text-rosecustom">● Non-aktif</span>
                                @endif
                            </td>
                            <td class="p-4 text-center space-x-2">
                                <form action="{{ route('guru.siswa.destroy', $s->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Ubah status aktif siswa ini?')">
                                     @csrf
                                     @method('DELETE')
                                     <button type="submit" class="text-xs font-bold {{ $s->is_active ? 'text-ambercustom hover:underline' : 'text-emeraldcustom hover:underline' }}">
                                         {{ $s->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                     </button>
                                </form>

                                <form action="{{ route('guru.siswa.delete-permanent', $s->id) }}" method="POST" class="inline-block" onsubmit="return confirm('PERINGATAN: Hapus permanen data siswa {{ $s->name }}?')">
                                     @csrf
                                     @method('DELETE')
                                     <button type="submit" class="text-xs font-bold text-rosecustom hover:underline">
                                         Hapus
                                     </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slatecustom">Belum ada siswa di kelas ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Siswa -->
    <div x-show="modalTambah" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy/50 backdrop-blur-sm" x-cloak>
        <div @click.away="modalTambah = false" class="bg-white w-full max-w-md rounded-3xl p-6 shadow-2xl space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-navy text-base">Tambah Siswa ke {{ $kelas->nama_kelas }}</h3>
                <button @click="modalTambah = false" class="text-slatecustom hover:text-navy"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form action="{{ route('guru.siswa.store', $kelas->id) }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">Nama Lengkap Siswa</label>
                    <input type="text" name="name" required class="w-full p-3 rounded-xl border border-slate-200" placeholder="Ahmad Rizky">
                </div>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">NIS (Nomor Induk Siswa)</label>
                    <input type="text" name="nis" required class="w-full p-3 rounded-xl border border-slate-200" placeholder="20261001">
                </div>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">Email Login Siswa</label>
                    <input type="email" name="email" required class="w-full p-3 rounded-xl border border-slate-200" placeholder="siswa@absensiku.sch.id">
                </div>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">Password Login</label>
                    <input type="password" name="password" required minlength="6" class="w-full p-3 rounded-xl border border-slate-200" placeholder="••••••••">
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" @click="modalTambah = false" class="px-4 py-2.5 rounded-xl border border-slate-200 font-bold text-slatecustom">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-cerulean text-white font-bold">Simpan Siswa</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Import CSV -->
    <div x-show="modalImport" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy/50 backdrop-blur-sm" x-cloak>
        <div @click.away="modalImport = false" class="bg-white w-full max-w-md rounded-3xl p-6 shadow-2xl space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-navy text-base">Import Siswa CSV</h3>
                <button @click="modalImport = false" class="text-slatecustom hover:text-navy"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form action="{{ route('guru.siswa.import', $kelas->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <p class="text-slatecustom">
                    Format file CSV: <code>nama, nis, email, password</code><br>
                    Baris pertama adalah header file.
                </p>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">File CSV (.csv / .txt)</label>
                    <input type="file" name="file_csv" accept=".csv, .txt" required class="w-full p-3 rounded-xl border border-slate-200">
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" @click="modalImport = false" class="px-4 py-2.5 rounded-xl border border-slate-200 font-bold text-slatecustom">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emeraldcustom text-white font-bold">Proses Import</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
