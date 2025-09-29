<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('lesson_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('cascade'); // quiz belongs to a lesson
            $table->integer('time_limit')->nullable(); // in minutes

            $table->enum('status', ['draft', 'published', 'archived'])
                  ->default('draft'); // 👈 status column

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
