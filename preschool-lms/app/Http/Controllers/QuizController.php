<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('lesson')->latest()->paginate(10);
        return view('quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $lessons = Lesson::all(); // fetch all lessons
        return view('quizzes.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id'   => 'nullable|exists:lessons,id',
            'time_limit'  => 'nullable|integer|min:1',
            'status'      => 'required|in:draft,published,archived',
        ]);

        Quiz::create($validated);

        return redirect()
            ->route('quizzes.index')
            ->with('success', 'Quiz created successfully.');
    }

    public function show($id)
    {
        $quiz = Quiz::with(['lesson'])
            ->findOrFail($id);

        // Paginate questions, e.g., 5 per page
        $questions = $quiz->questions()->paginate(5);

        return view('quizzes.show', compact('quiz', 'questions'));
    }


    public function edit(Quiz $quiz)
    {
        $lessons = Lesson::all();
        return view('quizzes.edit', compact('quiz', 'lessons'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id'   => 'nullable|exists:lessons,id',
            'time_limit'  => 'nullable|integer|min:1',
            'status'      => 'required|in:draft,published,archived',
        ]);

        $quiz->update($validated);

        return redirect()
            ->route('quizzes.index')
            ->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()
            ->route('quizzes.index')
            ->with('success', 'Quiz deleted successfully.');
    }
}
