<?php

namespace App\Http\Controllers;

use App\Models\GradeLevel;
use Illuminate\Http\Request;

class GradeLevelController extends Controller
{
    // LIST ALL GRADE LEVELS
    public function index()
    {
        $grades = GradeLevel::orderBy('id')->get();
        return view('grade_levels.index', compact('grades'));
    }

    // SHOW CREATE FORM
    public function create()
    {
        return view('grade_levels.create');
    }

    // STORE NEW GRADE LEVEL
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:20|unique:grade_levels,code',
        ]);

        GradeLevel::create($validated);

        return redirect()->route('grade_levels.index')
                         ->with('success', 'Grade Level created successfully!');
    }

    // SHOW EDIT FORM
    public function edit($id)
    {
        $grade = GradeLevel::findOrFail($id);
        return view('grade_levels.edit', compact('grade'));
    }

    // UPDATE GRADE LEVEL
    public function update(Request $request, $id)
    {
        $grade = GradeLevel::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:20|unique:grade_levels,code,' . $grade->id,
        ]);

        $grade->update($validated);

        return redirect()->route('grade_levels.index')
                         ->with('success', 'Grade Level updated successfully!');
    }

    // DELETE GRADE LEVEL
    public function destroy($id)
    {
        $grade = GradeLevel::findOrFail($id);
        $grade->delete();

        return redirect()->route('grade_levels.index')
                         ->with('success', 'Grade Level deleted successfully!');
    }
}
