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
        'grade_level_id',
        'section_id',
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

    /**
     * A single enrollment can have many pivot rows (one per subject offering)
     */
    public function enrollmentSubjectOfferings()
    {
        return $this->hasMany(EnrollmentSubjectOffering::class);
    }

    /**
     * A convenience relationship to get actual SubjectOffering models
     * through the pivot table
     */
    public function subjectOfferings()
    {
        return $this->belongsToMany(
            SubjectOffering::class,
            'enrollment_subject_offering',   
            'enrollment_id',                 
            'subject_offering_id'            
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
        return $this->hasOne(FinancialInformation::class, 'enrollment_id');
    }

    /** Helpers */

    public function getFullSemesterAttribute()
    {
        return $this->semester->semester ?? 'N/A';
    }

    public function getGradeLevelTextAttribute()
    {
        if (!$this->grade_level) return null;

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