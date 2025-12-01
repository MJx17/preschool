<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_offering_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('topic')->nullable(); // optional - what was taught
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('attendance_sessions');
    }
};
