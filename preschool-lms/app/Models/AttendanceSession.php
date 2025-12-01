<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceSession extends Model
{
    use HasFactory;

    protected $fillable = ['subject_offering_id', 'date', 'topic'];

    public function subjectOffering()
    {
        return $this->belongsTo(SubjectOffering::class);
    }

    public function records()
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
