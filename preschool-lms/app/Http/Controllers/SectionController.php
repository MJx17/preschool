<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\GradeLevel;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    // LIST ALL SECTIONS
    public function index()
    {
        $sections = Section::with('gradeLevel')->orderBy('grade_level_id')->orderBy('name')->get();
        return view('sections.index', compact('sections'));
    }

    // SHOW CREATE FORM
    public function create()
    {
        $grades = GradeLevel::all();
        return view('sections.create', compact('grades'));
    }

    // STORE NEW SECTION
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'grade_level_id' => 'required|exists:grade_levels,id',
        ]);

        Section::create($validated);

        return redirect()->route('sections.index')
            ->with('success', 'Section created successfully!');
    }

    // SHOW EDIT FORM
    public function edit($id)
    {
        $section = Section::findOrFail($id);
        $grades = GradeLevel::all();
        return view('sections.edit', compact('section', 'grades'));
    }

    // UPDATE SECTION
    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'grade_level_id' => 'required|exists:grade_levels,id',
        ]);

        $section->update($validated);

        return redirect()->route('sections.index')
            ->with('success', 'Section updated successfully!');
    }

    // DELETE SECTION
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return redirect()->route('sections.index')
            ->with('success', 'Section deleted successfully!');
    }

    public function byGrade($gradeLevelId)
    {
        $sections = Section::withCount('enrollments')
            ->where('grade_level_id', $gradeLevelId)
            ->get()
            ->filter(fn($s) => $s->enrollments_count < $s->max_students);

        return response()->json($sections);
    }
}
