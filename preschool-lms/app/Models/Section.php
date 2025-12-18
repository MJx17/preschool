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

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

   public function students()
{
    return $this->hasManyThrough(
        Student::class,
        EnrollmentSubjectOffering::class,
        'subject_offering_id', // FK on pivot table
        'id',                  // PK on students
        'id',                  // PK on this model (subject_offering)
        'enrollment_id'        // FK on pivot table
    );
}
    public function subjectOfferings()
    {
        return $this->hasMany(SubjectOffering::class, 'section_id');
    }
}
