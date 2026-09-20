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
        Schema::create('kumite_senshu_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kumite_report_id')->constrained('kumite_reports')->onDelete('cascade');
            $table->integer('sequence')->default(1); // Urutan log: 1, 2, 3...
            $table->string('corner')->nullable(); // 'aka', 'ao', or null (tidak ada)
            $table->enum('status', ['active', 'cancelled', 'none'])->default('active');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kumite_senshu_logs');
    }
};
