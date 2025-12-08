<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubjectOffering;
use App\Models\Grade;

class TeacherGradingController extends Controller
{
    /** Show students for grading */
    public function showStudentsForGrading($subjectOfferingId)
    {
        $user = Auth::user();

        $subjectOffering = SubjectOffering::with([
            'subject',
            'section',
            'enrollmentSubjectOfferings.enrollment.student',
            'semester'
        ])->findOrFail($subjectOfferingId);

        if ($user->hasRole('teacher') && optional($user->teacher)->id !== $subjectOffering->teacher_id) {
            abort(403, 'Unauthorized access.');
        }

        if ($subjectOffering->semester->status !== 'active') {
            abort(403, 'Cannot grade students for non-active semester.');
        }

        return view('teachers.grade_students', compact('subjectOffering', 'user'));
    }




    /** Update grades */
    public function updateGrades(Request $request, $subjectOfferingId)
    {
        // Load subject offering with enrollments and students
        $subjectOffering = SubjectOffering::with([
            'enrollmentSubjectOfferings.enrollment.student',
            'grades' // load all grades for this subject offering
        ])->findOrFail($subjectOfferingId);

        $user = Auth::user();
        if ($user->hasRole('teacher') && $subjectOffering->teacher_id != optional($user->teacher)->id) {
            abort(403, 'Unauthorized access.');
        }

        // Validation
        $request->validate([
            'grades.*.first_grading'  => 'nullable|numeric|min:0|max:100',
            'grades.*.second_grading' => 'nullable|numeric|min:0|max:100',
            'grades.*.third_grading'  => 'nullable|numeric|min:0|max:100',
            'grades.*.fourth_grading' => 'nullable|numeric|min:0|max:100',
            'grades.*.final_grade'    => 'nullable|numeric|min:0|max:100',
            'grades.*.remarks'        => 'nullable|string|max:255',
        ]);

        // Map existing grades by student_id for quick lookup
        $gradesMap = $subjectOffering->grades->keyBy('student_id');

        foreach ($subjectOffering->enrollmentSubjectOfferings as $record) {
            $studentId = $record->enrollment->student_id;
            $subjectOfferingId = $record->subject_offering_id;

            if (!$studentId || !$subjectOfferingId) continue;

            $input = $request->grades[$record->id] ?? [];

            // Fetch existing grade from map or create new
            $grade = $gradesMap[$studentId] ?? new Grade([
                'student_id' => $studentId,
                'subject_offerings_id' => $subjectOfferingId,
            ]);

            // Update only if input exists
            $grade->fill([
                'first_grading'  => $input['first_grading']  ?? $grade->first_grading,
                'second_grading' => $input['second_grading'] ?? $grade->second_grading,
                'third_grading'  => $input['third_grading']  ?? $grade->third_grading,
                'fourth_grading' => $input['fourth_grading'] ?? $grade->fourth_grading,
                'final_grade'    => $input['final_grade']    ?? $grade->final_grade,
                'remarks'        => $input['remarks']        ?? $grade->remarks,
            ]);

            $grade->save();
        }

        return redirect()->route('teachers.viewGrades', $subjectOffering->id)
            ->with('success', 'Grades updated successfully.');
    }






    // View only
    // public function viewGrades($subjectOfferingId)
    // {
    //     $subjectOffering = SubjectOffering::with([
    //         'subject',
    //         'section',
    //         'semester',
    //         'enrollmentSubjectOfferings.enrollment.student',
    //         'grades' // new relationship to load all grades at once
    //     ])->findOrFail($subjectOfferingId);

    //     return view('teachers.grade_students_view', compact('subjectOffering'));
    // }



    public function viewGrades($subjectOfferingId)
    {
        $subjectOffering = SubjectOffering::with([
            'enrollmentSubjectOfferings.enrollment.student'
        ])->findOrFail($subjectOfferingId);

        foreach ($subjectOffering->enrollmentSubjectOfferings as $enrollmentRecord) {
            $studentId = $enrollmentRecord->enrollment->student->id;
            $subjectId = $subjectOffering->id;

            $enrollmentRecord->grade = Grade::where('student_id', $studentId)
                ->where('subject_offerings_id', $subjectId)
                ->first() ?? new Grade();
        }


        return view('teachers.grade_students_view', compact('subjectOffering'));
    }
}
