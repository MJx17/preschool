<?php

namespace App\Http\Controllers;

use App\Models\SubjectOffering;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubjectOfferingController extends Controller
{
    // LIST
    public function index(Request $request)
    {
        $query = SubjectOffering::query()->with(['subject', 'semester', 'teacher.user', 'section']);

        // Teacher filter
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        // Section filter
        if ($request->filled('section')) {
            $query->whereHas('section', function ($q) use ($request) {
                $q->where('name', $request->section);
            });
        }

        // Semester filter
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        // Get the filtered subject assignments
        $subjectAssignments = $query->get();

        // For filter dropdowns
        $teachers = Teacher::with('user')->get();
        $sections = Section::all();
        $semesters = Semester::all();

        return view('subject_assignment.index', compact('subjectAssignments', 'teachers', 'sections', 'semesters'));
    }



    // CREATE FORM
    public function create()
    {
        $subjects  = Subject::all();
        $semesters = Semester::all();
        $teachers  = Teacher::with('user')->get();

        return view('subject_assignment.create', compact(
            'subjects',
            'semesters',
            'teachers'
        ));
    }

    public function store(Request $request)
    {
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

        // Check for duplicates
        $exists = SubjectOffering::where('subject_id', $validated['subject_id'])
            ->where('semester_id', $validated['semester_id'])
            ->where('teacher_id', $validated['teacher_id'])
            ->where('block', $validated['block'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['duplicate' => 'This subject assignment already exists for the selected semester, teacher, and block.']);
        }

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
            'subject_assignment',
            'subjects',
            'semesters',
            'teachers',
            'selectedDays'
        ));
    }

    // UPDATE
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

        // Prevent duplicates
        $exists = SubjectOffering::where('subject_id', $validated['subject_id'])
            ->where('semester_id', $validated['semester_id'])
            ->where('teacher_id', $validated['teacher_id'])
            ->where('block', $validated['block'])
            ->where('id', '!=', $subject_assignment->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['duplicate' => 'This subject assignment already exists.'])->withInput();
        }

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
            'block'       => 'required|string|max:10',
            'room'        => 'required|string|max:20',
            'days'        => 'nullable|array',
            'days.*'      => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
        ]);
    }
}
