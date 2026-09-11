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
            
            // Waktu Pertandingan Spesifik
            $table->date('match_date');
            $table->time('match_time');
            
            // Senshu Single Selection ('aka', 'ao', or null)
            $table->string('senshu_corner')->nullable();

            // Stats AKA (Sudut Merah)
            $table->integer('aka_ippon')->default(0);
            $table->integer('aka_wazaari')->default(0);
            $table->integer('aka_yuko')->default(0);
            $table->integer('aka_c1')->default(0);
            $table->integer('aka_c2')->default(0);
            $table->boolean('aka_ce')->default(false);
            $table->boolean('aka_hc')->default(false);
            $table->boolean('aka_h')->default(false);
            $table->integer('aka_score_attack')->default(0);
            $table->integer('aka_score_accuracy')->default(0);
            $table->integer('aka_total_score')->default(0);
            $table->text('aka_evaluation_notes')->nullable();

            // Stats AO (Sudut Biru)
            $table->integer('ao_ippon')->default(0);
            $table->integer('ao_wazaari')->default(0);
            $table->integer('ao_yuko')->default(0);
            $table->integer('ao_c1')->default(0);
            $table->integer('ao_c2')->default(0);
            $table->boolean('ao_ce')->default(false);
            $table->boolean('ao_hc')->default(false);
            $table->boolean('ao_h')->default(false);
            $table->integer('ao_score_attack')->default(0);
            $table->integer('ao_score_accuracy')->default(0);
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
