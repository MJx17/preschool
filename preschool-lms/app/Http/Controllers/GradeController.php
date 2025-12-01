<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\SubjectOffering;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function show($offeringId)
    {
        $offering = SubjectOffering::with(['subject', 'grades.student'])->findOrFail($offeringId);

        return view('grades.show', compact('offering'));
    }

    public function store(Request $request, $offeringId)
    {
        $offering = SubjectOffering::findOrFail($offeringId);

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'first_grading' => 'nullable|numeric|min:0|max:100',
            'second_grading' => 'nullable|numeric|min:0|max:100',
            'third_grading' => 'nullable|numeric|min:0|max:100',
            'fourth_grading' => 'nullable|numeric|min:0|max:100',
        ]);

        // compute final grade (simple average example)
        $grades = collect($validated)->only(['first_grading','second_grading','third_grading','fourth_grading'])->filter();
        $final = $grades->avg();

        Grade::updateOrCreate(
            ['student_id' => $validated['student_id'], 'subject_offering_id' => $offering->id],
            array_merge($validated, ['final_grade' => $final])
        );

        return back()->with('success', 'Grade saved successfully.');
    }
}
