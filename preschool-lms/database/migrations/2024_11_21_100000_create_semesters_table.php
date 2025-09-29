<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();

            // e.g., "2025-2026"
            $table->string('academic_year');  

            // Restrict to known term codes to keep format consistent
            $table->enum('semester', ['1st', '2nd', 'Summer']); 
            // if you’re absolutely sure you’ll never have Summer, remove it

            $table->date('start_date'); 
            $table->date('end_date');

            // Let admin control the state of the semester (not just dates)
            $table->enum('status', ['upcoming', 'active', 'closed'])->default('upcoming');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
}
