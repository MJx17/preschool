<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'units',
        'fee',
        'grade_level_id',
        'prerequisite_id',
    ];

    /** ─────── Relationships ─────── */

    // The grade level this subject belongs to
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    // All offerings of this subject (across sections and semesters)
    public function subjectOfferings()
    {
        return $this->hasMany(SubjectOffering::class);
    }

    // Get offerings for a specific section
    public function offeringsForSection($sectionId)
    {
        return $this->subjectOfferings()->where('section_id', $sectionId);
    }

    // Prerequisite subject
    public function prerequisite()
    {
        return $this->belongsTo(Subject::class, 'prerequisite_id');
    }

    // Subjects that depend on this one
    public function dependentSubjects()
    {
        return $this->hasMany(Subject::class, 'prerequisite_id');
    }

    /** ─────── Convenience method to get enrolled students ─────── */
    public function enrolledStudents()
    {
        // Loop through all offerings and get students through pivot
        return $this->subjectOfferings()
            ->with('enrollmentSubjectOfferings.enrollment.student')
            ->get()
            ->flatMap(function ($offering) {
                return $offering->enrollmentSubjectOfferings->map(fn($eso) => $eso->enrollment->student);
            })
            ->unique('id'); // remove duplicates if student enrolled in multiple offerings
    }
}
