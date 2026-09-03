@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-3 py-1 rounded-full font-semibold mb-2">SESI AKTIF</span>
        <h1 class="text-2xl font-bold">Mata Pelajaran: Informatika (K10A)</h1>
        <p class="text-gray-500 text-sm">Guru: Budi Santoso, S.Pd. | Sesi: 07:00 - 08:30</p>

        <!-- Container QR Code & Timer -->
        <div class="my-8 flex flex-col items-center justify-center">
            <div class="p-4 bg-gray-50 border-2 border-dashed border-indigo-200 rounded-2xl mb-4">
                <!-- Placeholder untuk Gambar QR Code -->
                <div id="qrcode" class="w-64 h-64 bg-white flex items-center justify-center border rounded-xl shadow-inner text-gray-400">
                    <i class="fa-solid fa-qrcode text-8xl text-indigo-500"></i>
                </div>
            </div>

            <!-- Countdown Bar & Timer -->
            <div class="w-64">
                <div class="flex justify-between text-xs font-semibold text-gray-500 mb-1">
                    <span>Pembaruan QR</span>
                    <span id="timer-text" class="text-indigo-600 font-bold">25 Detik</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                    <div id="timer-bar" class="bg-indigo-600 h-2 rounded-full w-full transition-all duration-1000"></div>
                </div>
            </div>
        </div>

        <p class="text-xs text-gray-400">Scan QR Code di atas menggunakan kamera aplikasi HP siswa. QR otomatis diperbarui setiap 25 detik.</p>
    </div>

    <!-- Live Status Kehadiran Siswa -->
    <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-bold text-lg mb-4 flex items-center justify-between">
            <span>Daftar Kehadiran Siswa (Realtime)</span>
            <span class="text-sm font-normal text-emerald-600 font-semibold">3 dari 36 Hadir</span>
        </h2>
        <div class="divide-y text-sm">
            <div class="py-3 flex justify-between items-center">
                <div>
                    <p class="font-medium">Ahmad Rizky (20261001)</p>
                    <p class="text-xs text-gray-400">Jam Masuk: 07:05:12</p>
                </div>
                <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-medium">Hadir</span>
            </div>
            <div class="py-3 flex justify-between items-center">
                <div>
                    <p class="font-medium">Anisa Rahma (20261002)</p>
                    <p class="text-xs text-gray-400">Jam Masuk: -</p>
                </div>
                <span class="bg-amber-100 text-amber-800 text-xs px-2.5 py-1 rounded-full font-medium">Belum Hadir</span>
            </div>
        </div>
    </div>
</div>
@endsection