<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'video_url',
        'document_url',
        'subject_offerings_id',
        'quarter',
    ];
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function subjectOffering()
    {
        return $this->belongsTo(SubjectOffering::class, 'subject_offerings_id'); // specify the foreign key
    }
}
