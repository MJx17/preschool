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

            // Single field storing both semester + academic year, e.g. "1st Semester 2025-2026"
            $table->string('semester')->unique();

            $table->date('start_date');
            $table->date('end_date');

            // Control semester status
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
