<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    protected $table = 'homeworks'; // ✅ force correct table

    protected $fillable = [
        'title',
        'instructions',
        'file_url',
        'video_url',
        'due_date',
        'lesson_id',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }



    public function teacher()
    {
        return $this->hasOneThrough(
            Teacher::class,
            Lesson::class,
            'id', // Foreign key on Lesson
            'id', // Foreign key on Teacher
            'lesson_id', // Local key on Homework
            'teacher_id' // Local key on Lesson
        );
    }

    public function subjectOffering()
    {
        return $this->hasOneThrough(
            SubjectOffering::class,
            Lesson::class,
            'id', // Foreign key on Lesson
            'id', // Foreign key on SubjectOffering
            'lesson_id', // Local key on Homework
            'subject_offerings_id' // Local key on Lesson
        );
    }
}
