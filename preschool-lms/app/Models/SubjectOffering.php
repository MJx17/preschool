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
        'section_id',
        'room',
        'days',
        'start_time',
        'end_time',
    ];

    /* ─────────────────────────────────────────────
     |  Relationships
     ───────────────────────────────────────────── */

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'subject_offerings_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'subject_offerings_id', 'id');
    }

    /**
     * Pivot: Enrollment ↔ SubjectOffering
     */
    public function enrollmentSubjectOfferings()
    {
        return $this->hasMany(EnrollmentSubjectOffering::class);
    }

    /**
     * All enrollments attached to this subject offering via pivot
     */
    public function enrollments()
    {
        return $this->hasManyThrough(
            Enrollment::class,
            EnrollmentSubjectOffering::class,
            'subject_offering_id',   // FK on pivot
            'id',                    // PK on Enrollment
            'id',                    // PK on SubjectOffering
            'enrollment_id'          // FK on pivot
        );
    }

    /**
     * All students enrolled in this subject offering via pivot
     */
    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            EnrollmentSubjectOffering::class,
            'subject_offering_id', // FK on pivot
            'id',                  // PK on Student
            'id',                  // PK on SubjectOffering
            'enrollment_id'        // FK on pivot
        );
    }

    /**
     * Attendance Sessions
     */
    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class);
    }


    /* ─────────────────────────────────────────────
     |  Accessors
     ───────────────────────────────────────────── */

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

        $daysArray = is_string($this->days)
            ? json_decode($this->days, true)
            : ($this->days ?? []);

        return collect($daysArray)
            ->map(fn($d) => $map[$d] ?? '')
            ->implode(', ');
    }

    public function getClassTimeAttribute()
    {
        $start = Carbon::parse($this->start_time)->format('g:i A');
        $end   = Carbon::parse($this->end_time)->format('g:i A');

        $start = preg_replace('/:00 /', ' ', $start);
        $end   = preg_replace('/:00 /', ' ', $end);

        return "$start - $end";
    }

    public function getGradeLevelTextAttribute()
    {
        if (empty($this->grade_level)) {
            return null;
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


    public function getFormattedStartTimeAttribute()
    {
        return $this->start_time ? \Carbon\Carbon::parse($this->start_time)->format('H:i') : null;
    }

    // Accessor for end_time in H:i format
    public function getFormattedEndTimeAttribute()
    {
        return $this->end_time ? \Carbon\Carbon::parse($this->end_time)->format('H:i') : null;
    }
}
