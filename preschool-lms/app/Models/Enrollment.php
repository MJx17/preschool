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



    public function subjectOfferings()
    {
        return $this->belongsToMany(
            SubjectOffering::class,
            'enrollment_subject_offering',
            'enrollment_id',
            'subject_offering_id'
        )->withPivot('status', 'grade')
            ->withTimestamps();
    }

    /** Fees & Payments */

    public function fees()
    {
        return $this->hasOne(Fee::class, 'enrollment_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
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
        if (!$this->gradeLevel) return null;

        $name = $this->gradeLevel->name;

        if (str_starts_with($name, 'grade_')) {
            $num = str_replace('grade_', '', $name);
            return 'Grade ' . ucfirst($num);
        }

        return ucfirst($name);
    }


    public function getCategoryTextAttribute()
    {
        return $this->category ? ucfirst($this->category) : null;
    }
}
