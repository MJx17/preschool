<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\GradeLevel;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('gradeLevel')->paginate(10); // eager load grade level
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $subjects = Subject::all();         // For prerequisites
        $gradeLevels = GradeLevel::all();   // For grade level select
        return view('subjects.create', compact('subjects', 'gradeLevels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'code'           => 'required|string|max:50|unique:subjects,code',
            'grade_level_id' => 'required|exists:grade_levels,id', // use foreign key
            'prerequisite_id'=> 'nullable|exists:subjects,id',
            'fee'            => 'required|numeric|min:0',
            'units'          => 'required|numeric|min:0.1|max:10',
        ]);

        $subject = Subject::create($validated);

        return redirect()
            ->route('subjects.index')
            ->with('success', "Subject {$subject->name} created successfully!");
    }

    public function edit($id)
    {
        $subject      = Subject::findOrFail($id);
        $subjects     = Subject::where('id', '!=', $subject->id)->get(); // for prerequisite dropdown
        $gradeLevels  = GradeLevel::all(); // for grade level dropdown

        return view('subjects.edit', compact('subject','subjects','gradeLevels'));
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'code'           => 'required|string|max:50|unique:subjects,code,'.$subject->id,
            'grade_level_id' => 'required|exists:grade_levels,id', // use foreign key
            'prerequisite_id'=> 'nullable|exists:subjects,id',
            'fee'            => 'required|numeric|min:0',
            'units'          => 'required|numeric|min:0.1|max:10',
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index')->with('updated', 'Subject updated successfully!');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subjects.index')->with('deleted', 'Subject deleted successfully!');
    }

    public function show($id)
    {
        $subject = Subject::with('subjectOfferings.teacher','subjectOfferings.semester','prerequisite','gradeLevel')
                          ->findOrFail($id);

        return view('subjects.show', compact('subject'));
    }
}
