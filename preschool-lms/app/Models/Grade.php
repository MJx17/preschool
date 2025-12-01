<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_offering_id',
        'first_grading',
        'second_grading',
        'third_grading',
        'fourth_grading',
        'final_grade',
        'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function subjectOffering()
    {
        return $this->belongsTo(SubjectOffering::class);
    }
}
