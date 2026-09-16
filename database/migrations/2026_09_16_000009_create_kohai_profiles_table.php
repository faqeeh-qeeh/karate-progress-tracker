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
        Schema::create('kohai_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->enum('type', ['polindra', 'non_polindra'])->default('polindra');
            $table->foreignId('rank_id')->nullable()->constrained('ranks')->onDelete('set null');
            
            // Khusus Kohai Polindra
            $table->foreignId('study_program_id')->nullable()->constrained('study_programs')->onDelete('set null');
            $table->foreignId('academic_class_id')->nullable()->constrained('academic_classes')->onDelete('set null');
            $table->string('nim')->nullable();
            $table->unsignedSmallInteger('enrollment_year')->nullable();
            $table->string('high_school')->nullable();

            // Khusus Kohai Luar Polindra
            $table->string('institution')->nullable();

            // Fisik & Kontak Darurat (Opsional)
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kohai_profiles');
    }
};
