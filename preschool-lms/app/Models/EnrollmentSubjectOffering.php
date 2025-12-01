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
}
