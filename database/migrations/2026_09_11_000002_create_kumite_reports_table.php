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
        Schema::create('kumite_reports', function (Blueprint $table) {
            $table->id();
            
            // Relasi Entitas Pertandingan
            $table->foreignId('senpai_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('aka_kohai_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ao_kohai_id')->constrained('users')->onDelete('cascade');
            
            // Waktu Pertandingan Spesifik & Durasi
            $table->date('match_date');
            $table->time('match_time');
            $table->integer('duration_seconds')->default(180); // Durasi tanding (detik), default 3 menit
            
            // Senshu Single Selection ('aka', 'ao', or null)
            $table->string('senshu_corner')->nullable();

            // Stats AKA (Sudut Merah)
            $table->integer('aka_ippon')->default(0);
            $table->integer('aka_wazaari')->default(0);
            $table->integer('aka_yuko')->default(0);
            $table->integer('aka_fouls')->default(0); // Poin Pelanggaran (0 - 5)
            $table->integer('aka_score_attack')->default(0);
            $table->decimal('aka_score_accuracy', 5, 2)->default(0);
            $table->integer('aka_total_score')->default(0);
            $table->text('aka_evaluation_notes')->nullable();

            // Stats AO (Sudut Biru)
            $table->integer('ao_ippon')->default(0);
            $table->integer('ao_wazaari')->default(0);
            $table->integer('ao_yuko')->default(0);
            $table->integer('ao_fouls')->default(0); // Poin Pelanggaran (0 - 5)
            $table->integer('ao_score_attack')->default(0);
            $table->decimal('ao_score_accuracy', 5, 2)->default(0);
            $table->integer('ao_total_score')->default(0);
            $table->text('ao_evaluation_notes')->nullable();

            // Pemenang
            $table->foreignId('winner_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kumite_reports');
    }
};
