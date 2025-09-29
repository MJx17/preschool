<?php

namespace App\Http\Controllers\Lms;

use App\Http\Controllers\Controller;
use App\Helpers\JsonStorage;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Classes
    public function classes()
    {
        $classes = JsonStorage::read('classes');
        return view('admin-lms.classes.index', compact('classes'));
    }

    public function createClass()
    {
        return view('admin-lms.classes.create');
    }

    public function storeClass(Request $request)
    {
        $classes = JsonStorage::read('classes');

        $classes->push((object)[
            'id' => $classes->max('id') + 1,
            'name' => $request->name,
            'teacher' => $request->teacher,
            'schedule' => $request->schedule
        ]);

        JsonStorage::write('classes', $classes);

        return redirect()->route('admin-lms.classes')->with('success', 'Class added!');
    }

    public function editClass($id)
    {
        $classes = JsonStorage::read('classes');
        $class = $classes->firstWhere('id', (int)$id);
        return view('admin-lms.classes.edit', compact('class'));
    }

    public function updateClass(Request $request, $id)
    {
        $classes = JsonStorage::read('classes');
        foreach ($classes as $c) {
            if ($c->id == (int)$id) {
                $c->name = $request->name;
                $c->teacher = $request->teacher;
                $c->schedule = $request->schedule;
                break;
            }
        }
        JsonStorage::write('classes', $classes);
        return redirect()->route('admin-lms.classes')->with('success', 'Class updated!');
    }

    // Homework
    public function homework()
    {
        $homework = JsonStorage::read('homework');
        $classes = JsonStorage::read('classes');
        return view('admin-lms.homework.index', compact('homework', 'classes'));
    }

    public function createHomework()
    {
        $classes = JsonStorage::read('classes');
        return view('admin-lms.homework.create', compact('classes'));
    }

    public function storeHomework(Request $request)
    {
        $homework = JsonStorage::read('homework');

        $homework->push((object)[
            'id' => $homework->max('id') + 1,
            'class_id' => (int)$request->class_id,
            'title' => $request->title,
            'due' => $request->due,
        ]);

        JsonStorage::write('homework', $homework);

        return redirect()->route('admin-lms.homework')->with('success', 'Homework added!');
    }

    public function editHomework($id)
    {
        $homework = JsonStorage::read('homework');
        $classes = JsonStorage::read('classes');
        $hw = $homework->firstWhere('id', (int)$id);
        return view('admin-lms.homework.edit', compact('hw', 'classes'));
    }

    public function updateHomework(Request $request, $id)
    {
        $homework = JsonStorage::read('homework');
        foreach ($homework as $hw) {
            if ($hw->id == (int)$id) {
                $hw->class_id = (int)$request->class_id;
                $hw->title = $request->title;
                $hw->due = $request->due;
                break;
            }
        }
        JsonStorage::write('homework', $homework);
        return redirect()->route('admin-lms.homework')->with('success', 'Homework updated!');
    }

    // Lessons
public function lessons()
{
    $lessons = JsonStorage::read('lessons');
    $classes = JsonStorage::read('classes');
    return view('admin-lms.lessons.index', compact('lessons', 'classes'));
}

public function createLesson()
{
    $classes = JsonStorage::read('classes');
    return view('admin-lms.lessons.create', compact('classes'));
}

public function storeLesson(Request $request)
{
    $lessons = JsonStorage::read('lessons');

    $lessons->push((object)[
        'id' => $lessons->max('id') + 1,
        'class_id' => (int)$request->class_id,
        'title' => $request->title,
        'file' => $request->file, // store file path or name
        'quiz' => $request->quiz ?? [], // simple array of questions
    ]);

    JsonStorage::write('lessons', $lessons);

    return redirect()->route('admin-lms.lessons')->with('success', 'Lesson added!');
}

public function editLesson($id)
{
    $lessons = JsonStorage::read('lessons');
    $classes = JsonStorage::read('classes');
    $lesson = $lessons->firstWhere('id', (int)$id);
    return view('admin-lms.lessons.edit', compact('lesson', 'classes'));
}

public function updateLesson(Request $request, $id)
{
    $lessons = JsonStorage::read('lessons');

    foreach ($lessons as $lesson) {
        if ($lesson->id == (int)$id) {
            $lesson->class_id = (int)$request->class_id;
            $lesson->title = $request->title;
            $lesson->file = $request->file;
            $lesson->quiz = $request->quiz ?? [];
            break;
        }
    }

    JsonStorage::write('lessons', $lessons);

    return redirect()->route('admin-lms.lessons')->with('success', 'Lesson updated!');
}

}
