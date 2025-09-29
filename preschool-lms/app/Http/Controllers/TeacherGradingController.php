<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;

class TeacherGradingController extends Controller
{
    public function showStudentsForGrading($subjectId)
    {
        $user = Auth::user();

        // Admin can access any subject
        if ($user->hasRole('admin')) {
            $subject = Subject::with('students')->findOrFail($subjectId);
        } elseif ($user->hasRole('teacher')) {
            // Teachers can only access their own subjects
            $subject = Subject::with('students')
                ->where('id', $subjectId)
                ->where('teacher_id', $user->teacher->id ?? null)
                ->firstOrFail();
        } else {
            abort(403, 'Unauthorized access.');
        }

        return view('teachers.grade_students', compact('subject', 'user'));
    }

    public function updateGrades(Request $request, $subjectId)
    {
        $user = Auth::user();

        // Admin can update any subject's grades
        if ($user->hasRole('admin')) {
            $subject = Subject::findOrFail($subjectId);
        } elseif ($user->hasRole('teacher')) {
            // Teachers can only update their own subjects
            $subject = Subject::where('id', $subjectId)
                ->where('teacher_id', $user->teacher->id ?? null)
                ->firstOrFail();
        } else {
            abort(403, 'Unauthorized action.');
        }

        // Validate input
        $request->validate([
            'grades.*.first_grading'  => 'nullable|numeric|min:0|max:100',
            'grades.*.second_grading' => 'nullable|numeric|min:0|max:100',
            'grades.*.third_grading'  => 'nullable|numeric|min:0|max:100',
            'grades.*.fourth_grading' => 'nullable|numeric|min:0|max:100',
            'grades.*.final_grade'    => 'nullable|numeric|min:0|max:100',
            'grades.*.remarks'        => 'nullable|string|max:255',
        ]);

        // Update grades for each student
        foreach ($request->grades as $studentId => $grades) {
            $subject->students()->updateExistingPivot($studentId, $grades);
        }

        return back()->with('success', 'Grades updated successfully.');
    }
}
