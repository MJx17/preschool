<?php

namespace App\Http\Controllers;

use App\Models\SubjectOffering;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class SubjectOfferingController extends Controller
{
    // LIST
    public function index()
    {
        $subjectAssignments = SubjectOffering::with(['subject', 'semester', 'teacher.user'])
            ->orderBy('semester_id')
            ->orderBy('block')
            ->get();

        return view('subject_assignment.index', compact('subjectAssignments'));
    }

    // CREATE FORM
    public function create()
    {
        $subjects  = Subject::all();
        $semesters = Semester::all();
        $teachers  = Teacher::with('user')->get();

        return view('subject_assignment.create', compact('subjects', 'semesters', 'teachers'));
    }

    // STORE NEW
    public function store(Request $request)
    {
        $validated = $this->validateSubjectOffering($request);

        SubjectOffering::create([
            'subject_id'  => $validated['subject_id'],
            'semester_id' => $validated['semester_id'],
            'teacher_id'  => $validated['teacher_id'],
            'block'       => $validated['block'],
            'room'        => $validated['room'],
            'days'        => json_encode($validated['days'] ?? []),
            'start_time'  => $validated['start_time'],
            'end_time'    => $validated['end_time'],
        ]);

        return redirect()->route('subject_assignment.index')
            ->with('success', 'Subject assignment created!');
    }

    // EDIT FORM
    public function edit($id)
{
    $subject_assignment = SubjectOffering::findOrFail($id);
    $subjects  = Subject::all();
    $semesters = Semester::all();
    $teachers  = Teacher::with('user')->get();

    $selectedDays = is_string($subject_assignment->days)
        ? json_decode($subject_assignment->days, true)
        : ($subject_assignment->days ?? []);

    return view('subject_assignment.edit', compact(
        'subject_assignment', 'subjects', 'semesters', 'teachers', 'selectedDays'
    ));
}

public function update(Request $request, $id)
{
    $subject_assignment = SubjectOffering::findOrFail($id);

    $validated = $request->validate([
        'subject_id'  => 'required|exists:subjects,id',
        'semester_id' => 'required|exists:semesters,id',
        'teacher_id'  => 'required|exists:teachers,id',
        'block'       => 'required|string|max:10',
        'room'        => 'required|string|max:20',
        'days'        => 'nullable|array',
        'days.*'      => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
        'start_time'  => 'required|date_format:H:i',
        'end_time'    => 'required|date_format:H:i|after:start_time',
    ]);

    // Debug immediately
    Log::info("Updating SubjectAssignment", ['validated' => $validated]);
    dd($validated, $request->all(), $subject_assignment->toArray());

    $subject_assignment->update([
        'subject_id'  => $validated['subject_id'],
        'semester_id' => $validated['semester_id'],
        'teacher_id'  => $validated['teacher_id'],
        'block'       => $validated['block'],
        'room'        => $validated['room'],
        'days'        => json_encode($validated['days'] ?? []),
        'start_time'  => $validated['start_time'],
        'end_time'    => $validated['end_time'],
    ]);

    return redirect()->route('subject_assignment.index')
        ->with('success', 'Subject assignment updated!');
}


    // DELETE MANUAL
    public function destroyManual($id)
    {
        $subject_assignment = SubjectOffering::findOrFail($id);
        $subject_assignment->delete();

        return redirect()->route('subject_assignment.index')
            ->with('success', 'Subject assignment deleted!');
    }

    // VALIDATION
    private function validateSubjectOffering(Request $request)
    {
        return $request->validate([
            'subject_id'  => 'required|exists:subjects,id',
            'semester_id' => 'required|exists:semesters,id',
            'teacher_id'  => 'required|exists:teachers,id',
            'block'       => 'required|string|max:10',
            'room'        => 'required|string|max:20',
            'days'        => 'nullable|array',
            'days.*'      => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
        ]);
    }
}
