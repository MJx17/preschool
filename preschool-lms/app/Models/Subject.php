<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'code',
        'units',
        'fee',
        'grade_level_id', // change from string to foreign key
        'prerequisite_id'
    ];

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    public function offeringsForSection($sectionId)
    {
        return $this->subjectOfferings()->where('section_id', $sectionId);
    }


    // prerequisite relationship stays the same
    public function prerequisite()
    {
        return $this->belongsTo(Subject::class, 'prerequisite_id');
    }

    public function dependentSubjects()
    {
        return $this->hasMany(Subject::class, 'prerequisite_id');
    }

    public function subjectOfferings()
    {
        return $this->hasMany(SubjectOffering::class);
    }
}
