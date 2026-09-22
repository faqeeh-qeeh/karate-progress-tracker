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
        Schema::create('training_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            // Jenis latihan
            $table->enum('type', ['rutin', 'tambahan'])->default('rutin');
            $table->string('title'); // Nama/judul jadwal

            // Waktu
            $table->time('start_time');                     // Jam mulai (wajib)
            $table->time('end_time')->nullable();           // Jam selesai (opsional)

            // Untuk latihan RUTIN: hari-hari dalam seminggu
            $table->json('days_of_week')->nullable();       // e.g. ["Senin","Rabu","Jumat"]

            // Periode berlaku (untuk rutin & tambahan)
            $table->date('start_date');                     // Berlaku mulai
            $table->date('end_date')->nullable();           // Berlaku sampai (opsional)

            // Untuk latihan TAMBAHAN: tanggal spesifik
            $table->date('specific_date')->nullable();

            // Lokasi
            $table->enum('location_type', ['polindra', 'luar_polindra'])->default('polindra');
            $table->string('location_detail')->nullable();  // Detail: gedung/lantai/lapangan
            $table->string('maps_url')->nullable();         // Google Maps link (opsional)

            // Pengingat email
            $table->boolean('email_reminder')->default(false);
            // Opsi waktu kirim: 'pagi' = 06:00 hari H, 'malam' = 20:00 malam sebelumnya
            $table->enum('reminder_time', ['pagi', 'malam'])->nullable();

            $table->text('notes')->nullable();              // Catatan tambahan
            $table->boolean('is_active')->default(true);   // Status aktif

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_schedules');
    }
};
