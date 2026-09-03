@extends('layouts.app')

@section('title', 'Mulai Absensi QR — AbsensiKu')
@section('header_title', 'Mulai Sesi Absensi QR Code')
@section('header_subtitle', 'Pilih kelas dan tentukan durasi waktu aktif (TTL) QR Code absensi')

@section('content')
<div class="max-w-xl mx-auto">

    <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-6">
        <div class="text-center space-y-2 border-b border-slate-100 pb-6">
            <div class="w-16 h-16 rounded-3xl bg-cerulean/10 text-cerulean flex items-center justify-center text-3xl mx-auto mb-2">
                <i class="fa-solid fa-qrcode"></i>
            </div>
            <h2 class="text-xl font-extrabold text-navy">Buat QR Code Absensi Baru</h2>
            <p class="text-xs text-slatecustom max-w-sm mx-auto">
                Sistem akan membuat token unik UUID v4 yang aman dan menampilkan QR Code untuk dipindai oleh siswa.
            </p>
        </div>

        <form action="{{ route('guru.absensi.mulai') }}" method="POST" class="space-y-5 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-navy uppercase mb-2">1. Pilih Kelas Target</label>
                <select name="kelas_id" required class="w-full p-3.5 rounded-xl border border-slate-200 text-sm font-semibold text-navy focus:outline-none focus:ring-2 focus:ring-cerulean/40">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }} ({{ $k->siswa->count() }} Siswa)</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-navy uppercase mb-2">2. Durasi Aktif QR Code (Time To Live)</label>
                <div class="grid grid-cols-4 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="duration" value="5" class="peer sr-only">
                        <div class="p-3 text-center rounded-xl border border-slate-200 peer-checked:bg-cerulean peer-checked:text-white peer-checked:border-cerulean font-bold transition">
                            5 Menit
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="duration" value="15" checked class="peer sr-only">
                        <div class="p-3 text-center rounded-xl border border-slate-200 peer-checked:bg-cerulean peer-checked:text-white peer-checked:border-cerulean font-bold transition">
                            15 Menit
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="duration" value="30" class="peer sr-only">
                        <div class="p-3 text-center rounded-xl border border-slate-200 peer-checked:bg-cerulean peer-checked:text-white peer-checked:border-cerulean font-bold transition">
                            30 Menit
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="duration" value="60" class="peer sr-only">
                        <div class="p-3 text-center rounded-xl border border-slate-200 peer-checked:bg-cerulean peer-checked:text-white peer-checked:border-cerulean font-bold transition">
                            60 Menit
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 px-6 bg-cerulean hover:bg-blue-700 text-white font-bold text-sm rounded-2xl transition shadow-lg shadow-cerulean/30 flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-play"></i>
                    <span>Mulai & Tampilkan QR Code</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
