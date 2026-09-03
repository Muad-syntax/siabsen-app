<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Kelas
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas', 50);
            $table->string('tingkat', 5);
            $table->string('jurusan', 50)->nullable();
            $table->string('tahun_ajaran', 10);
            $table->foreignId('wali_kelas_id')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Relasi Guru Mengajar di Kelas
        Schema::create('guru_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->unique(['guru_id', 'kelas_id']);
        });

        // Relasi Siswa Terdaftar di Kelas
        Schema::create('siswa_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->date('joined_at');
            $table->date('left_at')->nullable();
        });

        // Sesi Absensi (QR Code per Sesi)
        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->id();
            $table->char('token', 36)->unique();
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->foreignId('guru_id')->constrained('users');
            $table->date('tanggal');
            $table->dateTime('starts_at');
            $table->dateTime('expires_at');
            $table->boolean('is_closed')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });

        // Rekaman Kehadiran Siswa
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('attendance_sessions')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha', 'belum_hadir'])->default('belum_hadir');
            $table->dateTime('scan_at')->nullable();
            $table->string('scan_ip', 45)->nullable();
            $table->foreignId('override_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['siswa_id', 'session_id']);
        });

        // Activity Logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action', 100);
            $table->string('target_type', 50)->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
            $table->json('detail')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('attendance_records');
        Schema::dropIfExists('attendance_sessions');
        Schema::dropIfExists('siswa_kelas');
        Schema::dropIfExists('guru_kelas');
        Schema::dropIfExists('kelas');
    }
};
