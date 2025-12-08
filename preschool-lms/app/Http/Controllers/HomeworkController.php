<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\Lesson;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Section;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    /**
     * Helper: Ensure teacher owns lesson (admins bypass)
     */
    private function authorizeLessonOwnership(int $lessonId)
    {
        $user = auth()->user();

        // Teachers must own the lesson
        if (!$user->hasRole('admin')) {
            $lesson = Lesson::findOrFail($lessonId);
            if ($lesson->subjectOffering->teacher_id !== $user->teacher->id) {
                abort(403, 'Unauthorized action.');
            }
        }
    }

    /**
     * Teacher: List homeworks for their lessons
     */
    public function index(Request $request)
    {
        $teacherId = auth()->user()->teacher->id;

        $query = Homework::with([
            'lesson.subjectOffering.teacher',
            'lesson.subjectOffering.subject',
            'lesson.subjectOffering.section'
        ])->whereHas('lesson.subjectOffering', fn($q) => $q->where('teacher_id', $teacherId));

        // Filters
        if ($request->filled('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }
        if ($request->filled('quarter')) {
            $query->whereHas('lesson', fn($q) => $q->where('quarter', $request->quarter));
        }

        $homeworks = $query->latest()->paginate(10);

        $lessons = Lesson::whereHas('subjectOffering', fn($q) => $q->where('teacher_id', $teacherId))->get();
        $quarters = [1, 2, 3, 4];

        return view('homeworks.index', compact('homeworks', 'lessons', 'quarters'));
    }

    /**
     * Admin: List all homeworks with filters
     */
    // HomeworkController@adminIndex (Admin)
    public function adminIndex(Request $request)
    {
        $query = Homework::with([
            'lesson.subjectOffering.subject',
            'lesson.subjectOffering.section',
            'lesson.subjectOffering.teacher'
        ]);

        if ($request->filled('teacher_id')) $query->whereHas('lesson.subjectOffering', fn($q) => $q->where('teacher_id', $request->teacher_id));
        if ($request->filled('lesson_id')) $query->where('lesson_id', $request->lesson_id);
        if ($request->filled('quarter')) $query->whereHas('lesson', fn($q) => $q->where('quarter', $request->quarter));
        if ($request->filled('subject_id')) $query->whereHas('lesson.subjectOffering', fn($q) => $q->where('subject_id', $request->subject_id));
        if ($request->filled('section_id')) $query->whereHas('lesson.subjectOffering', fn($q) => $q->where('section_id', $request->section_id));

        $homeworks = $query->latest()->paginate(20);

        return view('homeworks.admin.index', [
            'homeworks' => $homeworks,
            'lessons'   => Lesson::all(),
            'teachers'  => Teacher::with('user')->get(),
            'subjects'  => Subject::all(),
            'sections'  => Section::all(),
            'quarters'  => [1, 2, 3, 4],
        ]);
    }

    /**
     * Show form to create a homework (Teachers only)
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            abort(403, 'Admins cannot create homework.');
        }

        $lessons = Lesson::whereHas('subjectOffering', fn($q) => $q->where('teacher_id', $user->teacher->id))
            ->with('subjectOffering.subject', 'subjectOffering.section')->get();

        return view('homeworks.create', compact('lessons'));
    }

    /**
     * Store homework (Teachers only)
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            abort(403, 'Admins cannot create homework.');
        }

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'file_url'     => 'nullable|string',
            'video_url'    => 'nullable|string',
            'due_date'     => 'nullable|date',
            'lesson_id'    => 'required|exists:lessons,id',
        ]);

        $this->authorizeLessonOwnership($validated['lesson_id']);

        Homework::create($validated);

        return redirect()->route('homeworks.index')->with('success', 'Homework created successfully!');
    }

    /**
     * Show homework (Teachers: own only, Admins: any)
     */
    public function show(Homework $homework)
    {
        $homework->load('lesson.subjectOffering.teacher', 'lesson.subjectOffering.subject', 'lesson.subjectOffering.section');
        $this->authorizeLessonOwnership($homework->lesson_id);

        return view('homeworks.show', compact('homework'));
    }

    /**
     * Edit homework (Teachers: own only, Admins: any)
     */
    public function edit(Homework $homework)
    {
        $user = auth()->user();

        if (!$user->hasRole('admin')) {
            $this->authorizeLessonOwnership($homework->lesson_id);
        }

        $lessons = $user->hasRole('admin')
            ? Lesson::all()
            : Lesson::whereHas('subjectOffering', fn($q) => $q->where('teacher_id', $user->teacher->id))->get();

        return view('homeworks.edit', compact('homework', 'lessons'));
    }

    /**
     * Update homework (Teachers: own only, Admins: any)
     */
    public function update(Request $request, Homework $homework)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'file_url'     => 'nullable|string',
            'video_url'    => 'nullable|string',
            'due_date'     => 'nullable|date',
            'lesson_id'    => 'required|exists:lessons,id',
        ]);

        if (!$user->hasRole('admin')) {
            $this->authorizeLessonOwnership($validated['lesson_id']);
        }

        $homework->update($validated);

        $route = $user->hasRole('admin') ? 'homeworks.admin.index' : 'homeworks.index';
        return redirect()->route($route)->with('success', 'Homework updated successfully!');
    }

    /**
     * Delete homework (Teachers: own only, Admins: any)
     */
    public function destroy(Homework $homework)
    {
        $user = auth()->user();

        if (!$user->hasRole('admin')) {
            $this->authorizeLessonOwnership($homework->lesson_id);
        }

        $homework->delete();

        $route = $user->hasRole('admin') ? 'homeworks.admin.index' : 'homeworks.index';
        return redirect()->route($route)->with('success', 'Homework deleted successfully!');
    }
}
