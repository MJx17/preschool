<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentSubjectOffering extends Model
{
    use HasFactory;

    protected $table = 'enrollment_subject_offering'; // explicit because not pluralized

    protected $fillable = [
        'enrollment_id',
        'subject_offering_id',
        'grade',
        'status',
    ];

    /**
     * Relationships
     */

    // The enrollment this row belongs to
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    // The subject offering (class section) this row belongs to
    public function subjectOffering()
    {
        return $this->belongsTo(SubjectOffering::class);
    }
}
