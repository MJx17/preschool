<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            // Student relationship
            $table->foreignId('student_id')
                ->constrained('students')
                ->onDelete('cascade');

            // Semester relationship
            $table->foreignId('semester_id')
                ->nullable()
                ->constrained('semesters')
                ->onDelete('set null');

            // Grade level
            $table->foreignId('grade_level_id')
                ->constrained('grade_levels');

            // Section (new)
            $table->foreignId('section_id')
                ->nullable()
                ->constrained('sections')
                ->onDelete('set null');

            // Category enum
            $table->enum('category', ['new', 'old', 'shifter'])->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('enrollment_subjects'); // Drop pivot table first
        Schema::dropIfExists('enrollments');        // Then drop enrollments table
    }
}
