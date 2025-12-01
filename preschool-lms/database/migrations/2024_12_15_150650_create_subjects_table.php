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
        // Create the subjects table
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Subject name (e.g., Math, English)
            $table->string('code')->unique(); // Unique subject code (e.g., MATH101)
            $table->decimal('units', 3, 1)->unsigned(); // e.g., 3.0
            $table->decimal('fee', 10, 2)->nullable(); // optional
            $table->foreignId('grade_level_id')
                ->constrained('grade_levels')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // 👇 prerequisite_id column + foreign key
            $table->foreignId('prerequisite_id')
                ->nullable()
                ->constrained('subjects')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');         // Drop subjects table
    }
};
