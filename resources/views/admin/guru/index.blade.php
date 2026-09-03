@extends('layouts.app')

@section('title', 'Manajemen Guru — AbsensiKu')
@section('header_title', 'Manajemen Data Guru')
@section('header_subtitle', 'Tambah, edit, nonaktifkan, dan reset password akun guru pengajar')

@section('content')
<div x-data="{ modalTambah: false, modalEdit: false, modalReset: false, activeGuru: {} }" class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <form method="GET" action="{{ route('admin.guru.index') }}" class="flex-1 max-w-md relative">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, NIP, atau email guru..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-cerulean/40">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slatecustom text-xs"></i>
        </form>
        
        <button @click="modalTambah = true" class="inline-flex items-center justify-center px-4 py-2.5 bg-cerulean hover:bg-blue-700 text-white font-bold text-xs rounded-xl transition shadow-md shadow-cerulean/20">
            <i class="fa-solid fa-user-plus mr-2"></i>
            <span>+ Tambah Guru Baru</span>
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slatecustom uppercase text-[11px] font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-4">Guru</th>
                        <th class="p-4">NIP</th>
                        <th class="p-4">Email Login</th>
                        <th class="p-4">Status Akun</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($guru as $g)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-4 flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-cerulean/10 text-cerulean font-bold flex items-center justify-center">
                                    {{ strtoupper(substr($g->name, 0, 1)) }}
                                </div>
                                <span class="font-bold text-navy text-sm">{{ $g->name }}</span>
                            </td>
                            <td class="p-4 font-mono text-slatecustom">{{ $g->nip ?? '-' }}</td>
                            <td class="p-4 text-navy">{{ $g->email }}</td>
                            <td class="p-4">
                                @if($g->is_active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full font-bold bg-emeraldcustom/10 text-emeraldcustom">
                                        ● Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full font-bold bg-rosecustom/10 text-rosecustom">
                                        ● Non-aktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center space-x-2">
                                <button @click="activeGuru = {{ json_encode($g) }}; modalEdit = true"
                                        class="px-2.5 py-1.5 bg-skybg text-cerulean hover:bg-cerulean hover:text-white rounded-lg font-bold transition">
                                    <i class="fa-solid fa-pen mr-1"></i> Edit
                                </button>
                                
                                <button @click="activeGuru = {{ json_encode($g) }}; modalReset = true"
                                        class="px-2.5 py-1.5 bg-ambercustom/10 text-ambercustom hover:bg-ambercustom hover:text-white rounded-lg font-bold transition">
                                    <i class="fa-solid fa-key mr-1"></i> Reset Pass
                                </button>

                                <form action="{{ route('admin.guru.destroy', $g->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status aktif guru ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 {{ $g->is_active ? 'bg-ambercustom/10 text-ambercustom hover:bg-ambercustom hover:text-white' : 'bg-emeraldcustom/10 text-emeraldcustom hover:bg-emeraldcustom hover:text-white' }} rounded-lg font-bold transition">
                                        {{ $g->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.guru.delete-permanent', $g->id) }}" method="POST" class="inline-block" onsubmit="return confirm('PERINGATAN: Hapus permanen akun guru {{ $g->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 bg-rosecustom/10 text-rosecustom hover:bg-rosecustom hover:text-white rounded-lg font-bold transition">
                                        <i class="fa-solid fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slatecustom">Belum ada data guru terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $guru->links() }}
        </div>
    </div>

    <!-- Modal Tambah Guru -->
    <div x-show="modalTambah" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy/50 backdrop-blur-sm" x-cloak>
        <div @click.away="modalTambah = false" class="bg-white w-full max-w-md rounded-3xl p-6 shadow-2xl space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-navy text-base">Tambah Akun Guru Baru</h3>
                <button @click="modalTambah = false" class="text-slatecustom hover:text-navy"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            
            <form action="{{ route('admin.guru.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">Nama Lengkap & Gelar</label>
                    <input type="text" name="name" required class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40" placeholder="Contoh: Budi Santoso, S.Pd.">
                </div>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">Email Login</label>
                    <input type="email" name="email" required class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40" placeholder="guru@absensiku.sch.id">
                </div>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">NIP (Nomor Induk Pegawai)</label>
                    <input type="text" name="nip" class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40" placeholder="198501012010011001">
                </div>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">Password Awal</label>
                    <input type="password" name="password" required minlength="6" class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40" placeholder="••••••••">
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" @click="modalTambah = false" class="px-4 py-2.5 rounded-xl border border-slate-200 font-bold text-slatecustom">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-cerulean text-white font-bold shadow-md shadow-cerulean/20">Simpan Guru</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Guru -->
    <div x-show="modalEdit" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy/50 backdrop-blur-sm" x-cloak>
        <div @click.away="modalEdit = false" class="bg-white w-full max-w-md rounded-3xl p-6 shadow-2xl space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-navy text-base">Edit Data Guru</h3>
                <button @click="modalEdit = false" class="text-slatecustom hover:text-navy"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            
            <form :action="'/admin/guru/' + activeGuru.id" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">Nama Lengkap & Gelar</label>
                    <input type="text" name="name" :value="activeGuru.name" required class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40">
                </div>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">Email Login</label>
                    <input type="email" name="email" :value="activeGuru.email" required class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40">
                </div>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">NIP</label>
                    <input type="text" name="nip" :value="activeGuru.nip" class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40">
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" @click="modalEdit = false" class="px-4 py-2.5 rounded-xl border border-slate-200 font-bold text-slatecustom">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-cerulean text-white font-bold shadow-md shadow-cerulean/20">Update Guru</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Reset Password -->
    <div x-show="modalReset" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy/50 backdrop-blur-sm" x-cloak>
        <div @click.away="modalReset = false" class="bg-white w-full max-w-sm rounded-3xl p-6 shadow-2xl space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-navy text-base">Reset Password Guru</h3>
                <button @click="modalReset = false" class="text-slatecustom hover:text-navy"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            
            <form :action="'/admin/guru/' + activeGuru.id + '/reset-password'" method="POST" class="space-y-4 text-xs">
                @csrf
                <p class="text-slatecustom">Reset password untuk pengajar <strong class="text-navy" x-text="activeGuru.name"></strong>.</p>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">Password Baru</label>
                    <input type="password" name="new_password" required minlength="6" class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40" placeholder="••••••••">
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" @click="modalReset = false" class="px-4 py-2.5 rounded-xl border border-slate-200 font-bold text-slatecustom">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-ambercustom text-white font-bold">Set Password</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
