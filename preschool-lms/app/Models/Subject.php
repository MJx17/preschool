<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',           // Subject name
        'code',           // Unique subject code
        'units',          // Subject units
        'fee',            // Subject fee
        'grade_level',    // Year/grade level the subject belongs to
        'prerequisite_id' // References another subject as a prerequisite
    ];

    /**
     * Relationships
     */

    // Prerequisite subject
    public function prerequisite()
    {
        return $this->belongsTo(Subject::class, 'prerequisite_id');
    }

    // Subjects that depend on this one as a prerequisite
    public function dependentSubjects()
    {
        return $this->hasMany(Subject::class, 'prerequisite_id');
    }

    // Subject Offerings (class sections)
    public function subjectOfferings()
    {
        return $this->hasMany(SubjectOffering::class);
    }
}
