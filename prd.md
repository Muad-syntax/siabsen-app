# PRD — siabsen: Sistem Absensi Sekolah Berbasis Web
**Versi:** 1.0  
**Tanggal:** 4 September 2026  
**Dibuat untuk:** Kepala Sekolah — Internal School Project  
**Tech Stack:** Laravel 11 · MySQL · InfinityFree Hosting

---

## 1. Gambaran Umum Produk

### 1.1 Latar Belakang
Proses absensi manual menggunakan kertas memiliki banyak kelemahan: data mudah hilang, rekap lambat, dan tidak bisa dipantau secara real-time. **AbsensiKu** hadir sebagai solusi absensi digital berbasis web yang memungkinkan guru mencatat kehadiran siswa secara instan melalui QR Code, dan siswa bisa memantau riwayat kehadiran mereka sendiri kapan saja.

### 1.2 Tujuan Produk
- Menggantikan sistem absensi manual dengan sistem digital yang efisien
- Memberikan data kehadiran yang akurat dan real-time kepada guru dan kepala sekolah
- Mempermudah siswa dalam memantau riwayat kehadiran mereka
- Memberikan kontrol penuh kepada admin (kepala sekolah) atas seluruh data sekolah

### 1.3 Target Pengguna
| Peran | Deskripsi |
|---|---|
| **Admin** | Kepala Sekolah — mengelola seluruh data master sekolah |
| **Guru** | Tenaga pengajar — mengelola kelas, siswa, dan absensi |
| **Siswa** | Pelajar — scan QR untuk absen dan melihat riwayat kehadiran |

---

## 2. Desain & Frontend

### 2.1 Identitas Visual

**Konsep:** *"Kedisiplinan yang Ramah"* — tampilan yang bersih dan institusional tanpa terasa kaku, mencerminkan lingkungan sekolah yang teratur namun tetap menyambut.

#### Palet Warna
```
--color-navy:      #0F2D4A   /* Utama: header, sidebar, teks penting */
--color-cerulean:  #2563EB   /* Aksen: tombol utama, link, badge aktif */
--color-sky:       #EFF6FF   /* Latar belakang halaman & card */
--color-white:     #FFFFFF   /* Surface: card, modal, form */
--color-slate:     #64748B   /* Teks sekunder, label, placeholder */
--color-emerald:   #10B981   /* Status: Hadir, sukses, konfirmasi */
--color-amber:     #F59E0B   /* Status: Izin, peringatan */
--color-rose:      #F43F5E   /* Status: Alpha, error, hapus */
--color-border:    #E2E8F0   /* Garis pembatas, outline card */
```

#### Tipografi
```
Font Utama   : "Plus Jakarta Sans" (Google Fonts)
               — Digunakan untuk semua elemen UI: heading, body, label
               — Weight yang dipakai: 400 (regular), 500 (medium), 600 (semibold), 700 (bold)

Font Monospace: "JetBrains Mono"
               — Hanya untuk tampilan kode QR dan token unik

Scale:
  Display  : 2.25rem / 36px — bold   → Heading halaman utama
  H1       : 1.875rem / 30px — bold   → Judul section
  H2       : 1.5rem   / 24px — semibold
  H3       : 1.25rem  / 20px — semibold
  Body     : 1rem     / 16px — regular  → Konten & deskripsi
  Small    : 0.875rem / 14px — medium   → Label, badge, metadata
  Tiny     : 0.75rem  / 12px — medium   → Timestamp, caption
```

#### Prinsip Desain
- **Satu aksi utama per halaman** — setiap layar punya satu tindakan paling penting yang ditonjolkan
- **Data dulu, dekorasi belakangan** — tabel dan info kehadiran tampil jelas, ornamen minimal
- **Status selalu berwarna** — Hadir (hijau), Izin (kuning), Sakit (biru), Alpha (merah), Belum Hadir (abu-abu)
- **Mobile-first** — tampilan scan QR siswa dirancang untuk layar ponsel terlebih dahulu
- **Satu momen animasi** — hanya transisi page-load yang halus; tidak ada hover efek berlebihan

---

### 2.2 Layout & Struktur Halaman

#### Landing Page (Publik)
```
┌────────────────────────────────────────────────┐
│  NAVBAR  [Logo AbsensiKu]         [Masuk →]    │
├────────────────────────────────────────────────┤
│                                                │
│  HERO                                          │
│  ┌──────────────────┐  ┌─────────────────┐    │
│  │                  │  │  Absensi Lebih  │    │
│  │  Ilustrasi/      │  │  Mudah dengan   │    │
│  │  Mockup App      │  │  Scan QR Code   │    │
│  │                  │  │                 │    │
│  │                  │  │  [Mulai Gratis] │    │
│  └──────────────────┘  └─────────────────┘    │
├────────────────────────────────────────────────┤
│  FITUR UNGGULAN (3 kolom)                      │
│  [QR Absen]  [Rekap Otomatis]  [Dashboard]     │
├────────────────────────────────────────────────┤
│  CARA KERJA (langkah bernomor — memang urutan) │
│  1 → 2 → 3 → 4                                │
├────────────────────────────────────────────────┤
│  TESTIMONI / QUOTES KEPALA SEKOLAH             │
├────────────────────────────────────────────────┤
│  CTA BOTTOM  — "Hubungi Kami / Demo"           │
├────────────────────────────────────────────────┤
│  FOOTER                                        │
└────────────────────────────────────────────────┘
```

#### Dashboard Layout (Authenticated — Guru & Admin)
```
┌──────────┬─────────────────────────────────────┐
│          │  TOPBAR: [Nama User] [Notif] [Logout]│
│ SIDEBAR  ├─────────────────────────────────────┤
│          │                                     │
│ • Home   │  KONTEN UTAMA                       │
│ • Kelas  │                                     │
│ • Siswa  │  [Breadcrumb]                       │
│ • Absen  │                                     │
│ • Laporan│  ┌────────┐  ┌────────┐  ┌───────┐ │
│ • Profil │  │ Stat 1 │  │ Stat 2 │  │ Stat 3│ │
│          │  └────────┘  └────────┘  └───────┘ │
│          │                                     │
│          │  [Tabel / Konten Dinamis]           │
│          │                                     │
└──────────┴─────────────────────────────────────┘
```

#### Dashboard Siswa (Minimal, Mobile-First)
```
┌────────────────────────┐
│  AbsensiKu    [Logout] │
├────────────────────────┤
│  Halo, [Nama Siswa]!   │
│  Kelas X-IPA-1         │
├────────────────────────┤
│  STATUS HARI INI       │
│  ┌──────────────────┐  │
│  │  ● Belum Hadir   │  │
│  │  [Scan QR Sekarang] │
│  └──────────────────┘  │
├────────────────────────┤
│  RIWAYAT KEHADIRAN     │
│  Filter: [Bulan ▼]     │
│  ┌──────────────────┐  │
│  │ 01 Sep  ✓ Hadir  │  │
│  │ 02 Sep  ~ Izin   │  │
│  │ 03 Sep  ✗ Alpha  │  │
│  └──────────────────┘  │
└────────────────────────┘
```

---

## 3. Fitur Inti (Core Features)

### 3.1 Landing Page (Publik)

| ID | Fitur | Deskripsi |
|---|---|---|
| LP-01 | Hero Section | Headline, subheadline, CTA "Masuk ke Aplikasi" |
| LP-02 | Fitur Unggulan | 3 kartu fitur: Absen QR, Rekap Otomatis, Laporan Kehadiran |
| LP-03 | Cara Kerja | Penjelasan alur 4 langkah (numbered — memang urutan proses) |
| LP-04 | Testimonial | Quote dari kepala sekolah atau guru |
| LP-05 | Footer | Kontak, copyright, link login |

---

### 3.2 Modul Admin (Kepala Sekolah)

#### Manajemen Pengguna
| ID | Fitur | Deskripsi |
|---|---|---|
| ADM-01 | Tambah Guru | Buat akun guru baru (nama, email, NIP, password, foto) |
| ADM-02 | Edit Guru | Ubah data guru yang sudah ada |
| ADM-03 | Nonaktifkan Guru | Soft-delete akun guru (data historis tetap tersimpan) |
| ADM-04 | Reset Password Guru | Generate password baru untuk guru |
| ADM-05 | Manajemen Siswa Global | Lihat dan cari semua siswa dari semua kelas |

#### Manajemen Kelas & Mata Pelajaran
| ID | Fitur | Deskripsi |
|---|---|---|
| ADM-06 | Kelola Kelas | Tambah, edit, hapus data kelas (nama, tingkat, jurusan) |
| ADM-07 | Assign Guru ke Kelas | Tentukan guru wali atau guru pengampu per kelas |
| ADM-08 | Kelola Tahun Ajaran | Atur tahun ajaran aktif, tutup tahun ajaran lama |

#### Laporan & Analitik
| ID | Fitur | Deskripsi |
|---|---|---|
| ADM-09 | Dashboard Ringkasan | Total siswa, guru, kelas, dan persentase kehadiran hari ini |
| ADM-10 | Laporan Per Kelas | Tabel rekap kehadiran per kelas dalam rentang tanggal |
| ADM-11 | Laporan Per Siswa | Detail kehadiran per siswa: Hadir, Izin, Sakit, Alpha |
| ADM-12 | Export Laporan | Export rekap ke format PDF dan Excel (.xlsx) |
| ADM-13 | Pengaturan Sekolah | Nama sekolah, logo, alamat, jam belajar default |

---

### 3.3 Modul Guru

#### Manajemen Siswa di Kelas
| ID | Fitur | Deskripsi |
|---|---|---|
| GR-01 | Tambah Siswa | Tambah siswa baru ke kelas yang diajar (nama, NIS, foto opsional) |
| GR-02 | Edit Data Siswa | Ubah nama, NIS, atau info siswa |
| GR-03 | Hapus Siswa | Soft-delete siswa yang sudah tidak belajar; data absensi tetap ada |
| GR-04 | Import Siswa | Upload file CSV untuk tambah siswa massal |
| GR-05 | Cari & Filter Siswa | Cari berdasarkan nama atau NIS di dalam kelas |

#### Modul Absensi
| ID | Fitur | Deskripsi |
|---|---|---|
| GR-06 | Generate QR Code | Buat QR Code unik per sesi absensi (kelas + tanggal + waktu) |
| GR-07 | Timer QR Code | QR Code aktif selama durasi yang ditentukan guru (5–60 menit) |
| GR-08 | Tampilan QR Layar Penuh | Mode fullscreen untuk ditampilkan di proyektor atau monitor kelas |
| GR-09 | Rekap Absensi Real-time | Daftar siswa yang sudah dan belum scan, update otomatis tanpa refresh |
| GR-10 | Override Status Manual | Ubah status kehadiran siswa secara manual (Hadir/Izin/Sakit/Alpha) |
| GR-11 | Tambah Catatan Absensi | Isi keterangan tambahan per siswa per hari (misal: "Sakit — ada surat") |
| GR-12 | Riwayat Absensi Kelas | Lihat rekap kehadiran kelas per hari/minggu/bulan |
| GR-13 | Absensi Tanggal Lampau | Isi atau koreksi absensi untuk tanggal yang sudah lewat |

---

### 3.4 Modul Siswa

| ID | Fitur | Deskripsi |
|---|---|---|
| SW-01 | Halaman Status Hari Ini | Tampilkan status kehadiran hari ini (Hadir / Belum Hadir / Izin, dll.) |
| SW-02 | Scan QR Code | Buka kamera dan scan QR yang ditampilkan guru |
| SW-03 | Konfirmasi Kehadiran | Setelah scan berhasil, muncul konfirmasi "✓ Kehadiran tercatat!" |
| SW-04 | Riwayat Kehadiran | Lihat histori kehadiran 3 bulan terakhir, dengan filter per bulan |
| SW-05 | Statistik Pribadi | Persentase kehadiran, total Hadir/Izin/Sakit/Alpha dalam bulan berjalan |
| SW-06 | Edit Profil | Ubah foto profil dan password akun sendiri |

---

### 3.5 Sistem Autentikasi

| ID | Fitur | Deskripsi |
|---|---|---|
| AUTH-01 | Login Multi-Role | Satu halaman login, sistem deteksi role otomatis dan redirect ke dashboard masing-masing |
| AUTH-02 | Logout Aman | Hapus session dan redirect ke halaman login |
| AUTH-03 | Lupa Password | Reset via email (link reset berumur 60 menit) |
| AUTH-04 | Session Timeout | Session kadaluarsa setelah 2 jam tidak aktif |
| AUTH-05 | Remember Me | Opsi "Ingat saya" untuk login selama 7 hari di perangkat yang sama |
| AUTH-06 | Guard Middleware | Proteksi route berdasarkan role: admin, guru, siswa |

---

### 3.6 Sistem QR Code (Detail Teknis)

**Cara Kerja:**

1. Guru membuka halaman absensi untuk kelasnya hari ini
2. Guru klik "Mulai Absensi" → sistem membuat token unik (UUID v4) yang disimpan di tabel `attendance_sessions`
3. Token dikodekan menjadi URL: `https://domain.com/absen/{token}`
4. URL tersebut di-render sebagai QR Code di layar guru (bisa fullscreen)
5. QR Code punya TTL (Time To Live) sesuai setting guru, setelah kadaluarsa QR tidak dapat digunakan
6. Siswa scan QR → browser terbuka ke URL token → sistem verifikasi:
   - Token masih valid (belum expired)?
   - Siswa login? (jika belum, redirect login dulu, kemudian balik ke URL token)
   - Siswa terdaftar di kelas yang dimaksud?
   - Siswa belum tercatat hadir di sesi ini?
7. Jika semua lolos → status siswa diubah ke `hadir` → halaman konfirmasi tampil

**Perlindungan dari Kecurangan:**
- QR Code memiliki TTL yang bisa diatur guru (default 15 menit)
- Satu token hanya bisa digunakan satu kali per siswa
- Log IP address dan user-agent setiap scan
- Guru dapat melihat timestamp kapan siswa scan

---

## 4. User Flow

### 4.1 Flow: Admin Login & Kelola Guru

```
[Landing Page]
      │
      ▼
[Halaman Login]
      │ isi email + password (role: admin)
      ▼
[Dashboard Admin]
      │
      ├──► [Menu: Manajemen Guru]
      │           │
      │           ├──► [Daftar Guru] ──► [Tambah Guru] ──► [Form Isian]
      │           │                                              │
      │           │                                         [Simpan] ──► [Notif: Guru Ditambahkan]
      │           │
      │           └──► [Klik Guru] ──► [Detail Guru] ──► [Edit] / [Nonaktifkan]
      │
      └──► [Menu: Laporan] ──► [Pilih Kelas + Rentang Tanggal] ──► [Tabel Rekap] ──► [Export PDF/Excel]
```

---

### 4.2 Flow: Guru — Setup Absensi dengan QR Code

```
[Login sebagai Guru]
      │
      ▼
[Dashboard Guru]
      │ lihat ringkasan: berapa siswa sudah hadir hari ini
      ▼
[Menu: Absensi → Kelas X-IPA-1 → Hari Ini]
      │
      ▼
[Halaman Sesi Absensi]
      │
      ├── Jika belum ada sesi hari ini:
      │       [Tombol: Mulai Absensi]
      │              │
      │              ▼
      │       [Modal: Atur Durasi QR (5/15/30/60 menit)]
      │              │
      │              ▼
      │       [QR Code Muncul] ◄─── timer countdown aktif
      │              │
      │              ├──► [Tombol: Fullscreen] → QR Code tampil penuh di layar
      │              │
      │              └──► Daftar siswa ter-update real-time (polling tiap 5 detik):
      │                      [✓] Budi Santoso — 08:02 WIB
      │                      [✓] Ani Rahayu   — 08:04 WIB
      │                      [ ] Citra Dewi   — (belum hadir)
      │
      └── Setelah QR expired / guru klik "Tutup Sesi":
              │
              ▼
      [Rekap Akhir Sesi]
              │
              ├──► Siswa yang belum hadir → otomatis status "Alpha"
              └──► Guru dapat override manual sebelum "Simpan Final"
```

---

### 4.3 Flow: Siswa — Scan QR & Catat Kehadiran

```
[Siswa buka HP, arahkan kamera ke QR Code di layar guru]
      │
      ▼
[Browser buka: https://domain.com/absen/{token}]
      │
      ├── Belum Login?
      │       ▼
      │   [Redirect ke halaman login siswa]
      │       │ isi NIS + password
      │       ▼
      │   [Redirect kembali ke URL token]
      │
      ├── Sudah Login ──► Sistem verifikasi token:
      │
      │   [Token valid & belum expired & siswa di kelas ini & belum scan?]
      │         │ Ya                              │ Tidak
      │         ▼                                 ▼
      │   [Status diubah → "Hadir"]        [Halaman Error sesuai kondisi]
      │         │                          • "QR sudah expired"
      │         ▼                          • "Kamu sudah tercatat hadir"
      │   [Halaman Konfirmasi]             • "Kamu bukan bagian kelas ini"
      │   ✓ Kehadiran Tercatat!
      │   Budi Santoso · X-IPA-1
      │   Senin, 4 Sep 2026 · 08:02 WIB
      │         │
      │         ▼
      │   [Tombol: Lihat Riwayat Kehadiran]
      │
      ▼
[Dashboard Siswa]
```

---

### 4.4 Flow: Siswa — Lihat Riwayat Kehadiran

```
[Dashboard Siswa]
      │
      ▼
[Menu: Riwayat Kehadiran]
      │
      ▼
[Filter: Pilih Bulan] ──► [Tabel Riwayat]
      │
      │  Tabel berisi:
      │  Tanggal | Mata Pelajaran | Status    | Keterangan
      │  01 Sep  | Matematika     | ✓ Hadir   | —
      │  02 Sep  | Matematika     | ~ Izin    | Keperluan keluarga
      │  03 Sep  | Matematika     | ✗ Alpha   | —
      │
      ▼
[Statistik Bulan Ini]
  Hadir : 18 hari (90%)
  Izin  :  1 hari  (5%)
  Sakit :  0 hari  (0%)
  Alpha :  1 hari  (5%)
```

---

### 4.5 Flow: Guru — Kelola Data Siswa

```
[Dashboard Guru]
      │
      ▼
[Menu: Data Siswa → Kelas X-IPA-1]
      │
      ├──► [Tambah Siswa]
      │         │ isi: Nama, NIS, email/password awal, foto (opsional)
      │         ▼
      │    [Siswa terdaftar, bisa langsung login]
      │
      ├──► [Import CSV] ──► [Upload file] ──► [Preview data] ──► [Konfirmasi Import]
      │
      ├──► [Klik siswa] ──► [Detail Siswa]
      │                           │
      │                    ├──► [Edit Data]
      │                    ├──► [Lihat Riwayat Absensi Siswa]
      │                    └──► [Hapus Siswa] ──► [Modal Konfirmasi]
      │                                              "Data absensi tetap tersimpan"
      │                                                    │
      │                                               [Ya, Hapus]
      │
      └──► [Kembali ke Dashboard]
```

---

## 5. Struktur Database

### 5.1 ERD Ringkas
```
users ──────────── roles
  │
  ├── [admin]
  │
  ├── [guru] ─────── kelas (wali_kelas_id / mengajar_di)
  │                    │
  │                    └─── siswa ──── attendance_records
  │                                          │
  │                                   attendance_sessions
  │
  └── [siswa] ─────── attendance_records
```

### 5.2 Tabel Utama

```sql
-- Pengguna (semua role dalam satu tabel)
CREATE TABLE users (
  id            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(100) NOT NULL,
  email         VARCHAR(100) UNIQUE NOT NULL,
  password      VARCHAR(255) NOT NULL,
  role          ENUM('admin','guru','siswa') NOT NULL DEFAULT 'siswa',
  nis           VARCHAR(20) NULL,        -- khusus siswa
  nip           VARCHAR(20) NULL,        -- khusus guru
  photo         VARCHAR(255) NULL,
  is_active     BOOLEAN DEFAULT TRUE,
  remember_token VARCHAR(100) NULL,
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Kelas
CREATE TABLE kelas (
  id            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama_kelas    VARCHAR(50) NOT NULL,    -- contoh: "X-IPA-1"
  tingkat       VARCHAR(5) NOT NULL,     -- contoh: "X", "XI", "XII"
  jurusan       VARCHAR(50) NULL,        -- contoh: "IPA", "IPS"
  tahun_ajaran  VARCHAR(10) NOT NULL,    -- contoh: "2025/2026"
  wali_kelas_id BIGINT UNSIGNED NULL,
  is_active     BOOLEAN DEFAULT TRUE,
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (wali_kelas_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Relasi guru mengajar di kelas (bisa banyak-banyak)
CREATE TABLE guru_kelas (
  id        BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  guru_id   BIGINT UNSIGNED NOT NULL,
  kelas_id  BIGINT UNSIGNED NOT NULL,
  UNIQUE KEY unique_guru_kelas (guru_id, kelas_id),
  FOREIGN KEY (guru_id)  REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE
);

-- Relasi siswa terdaftar di kelas
CREATE TABLE siswa_kelas (
  id        BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  siswa_id  BIGINT UNSIGNED NOT NULL,
  kelas_id  BIGINT UNSIGNED NOT NULL,
  joined_at DATE NOT NULL,
  left_at   DATE NULL,             -- diisi jika siswa pindah/keluar
  UNIQUE KEY unique_siswa_kelas_aktif (siswa_id, kelas_id),
  FOREIGN KEY (siswa_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE
);

-- Sesi absensi (tiap QR Code = satu sesi)
CREATE TABLE attendance_sessions (
  id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  token       CHAR(36) UNIQUE NOT NULL,   -- UUID v4
  kelas_id    BIGINT UNSIGNED NOT NULL,
  guru_id     BIGINT UNSIGNED NOT NULL,
  tanggal     DATE NOT NULL,
  starts_at   DATETIME NOT NULL,
  expires_at  DATETIME NOT NULL,           -- starts_at + durasi
  is_closed   BOOLEAN DEFAULT FALSE,       -- ditutup manual oleh guru
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (kelas_id) REFERENCES kelas(id),
  FOREIGN KEY (guru_id)  REFERENCES users(id)
);

-- Rekaman kehadiran per siswa
CREATE TABLE attendance_records (
  id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  session_id   BIGINT UNSIGNED NOT NULL,
  siswa_id     BIGINT UNSIGNED NOT NULL,
  kelas_id     BIGINT UNSIGNED NOT NULL,
  tanggal      DATE NOT NULL,
  status       ENUM('hadir','izin','sakit','alpha','belum_hadir') DEFAULT 'belum_hadir',
  scan_at      DATETIME NULL,              -- waktu scan QR
  scan_ip      VARCHAR(45) NULL,           -- IP address saat scan
  override_by  BIGINT UNSIGNED NULL,       -- guru yang override manual
  catatan      TEXT NULL,
  created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY unique_siswa_session (siswa_id, session_id),
  FOREIGN KEY (session_id) REFERENCES attendance_sessions(id),
  FOREIGN KEY (siswa_id)   REFERENCES users(id),
  FOREIGN KEY (kelas_id)   REFERENCES kelas(id),
  FOREIGN KEY (override_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Log aktivitas (audit trail)
CREATE TABLE activity_logs (
  id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id     BIGINT UNSIGNED NULL,
  action      VARCHAR(100) NOT NULL,       -- contoh: "hapus_siswa", "override_status"
  target_type VARCHAR(50) NULL,            -- contoh: "users", "attendance_records"
  target_id   BIGINT UNSIGNED NULL,
  detail      JSON NULL,                   -- data sebelum & sesudah perubahan
  ip_address  VARCHAR(45) NULL,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

---

## 6. Arsitektur & Tech Stack

### 6.1 Stack Detail

| Layer | Teknologi | Versi |
|---|---|---|
| **Backend Framework** | Laravel | 11.x |
| **Bahasa** | PHP | 8.2+ |
| **Database** | MySQL | 8.0 |
| **Frontend Templating** | Blade (Laravel built-in) | — |
| **CSS Framework** | Tailwind CSS | 3.x (via CDN Play) |
| **JavaScript** | Alpine.js | 3.x (via CDN) |
| **QR Generator** | `simplesoftwareio/simple-qrcode` | Composer |
| **QR Scanner** | `html5-qrcode` | CDN (JS library) |
| **Excel Export** | `maatwebsite/excel` | Composer |
| **PDF Export** | `barryvdh/laravel-dompdf` | Composer |
| **Real-time Polling** | JavaScript `setInterval` (polling API) | — |
| **Hosting** | InfinityFree | — |

> **Catatan InfinityFree:** InfinityFree mendukung PHP 8.x dan MySQL. Beberapa keterbatasan:
> - **Tidak ada SSH** → deployment via FTP/cPanel file manager
> - **Cron job terbatas** → gunakan fake cron via request atau external cron service
> - **Email** → gunakan SMTP eksternal (Gmail SMTP / Mailtrap untuk dev)
> - **Storage** → upload foto dikompresi; pertimbangkan CDN untuk gambar
> - Nonaktifkan `APP_DEBUG=false` di production dan set `APP_ENV=production`

### 6.2 Struktur Direktori Laravel (Ringkas)
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── GuruController.php
│   │   │   ├── KelasController.php
│   │   │   └── LaporanController.php
│   │   ├── Guru/
│   │   │   ├── DashboardController.php
│   │   │   ├── SiswaController.php
│   │   │   └── AbsensiController.php
│   │   └── Siswa/
│   │       ├── DashboardController.php
│   │       └── RiwayatController.php
│   └── Middleware/
│       ├── AdminMiddleware.php
│       ├── GuruMiddleware.php
│       └── SiswaMiddleware.php
├── Models/
│   ├── User.php
│   ├── Kelas.php
│   ├── AttendanceSession.php
│   ├── AttendanceRecord.php
│   └── ActivityLog.php
resources/
└── views/
    ├── layouts/
    │   ├── app.blade.php       (dashboard layout)
    │   └── landing.blade.php   (public layout)
    ├── landing/
    ├── auth/
    ├── admin/
    ├── guru/
    └── siswa/
routes/
├── web.php                      (semua route)
└── api.php                      (endpoint polling real-time)
```

### 6.3 Route Utama

```php
// Public
GET  /                    → Landing Page
GET  /login               → Form Login
POST /login               → Proses Login
GET  /absen/{token}       → Siswa scan QR (redirect login jika belum)

// Admin (prefix: /admin, middleware: auth, role:admin)
GET  /admin/dashboard
GET  /admin/guru
POST /admin/guru
GET  /admin/guru/{id}/edit
GET  /admin/kelas
GET  /admin/laporan

// Guru (prefix: /guru, middleware: auth, role:guru)
GET  /guru/dashboard
GET  /guru/kelas/{kelasId}/siswa
POST /guru/kelas/{kelasId}/siswa
GET  /guru/absensi/{kelasId}
POST /guru/absensi/mulai
GET  /guru/absensi/session/{token}/status  (API polling)
PUT  /guru/absensi/record/{id}/override

// Siswa (prefix: /siswa, middleware: auth, role:siswa)
GET  /siswa/dashboard
GET  /siswa/riwayat
GET  /siswa/profil
```

---

## 7. Status Kehadiran

| Status | Kode | Warna | Siapa yang Set |
|---|---|---|---|
| Hadir | `hadir` | Hijau (#10B981) | Otomatis via scan QR atau override guru |
| Izin | `izin` | Kuning (#F59E0B) | Override manual oleh guru |
| Sakit | `sakit` | Biru (#3B82F6) | Override manual oleh guru |
| Alpha | `alpha` | Merah (#F43F5E) | Otomatis saat sesi ditutup & siswa belum scan |
| Belum Hadir | `belum_hadir` | Abu (#64748B) | Default saat sesi dimulai |

---

## 8. Keamanan & Validasi

| Aspek | Implementasi |
|---|---|
| **Autentikasi** | Laravel built-in Auth dengan session-based login |
| **Otorisasi** | Middleware per role + Gate/Policy Laravel |
| **CSRF Protection** | Token CSRF di semua form (Laravel default) |
| **SQL Injection** | Eloquent ORM + Query Builder (prepared statements) |
| **XSS** | Blade templating auto-escape `{{ }}` |
| **QR Token** | UUID v4 (tidak bisa ditebak), TTL ketat, one-use per siswa |
| **Password** | Bcrypt hashing via Laravel Hash facade |
| **Input Validation** | Laravel Form Request Validation di semua endpoint |
| **Rate Limiting** | Throttle middleware di endpoint scan QR |
| **Audit Log** | Semua aksi sensitif dicatat di tabel `activity_logs` |

---

## 9. Non-Functional Requirements

| Aspek | Target |
|---|---|
| **Performa** | Halaman load < 3 detik pada koneksi 4G |
| **Kompatibilitas Browser** | Chrome, Firefox, Safari (desktop & mobile) |
| **Responsif** | Mobile-first, breakpoint: sm (640px), md (768px), lg (1024px) |
| **Skalabilitas** | Rancangan DB mendukung hingga 2.000 siswa, 100 guru |
| **Aksesibilitas** | Kontras warna minimum WCAG AA, navigasi keyboard di form |
| **Uptime** | Bergantung SLA InfinityFree (best-effort, free tier) |

---

## 10. Milestones Pengembangan

| Fase | Cakupan | Estimasi |
|---|---|---|
| **Fase 0** | Setup project Laravel, database migration, seeder data awal | 3 hari |
| **Fase 1** | Autentikasi multi-role, landing page, routing & middleware | 4 hari |
| **Fase 2** | Modul Admin: CRUD guru, kelas, laporan dasar | 5 hari |
| **Fase 3** | Modul Guru: CRUD siswa, generate QR, sesi absensi real-time | 7 hari |
| **Fase 4** | Modul Siswa: scan QR, konfirmasi, riwayat kehadiran | 4 hari |
| **Fase 5** | Export PDF/Excel, pengaturan sekolah, audit log | 3 hari |
| **Fase 6** | Testing, bug fix, optimasi performa, deploy InfinityFree | 4 hari |
| **Total** | | **± 30 hari kerja** |

---

## 11. Glosarium

| Istilah | Definisi |
|---|---|
| **Sesi Absensi** | Satu periode absensi yang dimulai guru dengan QR Code untuk satu kelas pada satu hari |
| **Token QR** | UUID unik yang dikodekan dalam QR Code dan berlaku selama TTL yang ditentukan |
| **TTL** | Time To Live — durasi validitas QR Code |
| **Override** | Perubahan status kehadiran secara manual oleh guru |
| **Soft Delete** | Menandai data sebagai terhapus (`is_active = false`) tanpa benar-benar menghapus dari database |
| **Polling** | Teknik di mana browser secara berkala meminta data terbaru ke server (tiap N detik) |
| **NIS** | Nomor Induk Siswa |
| **NIP** | Nomor Induk Pegawai (untuk guru) |

---

*Dokumen ini adalah living document. Perubahan scope, fitur, atau prioritas dicatat dengan menambahkan versi baru di bagian atas dokumen.*