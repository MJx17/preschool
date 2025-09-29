<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Semester;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // Display a listing of subjects
    public function index()
    {
        $subjects = Subject::paginate(10);
        return view('subjects.index', compact('subjects'));
    }

    // Show the form to create a new subject
    public function create()
    {
        $teachers = Teacher::with('user')->get();
        $semesters = Semester::all();
        $subjects = Subject::all(); // For prerequisites

        return view('subjects.create', compact('teachers', 'semesters', 'subjects'));
    }

    // Store a newly created subject
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code',
            'semester_id' => 'required|exists:semesters,id',
            'grade_level' => 'required|string',
            'prerequisite_id' => 'nullable|exists:subjects,id',
            'fee' => 'required|numeric|min:0',
            'units' => 'required|numeric|min:0.1|max:10',
            'teacher_id' => 'required|exists:teachers,id',
            'days' => 'required|array',
            'days.*' => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room'  => 'required|string',
            'block' => 'required|string'
        ]);

        $subject = Subject::create([
            'name' => $validatedData['name'],
            'code' => $validatedData['code'],
            'semester_id' => $validatedData['semester_id'],
            'grade_level' => $validatedData['grade_level'],
            'prerequisite_id' => $validatedData['prerequisite_id'],
            'fee' => $validatedData['fee'],
            'units' => $validatedData['units'],
            'teacher_id' => $validatedData['teacher_id'],
            'days' => json_encode($validatedData['days']),
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'room'=> $validatedData['room'],
            'block'=>$validatedData['block'],
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully!');
    }

    // Show the form to edit the subject
    public function edit($id)
    {
        $subject = Subject::with(['teacher', 'semester'])->findOrFail($id);
        $teachers = Teacher::with('user')->get();
        $semesters = Semester::all();
        $subjects = Subject::where('id', '!=', $subject->id)->get();

        return view('subjects.edit', compact('subject', 'teachers', 'semesters', 'subjects'));
    }

    // Update the subject
    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,' . $subject->id,
            'semester_id' => 'required|exists:semesters,id',
            'grade_level' => 'required|string',
            'prerequisite_id' => 'nullable|exists:subjects,id',
            'fee' => 'required|numeric|min:0',
            'units' => 'required|numeric|min:0.1|max:10',
            'teacher_id' => 'required|exists:teachers,id',
            'days' => 'required|array',
            'days.*' => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room'  => 'required|string',
            'block' => 'required|string'
        ]);

        $subject->update([
            'name' => $validatedData['name'],
            'code' => $validatedData['code'],
            'semester_id' => $validatedData['semester_id'],
            'grade_level' => $validatedData['grade_level'],
            'prerequisite_id' => $validatedData['prerequisite_id'],
            'fee' => $validatedData['fee'],
            'units' => $validatedData['units'],
            'teacher_id' => $validatedData['teacher_id'],
            'days' => json_encode($validatedData['days']),
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'room'=> $validatedData['room'],
            'block'=>$validatedData['block'],
        ]);

        return redirect()->route('subjects.index')->with('updated', 'Subject updated successfully!');
    }

    // Delete the subject
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subjects.index')->with('deleted', 'Subject deleted successfully!');
    }

    // Display a single subject
    public function show($id)
    {
        $subject = Subject::with(['teacher', 'semester'])->findOrFail($id);
        return view('subjects.show', compact('subject'));
    }
}
