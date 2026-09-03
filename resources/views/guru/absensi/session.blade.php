@extends('layouts.app')

@section('title', 'Sesi Absensi QR — ' . ($session->kelas ? $session->kelas->nama_kelas : ''))
@section('header_title', 'Sesi Absensi Kelas ' . ($session->kelas ? $session->kelas->nama_kelas : ''))
@section('header_subtitle', 'Tampilkan QR Code pada proyektor/layar. Status absensi siswa diperbarui otomatis secara real-time.')

@section('content')
<div x-data="absensiSession()" x-init="initPolling()" class="max-w-5xl mx-auto space-y-6">

    <!-- Tip Card untuk Scan HP Wi-Fi -->
    <div class="p-4 bg-skybg border border-cerulean/30 rounded-2xl text-xs space-y-1.5 text-navy">
        <div class="flex items-center space-x-2 font-bold text-cerulean">
            <i class="fa-solid fa-wifi text-sm"></i>
            <span>Mengapa Perlu IP Wi-Fi untuk Scan HP?</span>
        </div>
        <p class="text-slatecustom leading-relaxed">
            Perangkat HP siswa tidak dapat membaca alamat <code>0.0.0.0</code> atau <code>127.0.0.1</code> karena alamat tersebut merujuk pada internal HP itu sendiri. 
            Sistem secara otomatis mendeteksi IP Komputer Server Anda: <strong class="text-navy bg-white px-2 py-0.5 rounded border border-slate-200 font-mono">{{ $localIp }}</strong>.
        </p>
    </div>

    <!-- QR Code & Countdown Timer Container -->
    <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm text-center space-y-6">

        <div class="flex flex-wrap justify-between items-center pb-4 border-b border-slate-100">
            <div class="text-left">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emeraldcustom/10 text-emeraldcustom">
                    ● {{ $session->is_closed ? 'SESI DITUTUP' : ($session->isExpired() ? 'KADALUARSA (EXPIRED)' : 'SESI ABSENSI AKTIF') }}
                </span>
                <h2 class="text-xl font-extrabold text-navy mt-1">Kelas {{ $session->kelas ? $session->kelas->nama_kelas : '-' }}</h2>
                <p class="text-xs text-slatecustom">Tanggal: {{ $session->tanggal->format('d M Y') }} · Pengajar: {{ $session->guru ? $session->guru->name : '-' }}</p>
            </div>

            <div class="flex space-x-3 mt-2 sm:mt-0">
                <button @click="toggleFullscreen()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-navy font-bold text-xs rounded-xl transition">
                    <i class="fa-solid fa-expand mr-1.5"></i> Fullscreen QR
                </button>
                @if(!$session->is_closed)
                    <form action="{{ route('guru.absensi.tutup', $session->token) }}" method="POST" onsubmit="return confirm('Tutup sesi absensi sekarang?')">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-rosecustom text-white font-bold text-xs rounded-xl transition shadow-md shadow-rosecustom/20">
                            <i class="fa-solid fa-stop mr-1.5"></i> Tutup Sesi
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Host Server Configuration Input -->
        <div class="max-w-md mx-auto p-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs space-y-1.5 text-left">
            <label class="font-bold text-navy uppercase text-[10px] tracking-wider block">Host / IP Server QR Code (Otomatis IP Komputer):</label>
            <div class="flex items-center space-x-2">
                <input type="text" x-model="customHost" @input="updateQrUrl()"
                       class="flex-1 p-2 rounded-lg border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-cerulean/40 focus:outline-none"
                       placeholder="{{ $localIp }}:8000">
                <button type="button" @click="resetHost()" class="px-3 py-2 bg-white border border-slate-300 rounded-lg font-bold text-[11px] text-slatecustom hover:bg-slate-100">
                    Reset IP
                </button>
            </div>
        </div>

        <!-- Visual QR Card Display -->
        <div id="qr-container" class="inline-block p-6 bg-skybg rounded-3xl border-2 border-dashed border-cerulean/30 shadow-inner">
            <div class="bg-white p-4 rounded-2xl shadow-md border border-slate-200 inline-block">
                <img :src="qrImageUrl" alt="QR Code Absensi" class="w-64 h-64 mx-auto rounded-xl shadow-xs">
            </div>

            <div class="mt-4 max-w-sm mx-auto space-y-1 text-xs">
                <p class="font-bold text-navy">Target Link Absensi HP (Sudah Menggunakan IP LAN):</p>
                <p class="font-mono text-[11px] text-cerulean bg-white p-2 rounded-lg border border-slate-200 truncate select-all" x-text="fullAbsenUrl"></p>
            </div>
        </div>

        <!-- Live Countdown & Live Counter -->
        <div class="grid grid-cols-2 gap-4 max-w-md mx-auto">
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <p class="text-[11px] font-bold text-slatecustom uppercase">Status Kehadiran</p>
                <p class="text-2xl font-extrabold text-emeraldcustom mt-0.5">
                    <span x-text="totalHadir">0</span> / <span x-text="totalSiswa">0</span> Hadir
                </p>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <p class="text-[11px] font-bold text-slatecustom uppercase">Batas Sesi Absensi</p>
                <p class="text-2xl font-extrabold text-navy font-mono mt-0.5">
                    {{ $session->expires_at->format('H:i') }} WIB
                </p>
            </div>
        </div>

    </div>

    <!-- Live Table Real-time Absensi Siswa -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-4">
        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
            <h3 class="text-base font-bold text-navy">
                <i class="fa-solid fa-signal text-emeraldcustom mr-2"></i> Real-time Monitoring Kehadiran Siswa
            </h3>
            <span class="text-xs font-semibold text-slatecustom">Update otomatis (polling 3s)</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slatecustom uppercase text-[11px] font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-3.5">NIS</th>
                        <th class="p-3.5">Nama Siswa</th>
                        <th class="p-3.5">Status Kehadiran</th>
                        <th class="p-3.5">Waktu Scan</th>
                        <th class="p-3.5 text-center">Override Manual</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    <template x-for="rec in records" :key="rec.id">
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-3.5 font-mono text-slatecustom" x-text="rec.nis"></td>
                            <td class="p-3.5 font-bold text-navy" x-text="rec.nama"></td>
                            <td class="p-3.5">
                                <template x-if="rec.status === 'hadir'">
                                    <span class="px-2.5 py-1 rounded-full font-bold bg-emeraldcustom/15 text-emeraldcustom">✓ HADIR</span>
                                </template>
                                <template x-if="rec.status === 'izin'">
                                    <span class="px-2.5 py-1 rounded-full font-bold bg-ambercustom/15 text-ambercustom">~ IZIN</span>
                                </template>
                                <template x-if="rec.status === 'sakit'">
                                    <span class="px-2.5 py-1 rounded-full font-bold bg-cerulean/15 text-cerulean">+ SAKIT</span>
                                </template>
                                <template x-if="rec.status === 'alpha'">
                                    <span class="px-2.5 py-1 rounded-full font-bold bg-rosecustom/15 text-rosecustom">✗ ALPHA</span>
                                </template>
                                <template x-if="rec.status === 'belum_hadir'">
                                    <span class="px-2.5 py-1 rounded-full font-bold bg-slate-200 text-slatecustom">BELUM HADIR</span>
                                </template>
                            </td>
                            <td class="p-3.5 font-mono text-slatecustom" x-text="rec.scan_at ? rec.scan_at : '-'"></td>
                            <td class="p-3.5 text-center">
                                <select @change="overrideStatus(rec.id, $event.target.value)" :value="rec.status"
                                        class="p-1.5 rounded-lg border border-slate-200 text-[11px] font-bold focus:outline-none">
                                    <option value="hadir">Hadir</option>
                                    <option value="izin">Izin</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="alpha">Alpha</option>
                                    <option value="belum_hadir">Belum Hadir</option>
                                </select>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function absensiSession() {
        return {
            token: '{{ $session->token }}',
            localDetectedIp: '{{ $localIp }}',
            totalHadir: 0,
            totalSiswa: 0,
            records: [],
            pollingInterval: null,
            customHost: '',
            fullAbsenUrl: '',
            qrImageUrl: '',

            initPolling() {
                const port = window.location.port ? ':' + window.location.port : '';
                const hostName = window.location.hostname;

                if (hostName === '0.0.0.0' || hostName === '127.0.0.1' || hostName === 'localhost') {
                    this.customHost = this.localDetectedIp + (port || ':8000');
                } else {
                    this.customHost = window.location.host;
                }

                this.updateQrUrl();
                this.fetchStatus();
                this.pollingInterval = setInterval(() => {
                    this.fetchStatus();
                }, 3000);
            },

            updateQrUrl() {
                let host = this.customHost.trim();

                // Cegah 0.0.0.0, 127.0.0.1, atau localhost terpampang di QR Code HP
                if (!host || host.includes('0.0.0.0') || host.includes('127.0.0.1') || host.includes('localhost')) {
                    const port = window.location.port ? ':' + window.location.port : ':8000';
                    host = this.localDetectedIp + port;
                }

                this.fullAbsenUrl = window.location.protocol + '//' + host + '/absen/' + this.token;
                this.qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' + encodeURIComponent(this.fullAbsenUrl);
            },

            resetHost() {
                const port = window.location.port ? ':' + window.location.port : ':8000';
                this.customHost = this.localDetectedIp + port;
                this.updateQrUrl();
            },

            async fetchStatus() {
                try {
                    const res = await fetch(`/api/absensi/session/${this.token}/status`);
                    if (res.ok) {
                        const data = await res.json();
                        this.totalHadir = data.total_hadir;
                        this.totalSiswa = data.total_siswa;
                        this.records = data.records;
                    }
                } catch (e) {
                    console.error('Polling error:', e);
                }
            },

            async overrideStatus(recordId, status) {
                try {
                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const res = await fetch(`/guru/absensi/record/${recordId}/override`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                        },
                        body: JSON.stringify({ status })
                    });
                    if (res.ok) {
                        this.fetchStatus();
                    }
                } catch (e) {
                    console.error('Override error:', e);
                }
            },

            toggleFullscreen() {
                const elem = document.getElementById('qr-container');
                if (!document.fullscreenElement) {
                    elem.requestFullscreen().catch(err => alert(`Gagal fullscreen: ${err.message}`));
                } else {
                    document.exitFullscreen();
                }
            }
        }
    }
</script>
@endpush
@endsection
