<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AbsenController;

// Controllers - Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GuruController as AdminGuruController;
use App\Http\Controllers\Admin\KelasController as AdminKelasController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;

// Controllers - Guru
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\SiswaController as GuruSiswaController;
use App\Http\Controllers\Guru\AbsensiController as GuruAbsensiController;

// Controllers - Siswa
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\RiwayatController as SiswaRiwayatController;
use App\Http\Controllers\Siswa\ProfilController as SiswaProfilController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Route khusus untuk reset dan seed database tanpa perlu terminal
Route::get('/setup-db', function () {
    try {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        $tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
        $dbName = \Illuminate\Support\Facades\DB::getDatabaseName();
        $keyName = "Tables_in_" . $dbName;

        foreach ($tables as $table) {
            $tableName = $table->$keyName ?? array_values((array)$table)[0];
            \Illuminate\Support\Facades\Schema::dropIfExists($tableName);
        }
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);

        return response('
            <div style="font-family: sans-serif; padding: 40px; text-align: center; background: #EFF6FF; color: #0F2D4A;">
                <div style="max-width: 480px; margin: 0 auto; background: white; padding: 30px; border-radius: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
                    <div style="font-size: 40px; margin-bottom: 15px;">🎉</div>
                    <h1 style="color: #0F2D4A; font-size: 22px; margin-bottom: 10px;">Database Berhasil Di-Reset & Di-Seed!</h1>
                    <p style="font-size: 13px; color: #64748B; line-height: 1.6;">Seluruh tabel lama telah dibersihkan. Skema baru PRD dan data seeder awal (Admin, Guru, Kelas, Siswa) telah dibuat.</p>
                    <div style="margin-top: 25px;">
                        <a href="/login" style="background: #2563EB; color: white; padding: 12px 24px; text-decoration: none; border-radius: 12px; font-weight: bold; font-size: 13px; display: inline-block;">
                            Ke Halaman Login →
                        </a>
                    </div>
                </div>
            </div>
        ', 200);
    } catch (\Exception $e) {
        return response('
            <div style="font-family: sans-serif; padding: 40px; text-align: center; color: #F43F5E;">
                <h1>Gagal Reset Database</h1>
                <p>' . htmlspecialchars($e->getMessage()) . '</p>
            </div>
        ', 500);
    }
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Direct QR Absen link for students
Route::get('/absen/{token}', [AbsenController::class, 'scan'])->name('absen.scan');

// Dashboard helper redirect for general /dashboard route
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (!$user) return redirect()->route('login');
    if ($user->isAdmin()) return redirect()->route('admin.dashboard');
    if ($user->isGuru()) return redirect()->route('guru.dashboard');
    if ($user->isSiswa()) return redirect()->route('siswa.dashboard');
    return redirect('/');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes (role: admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Guru CRUD
    Route::get('/guru', [AdminGuruController::class, 'index'])->name('guru.index');
    Route::post('/guru', [AdminGuruController::class, 'store'])->name('guru.store');
    Route::get('/guru/{id}/edit', [AdminGuruController::class, 'edit'])->name('guru.edit');
    Route::put('/guru/{id}', [AdminGuruController::class, 'update'])->name('guru.update');
    Route::delete('/guru/{id}', [AdminGuruController::class, 'destroy'])->name('guru.destroy');
    Route::delete('/guru/{id}/permanent', [AdminGuruController::class, 'deletePermanent'])->name('guru.delete-permanent');
    Route::post('/guru/{id}/reset-password', [AdminGuruController::class, 'resetPassword'])->name('guru.reset-password');

    // Kelas CRUD
    Route::get('/kelas', [AdminKelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas', [AdminKelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelas/{id}/edit', [AdminKelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/{id}', [AdminKelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{id}', [AdminKelasController::class, 'destroy'])->name('kelas.destroy');
    Route::delete('/kelas/{id}/permanent', [AdminKelasController::class, 'deletePermanent'])->name('kelas.delete-permanent');

    // Siswa Global
    Route::get('/siswa', [AdminSiswaController::class, 'index'])->name('siswa.index');

    // Laporan & Export
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export/pdf', [AdminLaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
    Route::get('/laporan/export/excel', [AdminLaporanController::class, 'exportExcel'])->name('laporan.export.excel');

    // Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'store'])->name('settings.store');
});

/*
|--------------------------------------------------------------------------
| Guru Routes (role: guru)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

    // Siswa Management
    Route::get('/kelas/{kelasId}/siswa', [GuruSiswaController::class, 'index'])->name('siswa.index');
    Route::post('/kelas/{kelasId}/siswa', [GuruSiswaController::class, 'store'])->name('siswa.store');
    Route::post('/kelas/{kelasId}/siswa/import', [GuruSiswaController::class, 'importCsv'])->name('siswa.import');
    Route::delete('/siswa/{id}', [GuruSiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::delete('/siswa/{id}/permanent', [GuruSiswaController::class, 'deletePermanent'])->name('siswa.delete-permanent');

    // Absensi Sesi
    Route::get('/absensi', [GuruAbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/mulai', [GuruAbsensiController::class, 'startSession'])->name('absensi.mulai');
    Route::get('/absensi/session/{token}', [GuruAbsensiController::class, 'showSession'])->name('absensi.session');
    Route::post('/absensi/session/{token}/tutup', [GuruAbsensiController::class, 'closeSession'])->name('absensi.tutup');
    Route::post('/absensi/record/{id}/override', [GuruAbsensiController::class, 'overrideRecord'])->name('absensi.override');
    Route::get('/absensi/riwayat', [GuruAbsensiController::class, 'riwayat'])->name('absensi.riwayat');
});

/*
|--------------------------------------------------------------------------
| Siswa Routes (role: siswa)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/riwayat', [SiswaRiwayatController::class, 'index'])->name('riwayat');
    Route::get('/profil', [SiswaProfilController::class, 'index'])->name('profil');
    Route::post('/profil', [SiswaProfilController::class, 'update'])->name('profil.update');
});