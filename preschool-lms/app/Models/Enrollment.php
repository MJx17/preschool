<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'semester_id',
        'course_id',
        'grade_level',
        'category'
    ];

    /** Relationships */

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public static function gradeLevels(): array
    {
        return ['nursery', 'kinder', 'grade_1', 'grade_2', 'grade_3'];
    }

    /**
     * Each Enrollment can have many EnrollmentSubjectOffering rows
     * (each row = one SubjectOffering the student is taking)
     */
    public function enrollmentSubjectOfferings()
    {
        return $this->hasMany(EnrollmentSubjectOffering::class);
    }

    /**
     * Convenience accessor:
     * get the actual SubjectOffering models for this enrollment
     */
    public function subjectOfferings()
    {
        return $this->hasManyThrough(
            SubjectOffering::class,
            EnrollmentSubjectOffering::class,
            'enrollment_id',         // FK on EnrollmentSubjectOffering
            'id',                    // FK on SubjectOffering (its PK)
            'id',                    // Local key on Enrollment
            'subject_offering_id',    // Local key on EnrollmentSubjectOffering
        );
    }

    /** Fees & Payments */

    public function fees()
    {
        return $this->hasOne(Fee::class, 'enrollment_id');
    }

    public function payments()
    {
        return $this->hasOne(Payment::class, 'fee_id');
    }

    public function financialInformation()
    {
        return $this->hasOne(FinancialInformation::class,  'enrollment_id');
    }

    /** Helpers */

    /**
     * Accessor: full readable semester string
     * Example: "First Semester - 2025-2026"
     */
    public function getFullSemesterAttribute()
    {
        return $this->semester->semester ?? 'N/A';
    }
    

    public function getGradeLevelTextAttribute()
    {
        if (empty($this->grade_level)) {
            return null; // ensures ?? works in Blade
        }

        if (str_starts_with($this->grade_level, 'grade_')) {
            $num = str_replace('grade_', '', $this->grade_level);
            return 'Grade ' . ucfirst($num);
        }

        return ucfirst($this->grade_level);
    }

    public function getCategoryTextAttribute()
    {
        return $this->category ? ucfirst($this->category) : null;
    }
}
