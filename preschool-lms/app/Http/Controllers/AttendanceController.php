<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use App\Models\SubjectOffering;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = AttendanceSession::with(['subjectOffering.subject', 'subjectOffering.teacher']);

        // Optional filters for admin/teacher
        if ($request->has('subject_offering_id') && $request->subject_offering_id != 'all') {
            $query->where('subject_offering_id', $request->subject_offering_id);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        }

        $sessions = $query->latest()->paginate(10);
        $subjectOfferings = SubjectOffering::with('subject')->get();

        return view('attendance.index', compact('sessions', 'subjectOfferings'));
    }

    public function create($subjectOfferingId)
    {
        $subjectOffering = SubjectOffering::findOrFail($subjectOfferingId);
        $students = $this->getStudentsForSubject($subjectOfferingId);

        return view('attendance.create', compact('subjectOffering', 'students'));
    }

    public function store(Request $request, $subjectOfferingId)
    {
        $session = AttendanceSession::create([
            'subject_offering_id' => $subjectOfferingId,
            'date' => $request->date ?? now()->toDateString(),
            'topic' => $request->topic,
        ]);

        foreach ($request->students as $studentId => $status) {
            $session->attendanceRecords()->create([
                'student_id' => $studentId,
                'status' => $status,
            ]);
        }

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully!');
    }

    private function getStudentsForSubject($subjectOfferingId)
    {
        return \App\Models\Student::whereHas('enrollments.enrollmentOfferings', function ($q) use ($subjectOfferingId) {
            $q->where('subject_offering_id', $subjectOfferingId);
        })->get();
    }

    public function teacherSubjects()
{
    $user = auth()->user();

    // Only teachers can access this
    if (!$user->hasRole('teacher')) {
        abort(403, 'Only teachers can view their assigned subjects.');
    }

    // Fetch only the subjects assigned to this teacher
    $subjects = \App\Models\SubjectOffering::with(['subject', 'section'])
        ->where('teacher_id', $user->id)
        ->get();

    // If you want to use it via AJAX, return JSON:
    if (request()->wantsJson()) {
        return response()->json($subjects);
    }

    // Or return a view for teachers to pick a subject
    return view('attendance.teacher-subjects', compact('subjects'));
}

}
