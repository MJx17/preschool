<?php

namespace App\Http\Controllers;

use App\Models\SubjectOffering;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectOfferingController extends Controller
{
    // LIST
    public function index(Request $request)
    {
        $query = SubjectOffering::with(['subject.gradeLevel', 'semester', 'teacher', 'section']);

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        $subjectOfferings = $query->get();

        // Group by grade and then section
        $subjectAssignments = $subjectOfferings
            ->groupBy(fn($item) => optional($item->subject->gradeLevel)->id)
            ->map(fn($gradeGroup) => $gradeGroup->groupBy('section_id'));

        $teachers = Teacher::all();
        $sections = Section::with('gradeLevel')->get();
        $semesters = Semester::all();

        return view('subject_assignment.index', compact(
            'subjectAssignments',
            'teachers',
            'sections',
            'semesters'
        ));
    }









    // CREATE FORM
    // CREATE FORM
    public function create()
    {
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();
        $sections = Section::with('gradeLevel')->get();
        $activeSemester = Semester::where('status', 'active')->first();

        return view('subject_assignment.create', compact(
            'subjects',
            'teachers',
            'sections',
            'activeSemester'
        ));
    }

    // STORE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id'  => 'required|exists:subjects,id',
            'semester_id' => 'required|exists:semesters,id',
            'teacher_id'  => 'required|exists:teachers,id',
            'section_id'  => 'required|exists:sections,id',
            'room'        => 'nullable|string|max:50',
            'days'        => 'nullable|array',
            'days.*'      => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
        ]);

        // Duplicate check
        $exists = SubjectOffering::where([
            'subject_id' => $validated['subject_id'],
            'semester_id' => $validated['semester_id'],
            'teacher_id' => $validated['teacher_id'],
            'section_id' => $validated['section_id'],
        ])->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['duplicate' => 'This subject assignment already exists for the selected semester, teacher, section,']);
        }

        SubjectOffering::create([
            'subject_id'  => $validated['subject_id'],
            'semester_id' => $validated['semester_id'],
            'teacher_id'  => $validated['teacher_id'],
            'section_id'  => $validated['section_id'],
            'room'        => $validated['room'] ?? null,
            'days'        => isset($validated['days']) ? json_encode($validated['days']) : null,
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

        // Format times for Blade
        $subject_assignment->start_time = $subject_assignment->start_time
            ? \Carbon\Carbon::parse($subject_assignment->start_time)->format('H:i')
            : null;
        $subject_assignment->end_time = $subject_assignment->end_time
            ? \Carbon\Carbon::parse($subject_assignment->end_time)->format('H:i')
            : null;

        $subjects  = Subject::all();
        $semesters = Semester::all();
        $teachers  = Teacher::with('user')->get();
        $sections  = Section::with('gradeLevel')->get();

        $selectedDays = is_string($subject_assignment->days)
            ? json_decode($subject_assignment->days, true)
            : ($subject_assignment->days ?? []);

        return view('subject_assignment.edit', compact(
            'subject_assignment',
            'subjects',
            'semesters',
            'teachers',
            'sections',
            'selectedDays'
        ));
    }


    // UPDATE
    public function update(Request $request, $id)
    {
        $subject_assignment = SubjectOffering::findOrFail($id);
        $validated = $this->validateSubjectOffering($request);

        // Prevent duplicates
        $exists = SubjectOffering::where([
            'subject_id' => $validated['subject_id'],
            'semester_id' => $validated['semester_id'],
            'teacher_id' => $validated['teacher_id'],
            'section_id' => $validated['section_id'],
        ])->where('id', '!=', $subject_assignment->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['duplicate' => 'This subject assignment already exists.'])->withInput();
        }

        $subject_assignment->update([
            'subject_id'  => $validated['subject_id'],
            'semester_id' => $validated['semester_id'],
            'teacher_id'  => $validated['teacher_id'],
            'section_id'  => $validated['section_id'],
            'room'        => $validated['room'],
            'days'        => json_encode($validated['days'] ?? []),
            'start_time'  => $validated['start_time'],
            'end_time'    => $validated['end_time'],
        ]);

        return redirect()->route('subject_assignment.index')
            ->with('success', 'Subject assignment updated!');
    }

    // DELETE
    public function destroy($id)
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
            'section_id'  => 'required|exists:sections,id', // section required now
            'room'        => 'required|string|max:20',
            'days'        => 'nullable|array',
            'days.*'      => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
        ]);
    }
}
