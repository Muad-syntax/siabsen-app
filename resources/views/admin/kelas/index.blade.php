@extends('layouts.app')

@section('title', 'Kelola Kelas & Wali Kelas — AbsensiKu')
@section('header_title', 'Manajemen Kelas & Pengajar')
@section('header_subtitle', 'Kelola daftar kelas, tentukan wali kelas, dan tentukan guru pengajar per kelas')

@section('content')
<div x-data="{ modalTambah: false, modalEdit: false, activeKelas: {} }" class="space-y-6">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-base font-bold text-navy">Daftar Kelas Sekolah</h2>
            <p class="text-xs text-slatecustom">Tahun Ajaran Aktif 2026/2027</p>
        </div>
        <button @click="modalTambah = true" class="inline-flex items-center px-4 py-2.5 bg-cerulean hover:bg-blue-700 text-white font-bold text-xs rounded-xl transition shadow-md shadow-cerulean/20">
            <i class="fa-solid fa-plus mr-2"></i>
            <span>+ Tambah Kelas Baru</span>
        </button>
    </div>

    <!-- Grid Kelas Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($kelas as $k)
            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4 hover:border-cerulean/30 transition flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-skybg text-cerulean">
                                Tingkat {{ $k->tingkat }}
                            </span>
                            <h3 class="text-xl font-extrabold text-navy mt-1">{{ $k->nama_kelas }}</h3>
                            <p class="text-xs text-slatecustom">Jurusan: {{ $k->jurusan ?? '-' }} · TA: {{ $k->tahun_ajaran }}</p>
                        </div>
                        <div class="flex space-x-1">
                            <button @click="activeKelas = {{ json_encode($k) }}; modalEdit = true" class="p-2 text-slatecustom hover:text-cerulean text-xs">
                                <i class="fa-solid fa-pen"></i> Edit
                            </button>
                        </div>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-2xl space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slatecustom">Wali Kelas:</span>
                            <span class="font-bold text-navy">{{ $k->waliKelas ? $k->waliKelas->name : 'Belum diatur' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slatecustom">Jumlah Siswa:</span>
                            <span class="font-bold text-navy">{{ $k->siswa->count() }} Siswa</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slatecustom">Guru Pengajar:</span>
                            <span class="font-bold text-cerulean">{{ $k->pengajar->count() }} Guru</span>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs gap-2">
                    <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Ubah status aktif kelas?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-bold {{ $k->is_active ? 'text-emeraldcustom hover:underline' : 'text-slatecustom hover:underline' }}">
                            ● {{ $k->is_active ? 'Aktif' : 'Non-aktif' }}
                        </button>
                    </form>

                    <form action="{{ route('admin.kelas.delete-permanent', $k->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Hapus permanen kelas {{ $k->nama_kelas }} beserta data terkait?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-bold text-rosecustom hover:underline flex items-center space-x-1">
                            <i class="fa-solid fa-trash text-[11px]"></i>
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-8 rounded-3xl text-center text-slatecustom text-sm">
                Belum ada data kelas. Silakan tambah kelas baru.
            </div>
        @endforelse
    </div>

    <!-- Modal Tambah Kelas -->
    <div x-show="modalTambah" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy/50 backdrop-blur-sm" x-cloak>
        <div @click.away="modalTambah = false" class="bg-white w-full max-w-md rounded-3xl p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-navy text-base">Tambah Kelas Baru</h3>
                <button @click="modalTambah = false" class="text-slatecustom hover:text-navy"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-navy uppercase mb-1">Nama Kelas</label>
                        <input type="text" name="nama_kelas" required class="w-full p-3 rounded-xl border border-slate-200" placeholder="X-IPA-1">
                    </div>
                    <div>
                        <label class="block font-bold text-navy uppercase mb-1">Tingkat</label>
                        <select name="tingkat" required class="w-full p-3 rounded-xl border border-slate-200">
                            <option value="X">Tingkat X</option>
                            <option value="XI">Tingkat XI</option>
                            <option value="XII">Tingkat XII</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-navy uppercase mb-1">Jurusan</label>
                        <input type="text" name="jurusan" class="w-full p-3 rounded-xl border border-slate-200" placeholder="IPA / IPS / RPL">
                    </div>
                    <div>
                        <label class="block font-bold text-navy uppercase mb-1">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" value="2026/2027" required class="w-full p-3 rounded-xl border border-slate-200">
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">Wali Kelas</label>
                    <select name="wali_kelas_id" class="w-full p-3 rounded-xl border border-slate-200">
                        <option value="">-- Pilih Wali Kelas --</option>
                        @foreach($gurus as $g)
                            <option value="{{ $g->id }}">{{ $g->name }} (NIP: {{ $g->nip ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">Guru Pengajar Kelas Ini</label>
                    <div class="space-y-1.5 max-h-36 overflow-y-auto p-3 border border-slate-200 rounded-xl bg-slate-50">
                        @foreach($gurus as $g)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="guru_ids[]" value="{{ $g->id }}" class="rounded text-cerulean focus:ring-cerulean">
                                <span class="text-navy font-medium">{{ $g->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" @click="modalTambah = false" class="px-4 py-2.5 rounded-xl border border-slate-200 font-bold text-slatecustom">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-cerulean text-white font-bold">Simpan Kelas</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kelas -->
    <div x-show="modalEdit" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy/50 backdrop-blur-sm" x-cloak>
        <div @click.away="modalEdit = false" class="bg-white w-full max-w-md rounded-3xl p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-navy text-base">Edit Data Kelas</h3>
                <button @click="modalEdit = false" class="text-slatecustom hover:text-navy"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form :action="'/admin/kelas/' + activeKelas.id" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-navy uppercase mb-1">Nama Kelas</label>
                        <input type="text" name="nama_kelas" :value="activeKelas.nama_kelas" required class="w-full p-3 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block font-bold text-navy uppercase mb-1">Tingkat</label>
                        <select name="tingkat" :value="activeKelas.tingkat" required class="w-full p-3 rounded-xl border border-slate-200">
                            <option value="X">Tingkat X</option>
                            <option value="XI">Tingkat XI</option>
                            <option value="XII">Tingkat XII</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-navy uppercase mb-1">Jurusan</label>
                        <input type="text" name="jurusan" :value="activeKelas.jurusan" class="w-full p-3 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block font-bold text-navy uppercase mb-1">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" :value="activeKelas.tahun_ajaran" required class="w-full p-3 rounded-xl border border-slate-200">
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">Wali Kelas</label>
                    <select name="wali_kelas_id" :value="activeKelas.wali_kelas_id" class="w-full p-3 rounded-xl border border-slate-200">
                        <option value="">-- Pilih Wali Kelas --</option>
                        @foreach($gurus as $g)
                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-navy uppercase mb-1">Guru Pengajar Kelas Ini</label>
                    <div class="space-y-1.5 max-h-36 overflow-y-auto p-3 border border-slate-200 rounded-xl bg-slate-50">
                        @foreach($gurus as $g)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="guru_ids[]" value="{{ $g->id }}" class="rounded text-cerulean focus:ring-cerulean">
                                <span class="text-navy font-medium">{{ $g->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" @click="modalEdit = false" class="px-4 py-2.5 rounded-xl border border-slate-200 font-bold text-slatecustom">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-cerulean text-white font-bold">Update Kelas</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
