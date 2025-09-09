<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::latest()->paginate(10);
        return view('lessons.index', compact('lessons'));
    }

    public function create()
    {
        return view('lessons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,docx,pptx,mp4|max:20480',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('lessons', 'public');
        }

        Lesson::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'video_url' => $request->video_url,
            'type' => $request->type,
            'teacher_id' => auth()->id(),
        ]);

        return redirect()->route('lessons.index')->with('success', 'Lesson created successfully!');
    }
}
