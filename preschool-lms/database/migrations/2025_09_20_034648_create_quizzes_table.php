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

            // Optional lesson reference
            $table->foreignId('lesson_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            // Required subject offering reference

            $table->integer('time_limit')->nullable(); // in minutes

            // Status enum
            $table->enum('status', ['draft', 'published', 'archived'])
                ->default('draft');

            // Type enum for low grade levels
            $table->enum('type', ['short', 'long'])
                ->default('short');

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
