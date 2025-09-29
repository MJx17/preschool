<?php

namespace App\Http\Controllers\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LMSController extends Controller
{
    // Dashboard
    public function index()
    {
        $classCount = 3;
        $pendingHomework = 2;
        $unreadMessages = 1;

        return view('lms.index', compact('classCount', 'pendingHomework', 'unreadMessages'));
    }

    // Classes Page
    public function classes()
    {
        $classes = collect([
            (object) ['name' => 'Math', 'teacher' => 'Ms. Anna', 'schedule' => 'Mon & Wed 9:00 AM'],
            (object) ['name' => 'Reading', 'teacher' => 'Mr. John', 'schedule' => 'Tue & Thu 10:30 AM'],
            (object) ['name' => 'Arts', 'teacher' => 'Ms. Lisa', 'schedule' => 'Friday 1:00 PM'],
        ]);
    
        return view('lms.classes', compact('classes'));
    }
    // Homework Page
    public function homework()
    {
        $homework = collect([
            (object) ['title' => 'Math Shapes Worksheet', 'due' => 'Friday'],
            (object) ['title' => 'Draw Your Family', 'due' => 'Monday'],
        ]);

        return view('lms.homework', compact('homework'));
    }

    // Messages Page
    public function messages()
    {
        $messages = collect([
            (object) ['from' => 'Teacher Anna', 'body' => 'Don’t forget to bring your crayons tomorrow!'],
            (object) ['from' => 'Teacher John', 'body' => 'Great job on your last assignment! 🎉'],
        ]);

        return view('lms.messages', compact('messages'));
    }

    // Grades Page
    public function grades()
    {
        $grades = collect([
            (object) ['subject' => 'Math', 'grade' => 'A'],
            (object) ['subject' => 'Reading', 'grade' => 'B+'],
            (object) ['subject' => 'Arts', 'grade' => 'A-'],
        ]);

        return view('lms.grades', compact('grades'));
    }

    // Settings Page
    public function settings()
    {
        return view('lms.settings');
    }
}
