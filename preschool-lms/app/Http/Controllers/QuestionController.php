<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Store a new question and redirect back to the quiz page
     */
    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string|max:255',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'nullable|string|max:255',
            'option_d' => 'nullable|string|max:255',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        Question::create($request->all());

        // redirect to quiz show page
        return redirect()->route('quizzes.show', $request->quiz_id)
                         ->with('success', 'Question added successfully!');
    }

    /**
     * Update a question and redirect back to the quiz page
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string|max:255',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'nullable|string|max:255',
            'option_d' => 'nullable|string|max:255',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        $question->update($request->all());

        return redirect()->route('quizzes.show', $question->quiz_id)
                         ->with('success', 'Question updated successfully!');
    }

    /**
     * Delete a question and redirect back to the quiz page
     */
    public function destroy(Question $question)
    {
        $quizId = $question->quiz_id;
        $question->delete();

        return redirect()->route('quizzes.show', $quizId)
                         ->with('success', 'Question deleted successfully!');
    }
}
