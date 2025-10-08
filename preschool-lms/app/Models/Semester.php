<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semesters';

    protected $fillable = [
        'semester',   // now the full string, e.g., "First Semester 2025-2026"
        'start_date',
        'end_date',
        'status',
    ];

    public $timestamps = true;

    /**
     * Accessor for dropdown display label
     * Example: "First Semester 2025-2026 (Active)"
     */
    public function getDropdownLabelAttribute(): string
    {
        return "{$this->semester} (" . ucfirst($this->status) . ")";
    }

    /**
     * Relationship: a semester has many subjects
     */
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    /**
     * Check if an active semester with the same name already exists
     */
    public static function isActiveExists($semester, $excludeId = null): bool
    {
        $query = self::where('semester', $semester)
            ->where('status', 'active');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }
}
