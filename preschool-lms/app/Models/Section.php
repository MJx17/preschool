<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'grade_level_id',
        'name',
        'max_students',
    ];

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    // Students DO NOT belong directly to a section.
    // They belong through enrollments.
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Convenience relationship to get students
    public function students()
    {
        return $this->hasManyThrough(Student::class, Enrollment::class, 'section_id', 'id', 'id', 'student_id');
    }
}
