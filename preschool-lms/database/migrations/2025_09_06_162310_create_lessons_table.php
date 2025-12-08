<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  

    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Lesson title
            $table->text('description')->nullable(); // Details about the lesson
            $table->string('image_url')->nullable(); // Thumbnail / image URL
            $table->string('video_url')->nullable(); // Video URL (YouTube, Vimeo, Drive, etc.)
            $table->string('document_url')->nullable(); // Document URL (PDF, Google Docs, etc.)
            $table->timestamps();
            $table->enum('quarter', ['1', '2', '3', '4'])->nullable()->after('subject_offerings_id');
            $table->foreignId('subject_offerings_id')
                ->constrained()
                ->onDelete('cascade');
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
