<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SubjectOffering extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'semester_id',
        'teacher_id',
        'block',
        'room',
        'days',        // JSON array
        'start_time',
        'end_time',
    ];

    /** ──────── Relationships ──────── */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function enrollments()
    {
        return $this->belongsToMany(Enrollment::class, 'enrollment_subject_offering')
            ->withPivot(['grade', 'status', 'fee'])
            ->withTimestamps();
    }

    public function enrollmentSubjectOfferings()
    {
        return $this->hasMany(EnrollmentSubjectOffering::class);
    }

    /** ──────── Accessors ──────── */
    public function getFormattedDaysAttribute()
    {
        $map = [
            'Monday'    => 'M',
            'Tuesday'   => 'T',
            'Wednesday' => 'W',
            'Thursday'  => 'Th',
            'Friday'    => 'F',
            'Saturday'  => 'S',
            'Sunday'    => 'Su'
        ];

        return collect($this->days ?? [])
            ->map(fn($d) => $map[$d] ?? '')
            ->implode(', ');
    }

    public function getClassTimeAttribute()
    {
        $start = Carbon::parse($this->start_time)->format('g:i A'); // 12-hour format, strip leading zero
        $end   = Carbon::parse($this->end_time)->format('g:i A');

        // Optional: Remove :00 for exact hours
        $start = preg_replace('/:00 /', ' ', $start);
        $end   = preg_replace('/:00 /', ' ', $end);

        return "$start - $end";
    }



    public function getGradeLevelTextAttribute()
    {
        if (empty($this->grade_level)) {
            return null; // ensures ?? works in Blade
        }

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
