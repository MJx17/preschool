<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// class LessonController extends Controller
// {
//     // List all lessons
//     public function index()
//     {
//         $lessons = Lesson::latest()->get();
//         return view('lessons.index', compact('lessons'));
//     }

//     // Show create form
//     public function create()
//     {
//         return view('lessons.create');
//     }

//     // Store a new lesson
//     public function store(Request $request)
//     {
//         $request->validate([
//             'title' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'image' => 'nullable|image|max:5120', // 5MB
//             'video' => 'nullable|mimetypes:video/mp4,video/avi|max:51200', // 50MB
//             'document' => 'nullable|mimes:pdf,doc,docx|max:10240', // 10MB
//         ]);

//         $lesson = Lesson::create([
//             'title' => $request->title,
//             'description' => $request->description,
//             'image_path' => $request->file('image') ? $request->file('image')->store('lessons/images', 'public') : null,
//             'video_path' => $request->file('video') ? $request->file('video')->store('lessons/videos', 'public') : null,
//             'document_path' => $request->file('document') ? $request->file('document')->store('lessons/documents', 'public') : null,
//         ]);

//         return redirect()->route('lessons.index')->with('success', 'Lesson created successfully!');
//     }

//     // Show single lesson
//     public function show(Lesson $lesson)
//     {
//         return view('lessons.show', compact('lesson'));
//     }

//     // Show edit form
//     public function edit(Lesson $lesson)
//     {
//         return view('lessons.edit', compact('lesson'));
//     }

//     // Update lesson
//     public function update(Request $request, Lesson $lesson)
//     {
//         $request->validate([
//             'title' => 'sometimes|string|max:255',
//             'description' => 'nullable|string',
//             'image' => 'nullable|image|max:5120',
//             'video' => 'nullable|mimetypes:video/mp4,video/avi|max:51200',
//             'document' => 'nullable|mimes:pdf,doc,docx|max:10240',
//         ]);

//         if ($request->hasFile('image')) {
//             if ($lesson->image_path) Storage::disk('public')->delete($lesson->image_path);
//             $lesson->image_path = $request->file('image')->store('lessons/images', 'public');
//         }

//         if ($request->hasFile('video')) {
//             if ($lesson->video_path) Storage::disk('public')->delete($lesson->video_path);
//             $lesson->video_path = $request->file('video')->store('lessons/videos', 'public');
//         }

//         if ($request->hasFile('document')) {
//             if ($lesson->document_path) Storage::disk('public')->delete($lesson->document_path);
//             $lesson->document_path = $request->file('document')->store('lessons/documents', 'public');
//         }

//         $lesson->update($request->only(['title', 'description']));

//         return redirect()->route('lessons.index')->with('success', 'Lesson updated successfully!');
//     }

//     // Delete lesson
//     public function destroy(Lesson $lesson)
//     {
//         if ($lesson->image_path) Storage::disk('public')->delete($lesson->image_path);
//         if ($lesson->video_path) Storage::disk('public')->delete($lesson->video_path);
//         if ($lesson->document_path) Storage::disk('public')->delete($lesson->document_path);

//         $lesson->delete();

//         return redirect()->route('lessons.index')->with('success', 'Lesson deleted successfully!');
//     }
// }



class LessonController extends Controller
{
    /**
     * Display all lessons.
     */
    public function index()
    {
        $lessons = Lesson::latest()->paginate(10);
        return view('lessons.index', compact('lessons'));
    }

    /**
     * Show the form for creating a new lesson.
     */
    public function create()
    {
        return view('lessons.create');
    }

    /**
     * Store a newly created lesson in DB.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'image_url'    => 'nullable|url',
            'video_url'    => 'nullable|url',
            'document_url' => 'nullable|url',
        ]);

        Lesson::create($request->all());

        return redirect()->route('lessons.index')->with('success', 'Lesson created successfully!');
    }

    /**
     * Display a single lesson.
     */
public function show(Lesson $lesson)
{
    // Convert YouTube link to embed if it's a normal link
    if ($lesson->video_url && str_contains($lesson->video_url, 'youtube.com/watch')) {
        $lesson->video_url = preg_replace(
            '/watch\?v=([^\&\?\/]+)/',
            'embed/$1',
            $lesson->video_url
        );
    }

    // Convert Google Docs/Drive links to preview
    if ($lesson->document_url && str_contains($lesson->document_url, 'docs.google.com')) {
        $lesson->document_url = str_replace('/edit', '/preview', $lesson->document_url);
    }

    return view('lessons.show', compact('lesson'));
}


    /**
     * Show the form for editing a lesson.
     */
    public function edit(Lesson $lesson)
    {
        return view('lessons.edit', compact('lesson'));
    }

    /**
     * Update a lesson.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'image_url'    => 'nullable|url',
            'video_url'    => 'nullable|url',
            'document_url' => 'nullable|url',
        ]);

        $lesson->update($request->all());

        return redirect()->route('lessons.index')->with('success', 'Lesson updated successfully!');
    }

    /**
     * Delete a lesson.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('lessons.index')->with('success', 'Lesson deleted successfully!');
    }
}