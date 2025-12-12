<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject_offerings', function (Blueprint $table) {
            $table->id();

            // FK references
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');

            // Remove block string, optional: keep section_id if you want per-section offering
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('set null');

            $table->json('days')->nullable(); // store selected days
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_offerings');
    }
};
