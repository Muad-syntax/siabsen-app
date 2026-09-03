@extends('layouts.app')

@section('title', 'Profil Saya — AbsensiKu')
@section('header_title', 'Profil Siswa')
@section('header_subtitle', 'Informasi akun siswa dan pembaruan kata sandi (password)')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Card Profil Siswa -->
    <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-6">
        <div class="flex items-center space-x-4 border-b border-slate-100 pb-6">
            <div class="w-16 h-16 rounded-3xl bg-cerulean text-white font-extrabold flex items-center justify-center text-2xl shadow-md shadow-cerulean/30">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-navy">{{ $user->name }}</h2>
                <p class="text-xs text-slatecustom font-medium">NIS: {{ $user->nis ?? '-' }} · Email: {{ $user->email }}</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-skybg text-cerulean mt-1">
                    {{ $kelas ? 'Kelas ' . $kelas->nama_kelas : 'Tanpa Kelas' }}
                </span>
            </div>
        </div>

        <!-- Form Ganti Password -->
        <form action="{{ route('siswa.profil.update') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <h3 class="font-bold text-navy text-sm">Ganti Password Akun</h3>

            @if($errors->any())
                <div class="p-3 bg-rosecustom/10 border border-rosecustom/20 rounded-xl text-rose-800 font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label class="block font-bold text-navy uppercase mb-1">Password Saat Ini</label>
                <input type="password" name="old_password" required class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40" placeholder="••••••••">
            </div>

            <div>
                <label class="block font-bold text-navy uppercase mb-1">Password Baru</label>
                <input type="password" name="new_password" required minlength="6" class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40" placeholder="••••••••">
            </div>

            <div>
                <label class="block font-bold text-navy uppercase mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" required minlength="6" class="w-full p-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cerulean/40" placeholder="••••••••">
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-cerulean hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-md shadow-cerulean/20">
                    Update Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
