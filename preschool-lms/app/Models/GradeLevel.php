<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    /** 
     * Optional: If you want to relate it to subjects
     */
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'grade_level', 'code');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    /**
     * Optional: If you want to relate it to enrollments
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'grade_level', 'code');
    }
}
