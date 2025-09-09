<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Lesson title
            $table->text('description')->nullable(); // Details about the lesson
            $table->string('file_path')->nullable(); // Store file path (pdf, docx, etc.)
            $table->string('video_url')->nullable(); // Optional video link (YouTube, Vimeo)
            $table->enum('type', ['activity', 'lecture', 'quiz'])->default('lecture'); // Lesson type
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade'); // Who created it
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
