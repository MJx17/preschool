<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        // We only have `semester` now (full name), no academic_year column
        $semesters = Semester::orderBy('start_date', 'desc')->get();

        return view('semesters.index', compact('semesters'));
    }

    public function create()
    {
        $semesterOptions = [];

        // Generate semesters for the current year + next 2 years
        for ($year = now()->year; $year <= now()->year + 5; $year++) {
            $next = $year + 1;

            // 1st Semester: June–October
            $semesterOptions[] = [
                'label' => "1st Semester {$year}-{$next}",
                'value' => "1st Semester {$year}-{$next}",
                'start_date' => "{$year}-06-01",
                'end_date'   => "{$year}-10-31",
            ];

            // 2nd Semester: November–March
            $semesterOptions[] = [
                'label' => "2nd Semester {$year}-{$next}",
                'value' => "2nd Semester {$year}-{$next}",
                'start_date' => "{$year}-11-01",
                'end_date'   => "{$next}-03-31",
            ];
        }

        return view('semesters.create', compact('semesterOptions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            // full name now in `semester`:
            'semester'   => 'required|string|max:100|unique:semesters,semester',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'required|in:upcoming,active,closed',
        ]);

        // Prevent multiple active semesters with the same name
        if ($request->status === 'active') {
            $existingActive = Semester::where('status', 'active')->first();
            if ($existingActive) {
                return back()->withInput()->withErrors([
                    'status' => 'There is already an active semester. Please close it before activating a new one.'
                ]);
            }
        }

        Semester::create([
            'semester'   => $request->semester,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'status'     => $request->status,
        ]);

        return redirect()->route('semesters.index')
            ->with('success', 'Semester created successfully!');
    }

    public function edit(Semester $semester)
    {
        $semesterOptions = [];

        for ($year = now()->year; $year <= now()->year + 5; $year++) {
            $next = $year + 1;

            $semesterOptions[] = [
                'label' => "1st Semester {$year}-{$next}",
                'value' => "1st Semester {$year}-{$next}",
                'start_date' => "{$year}-06-01",
                'end_date'   => "{$year}-10-31",
            ];

            $semesterOptions[] = [
                'label' => "2nd Semester {$year}-{$next}",
                'value' => "2nd Semester {$year}-{$next}",
                'start_date' => "{$year}-11-01",
                'end_date'   => "{$next}-03-31",
            ];
        }

        return view('semesters.edit', compact('semester', 'semesterOptions'));
    }


    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'semester'   => 'required|string|max:100|unique:semesters,semester,' . $semester->id,
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'required|in:upcoming,active,closed',
        ]);

        // Prevent multiple active semesters
        if ($request->status === 'active') {
            $existingActive = Semester::where('status', 'active')
                ->where('id', '!=', $semester->id)
                ->first();
            if ($existingActive) {
                return back()->withInput()->withErrors([
                    'status' => 'There is already an active semester. Please close it before activating a new one.'
                ]);
            }
        }

        $semester->update([
            'semester'   => $request->semester,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'status'     => $request->status,
        ]);

        return redirect()->route('semesters.index')
            ->with('success', 'Semester updated successfully!');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();

        return redirect()->route('semesters.index')
            ->with('success', 'Semester deleted successfully!');
    }
}
