<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semesters';

    protected $fillable = [
        'academic_year',
        'semester',      // '1st', '2nd', 'Summer'
        'start_date',
        'end_date',
        'status',        // 'upcoming', 'active', 'closed'
    ];

    public $timestamps = true;

    /**
     * Accessor: full readable semester string
     * Example: "First Semester - 2025-2026"
     */
    public function getFullSemesterAttribute()
    {
        return "{$this->semester_text} - {$this->academic_year}";
    }

    /**
     * Accessor: formatted semester name
     * Example: '1st' → 'First Semester'
     */
    public function getSemesterTextAttribute()
    {
        $semesterMapping = [
            '1st'    => 'First Semester',
            '2nd'    => 'Second Semester',
            '3rd'    => 'Third Semester',
            '4th'    => 'Fourth Semester',
            'Summer' => 'Summer Term',
        ];

        return $semesterMapping[$this->semester] ?? $this->semester;
    }

    /**
     * Relationship: a semester has many subjects
     */
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function getDropdownLabelAttribute()
    {
        return "{$this->semesterText} - AY {$this->academic_year} (" . ucfirst($this->status) . ")";
    }
}
