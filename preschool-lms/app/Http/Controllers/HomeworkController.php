<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\Lesson;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function index()
    {
        $homeworks = Homework::with('lesson')->latest()->paginate(10);
        return view('homeworks.index', compact('homeworks'));
    }

    public function create()
    {
        $lessons = Lesson::all(); // for dropdown
        return view('homeworks.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'file_url' => 'nullable|string',
            'video_url' => 'nullable|string',
            'due_date' => 'nullable|date',
            'lesson_id' => 'nullable|exists:lessons,id',
        ]);

        Homework::create($request->all());

        return redirect()->route('homeworks.index')->with('success', 'Homework created successfully!');
    }

    public function show(Homework $homework)
    {
        return view('homeworks.show', compact('homework'));
    }

    public function edit(Homework $homework)
    {
        $lessons = Lesson::all();
        return view('homeworks.edit', compact('homework', 'lessons'));
    }

    public function update(Request $request, Homework $homework)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'file_url' => 'nullable|string',
            'video_url' => 'nullable|string',
            'due_date' => 'nullable|date',
            'lesson_id' => 'nullable|exists:lessons,id',
        ]);

        $homework->update($request->all());

        return redirect()->route('homeworks.index')->with('success', 'Homework updated successfully!');
    }

    public function destroy(Homework $homework)
    {
        $homework->delete();
        return redirect()->route('homeworks.index')->with('success', 'Homework deleted successfully!');
    }
}
