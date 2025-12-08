<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * List quizzes
     */
 
       public function index()
    {
        $user = auth()->user();

        $query = Quiz::with('lesson.subjectOffering.subject', 'lesson.subjectOffering.section.gradeLevel');

        // Teacher sees only their own lessons
        if (!$user->hasRole('admin')) {
            $query->whereHas('lesson.subjectOffering', fn($q) => $q->where('teacher_id', $user->teacher->id));
        }

        $quizzes = $query->latest()->paginate(10);

        return view('quizzes.index', compact('quizzes'));
    }
    /**
     * Show form
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            abort(403, 'Admins cannot create quizzes.');
        }

        // Only lessons that belong to this teacher via subject offerings
        $lessons = Lesson::whereHas('subjectOffering', fn($q) => $q->where('teacher_id', $user->teacher->id))
            ->with('subjectOffering.subject', 'subjectOffering.section.gradeLevel')
            ->get();

        $types = ['short', 'long'];
        $statuses = ['draft', 'published', 'archived'];

        return view('quizzes.create', compact('lessons', 'types', 'statuses'));
    }

    /**
     * Store quiz
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id'   => 'nullable|exists:lessons,id',
            'time_limit'  => 'nullable|integer|min:1',
            'status'      => 'required|in:draft,published,archived',
            'type'        => 'required|in:short,long',
        ]);

        $user = auth()->user();

        if (!empty($validated['lesson_id'])) {
            $lesson = Lesson::findOrFail($validated['lesson_id']);

            // Ensure lesson belongs to this teacher
            if (!$user->hasRole('admin') && $lesson->subjectOffering->teacher_id !== $user->teacher->id) {
                abort(403, 'Unauthorized lesson.');
            }
        }

        Quiz::create($validated);

        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully.');
    }

    /**
     * Show quiz
     */
    public function show(Quiz $quiz)
    {
        $quiz->load('lesson.subjectOffering.subject', 'lesson.subjectOffering.section.gradeLevel');

        $user = auth()->user();
        if (!$user->hasRole('admin') && $quiz->lesson?->subjectOffering->teacher_id !== $user->teacher->id) {
            abort(403);
        }

        $questions = $quiz->questions()->paginate(5);

        return view('quizzes.show', compact('quiz', 'questions'));
    }

    /**
     * Edit quiz
     */
    public function edit(Quiz $quiz)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin') && $quiz->lesson?->subjectOffering->teacher_id !== $user->teacher->id) {
            abort(403);
        }

        $lessons = $user->hasRole('admin')
            ? Lesson::with('subjectOffering.subject', 'subjectOffering.section.gradeLevel')->get()
            : Lesson::whereHas('subjectOffering', fn($q) => $q->where('teacher_id', $user->teacher->id))
                ->with('subjectOffering.subject', 'subjectOffering.section.gradeLevel')
                ->get();

        $types = ['short', 'long'];
        $statuses = ['draft', 'published', 'archived'];

        return view('quizzes.edit', compact('quiz', 'lessons', 'types', 'statuses'));
    }

    /**
     * Update quiz
     */
    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id'   => 'nullable|exists:lessons,id',
            'time_limit'  => 'nullable|integer|min:1',
            'status'      => 'required|in:draft,published,archived',
            'type'        => 'required|in:short,long',
        ]);

        $user = auth()->user();

        if (!empty($validated['lesson_id'])) {
            $lesson = Lesson::findOrFail($validated['lesson_id']);
            if (!$user->hasRole('admin') && $lesson->subjectOffering->teacher_id !== $user->teacher->id) {
                abort(403, 'Unauthorized lesson.');
            }
        }

        $quiz->update($validated);

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    /**
     * Delete quiz
     */
    public function destroy(Quiz $quiz)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin') && $quiz->lesson?->subjectOffering->teacher_id !== $user->teacher->id) {
            abort(403);
        }

        $quiz->delete();

        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }
}
