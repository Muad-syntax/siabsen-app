@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
        <h1 class="text-xl font-bold mb-1">Scan QR Code Kehadiran</h1>
        <p class="text-xs text-gray-500 mb-6">Arahkan kamera HP ke layar proyektor guru</p>

        <!-- Kamera Frame -->
        <div class="relative w-full aspect-square bg-slate-900 rounded-2xl overflow-hidden mb-6 flex items-center justify-center border-4 border-indigo-500/20">
            <div id="reader" class="w-full h-full"></div>
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-48 h-48 border-2 border-indigo-400 border-dashed rounded-xl animate-pulse"></div>
            </div>
        </div>

        <div class="p-4 bg-indigo-50 rounded-xl text-left flex items-center space-x-3 text-indigo-900 mb-4">
            <i class="fa-solid fa-user-circle text-2xl text-indigo-600"></i>
            <div>
                <p class="text-xs text-indigo-600 font-medium">Logged in as:</p>
                <p class="text-sm font-bold">Ahmad Rizky (NIS: 20261001)</p>
            </div>
        </div>
    </div>
</div>
@endsection