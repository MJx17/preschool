<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentSubjectOffering extends Model
{
    use HasFactory;

    protected $table = 'enrollment_subject_offering';

    protected $fillable = [
        'enrollment_id',
        'subject_offering_id',
        'grade',
        'status',
    ];

    /** Relationships */

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function subjectOffering()
    {
        return $this->belongsTo(SubjectOffering::class);
    }

    // Access the student via enrollment
        public function student()
    {
        return $this->hasOneThrough(
            Student::class,
            Enrollment::class,
            'id',           // Enrollment PK
            'id',           // Student PK
            'enrollment_id', // Local FK on this model
            'student_id'    // FK on Enrollment table
        );
    }

    // Grade relationship for this specific student + subject offering
    public function grade()
    {
        // Ensure enrollment is loaded
        $studentId = $this->enrollment->student_id ?? 0;

        return $this->hasOne(Grade::class, 'subject_offerings_id', 'subject_offering_id')
                    ->where('student_id', $studentId);
    }
}
