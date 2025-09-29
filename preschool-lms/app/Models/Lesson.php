<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    //    protected $fillable = [
    //         'title',
    //         'description',
    //         'file_path',
    //         'video_path',
    //         'image_path',

    //     ];
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'video_url',
        'document_url',
    ];
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
