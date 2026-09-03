@extends('layouts.app')

@section('title', 'Pengaturan Sekolah — AbsensiKu')
@section('header_title', 'Pengaturan Aplikasi & Sekolah')
@section('header_subtitle', 'Konfigurasi identitas sekolah, alamat, dan informasi jam absensi')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-4">
            <h3 class="text-base font-bold text-navy">Identitas Sekolah</h3>
            <p class="text-xs text-slatecustom">Informasi ini akan dicetak pada kop laporan PDF dan sertifikat absensi</p>
        </div>

        <form action="{{ route('admin.settings.store') }}" method="POST" class="space-y-5 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-navy uppercase mb-2">Nama Resmi Sekolah</label>
                <input type="text" name="nama_sekolah" value="{{ $settings['nama_sekolah'] }}" required class="w-full p-3.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40">
            </div>

            <div>
                <label class="block font-bold text-navy uppercase mb-2">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" required class="w-full p-3.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40">{{ $settings['alamat'] }}</textarea>
            </div>

            <div>
                <label class="block font-bold text-navy uppercase mb-2">Nomor Telepon / Kontak</label>
                <input type="text" name="telepon" value="{{ $settings['telepon'] }}" class="w-full p-3.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40">
            </div>

            <div>
                <label class="block font-bold text-navy uppercase mb-2">Tahun Ajaran Aktif</label>
                <input type="text" value="{{ $settings['tahun_ajaran_aktif'] }}" readonly class="w-full p-3.5 rounded-xl border border-slate-200 bg-slate-50 font-bold text-slatecustom">
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-cerulean hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-md shadow-cerulean/20">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
