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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('subject_id');
        
            // Per grading period
            $table->integer('first_grading')->nullable();
            $table->integer('second_grading')->nullable();
            $table->integer('third_grading')->nullable();
            $table->integer('fourth_grading')->nullable();
        
            // Final / overall grade
            $table->integer('final_grade')->nullable();
        
            // Optional remarks
            $table->string('remarks')->nullable();
        
            $table->timestamps();
        
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
