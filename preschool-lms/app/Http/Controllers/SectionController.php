<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\GradeLevel;
use App\Models\Semester;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    // LIST ALL SECTIONS
    public function index()
    {
        $activeSemester = Semester::where('status', 'active')->first();

        $sections = Section::with('gradeLevel')
            ->withCount(['enrollments as enrollments_count' => function ($query) use ($activeSemester) {
                if ($activeSemester) {
                    $query->where('semester_id', $activeSemester->id);
                }
            }])
            ->orderBy('grade_level_id')
            ->orderBy('name')
            ->get();

        return view('sections.index', compact('sections', 'activeSemester'));
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
            'name' => [
                'required',
                'string',
                'max:50',
                // UNIQUE per grade level
                function ($attribute, $value, $fail) use ($request) {
                    if (Section::where('grade_level_id', $request->grade_level_id)
                        ->where('name', $value)
                        ->exists()
                    ) {
                        $fail('This section name already exists in the selected grade level.');
                    }
                },
            ],
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
            'name' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($request, $section) {
                    if (Section::where('grade_level_id', $request->grade_level_id)
                        ->where('name', $value)
                        ->where('id', '!=', $section->id)
                        ->exists()
                    ) {
                        $fail('This section name already exists in the selected grade level.');
                    }
                },
            ],
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
        $activeSemester = Semester::where('status', 'active')->first();

        if (!$activeSemester) {
            return response()->json([]);
        }

        $sections = Section::withCount([
            'enrollments as enrollments_count' => function ($q) use ($activeSemester) {
                $q->where('semester_id', $activeSemester->id);
            }
        ])
            ->where('grade_level_id', $gradeLevelId)
            ->get()
            ->filter(fn($s) => $s->enrollments_count < $s->max_students)
            ->values(); // Reindex so Alpine.js works properly

        return response()->json($sections);
    }


    public function show($id)
    {
        $activeSemester = Semester::where('status', 'active')->first();

        $section = Section::with(['gradeLevel'])
            ->with(['enrollments' => function ($query) use ($activeSemester) {
                if ($activeSemester) {
                    $query->where('semester_id', $activeSemester->id)
                        ->with('student'); // eager load student
                }
            }])
            ->findOrFail($id);

        return view('sections.show', compact('section', 'activeSemester'));
    }
}
