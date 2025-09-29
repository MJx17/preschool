<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


        public function professors()
    {
        return $this->belongsToMany(Teacher::class, 'department_teacher');
    }

}
