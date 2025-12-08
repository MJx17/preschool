<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Models\SubjectOffering;
use App\Models\Semester;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /** Show the form for creating a new teacher */
    public function create()
    {
        $existingTeachers = Teacher::pluck('user_id'); // Get all teacher user IDs

        // now using Spatie's teacher role
        $users = User::role('teacher')
            ->whereNotIn('id', $existingTeachers)
            ->get();

        return view('teachers.create', compact('users'));
    }

    /** Store a new teacher */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id', function ($attribute, $value, $fail) {
                $user = User::find($value);
                if (!$user || !$user->hasRole('teacher')) {
                    $fail('The selected user does not have the teacher role.');
                }
            }],
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sex' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|unique:teachers',
            'designation' => 'required|string|max:255',
        ]);

        Teacher::create($request->only([
            'user_id',
            'surname',
            'first_name',
            'middle_name',
            'sex',
            'contact_number',
            'email',
            'designation'
        ]));

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully!');
    }

    /** Display a list of teachers */
    public function index()
    {
        $teachers = Teacher::paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    /** Edit a teacher */
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        $users = User::role('teacher')->get(); // All users with teacher role

        return view('teachers.edit', compact('teacher', 'users'));
    }

    /** Update a teacher */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id', function ($attribute, $value, $fail) {
                $user = User::find($value);
                if (!$user || !$user->hasRole('teacher')) {
                    $fail('The selected user does not have the teacher role.');
                }
            }],
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sex' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|unique:teachers,email,' . $id,
            'designation' => 'required|string|max:255',
        ]);

        $teacher = Teacher::findOrFail($id);
        $teacher->update($request->only([
            'user_id',
            'surname',
            'first_name',
            'middle_name',
            'sex',
            'contact_number',
            'email',
            'designation'
        ]));

        return redirect()->route('teachers.index')->with('updated', 'Teacher updated successfully!');
    }

    /** Delete a teacher */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect()->route('teachers.index')->with('deleted', 'Teacher deleted successfully!');
    }

    /** Show teacher profile + subjects taught */
    public function show($teacher_id)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        $user = auth()->user();

        // Authorization: teachers can only view their own
        if ($user->hasRole('teacher') && optional($user->teacher)->id !== $teacher->id) {
            abort(403, 'Unauthorized access');
        }

        // Get current active semester
        $currentSemester = Semester::where('status', 'active')->first();

        // Fetch teacher's subject offerings in active semester
        $subjectOfferings = SubjectOffering::with([
            'subject',
            'section',
            'enrollmentSubjectOfferings.enrollment.student',
            'semester'
        ])
            ->where('teacher_id', $teacher->id)
            ->where('semester_id', optional($currentSemester)->id)
            ->get();

        return view('teachers.show', compact('teacher', 'subjectOfferings'));
    }




    /** Only profile page */
    public function profile(Teacher $teacher)
    {
        $user = auth()->user();
        if ($user->hasRole('teacher') && optional($user->teacher)->id !== $teacher->id) {
            abort(403, 'Unauthorized access');
        }

        return view('teachers.profile', compact('teacher'));
    }

    public function subjects($teacher_id)
    {
        $user = auth()->user();

        // Ensure the logged-in teacher can only view their own subjects
        if ($user->hasRole('teacher') && optional($user->teacher)->id != $teacher_id) {
            abort(403, 'Unauthorized access');
        }

        $teacher = Teacher::findOrFail($teacher_id);

        // Fetch subject offerings assigned to this teacher
        $subjectOfferings = SubjectOffering::with(['subject', 'semester'])
            ->where('teacher_id', $teacher->id)
            ->paginate(10);

        return view('teachers.subjects', compact('teacher', 'subjectOfferings'));
    }
}
