<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use App\Models\AttendanceRecord;
use App\Models\Subject;
use App\Models\SubjectOffering;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Admin: list all subjects and their offerings
     */
    public function adminIndex(Request $request)
    {
        $subjectsQuery = Subject::with([
            'subjectOfferings.teacher.user',
            'subjectOfferings.section',
            'subjectOfferings.semester'
        ]);

        if ($request->has('subject') && $request->subject != 'all') {
            $subjectsQuery->where('name', 'LIKE', "%{$request->subject}%");
        }

        $subjects = $subjectsQuery->orderBy('name')->get();

        return view('attendance.admin.index', compact('subjects'));
    }

    /**
     * Teacher: list only subjects they teach
     */
    public function teacherIndex(Request $request)
    {
        $user = auth()->user();

        // Get the teacher model for the logged-in user
        $teacher = $user->teacher; // assuming User hasOne Teacher

        // Base query: subjects that the logged-in teacher teaches
        $subjectsQuery = Subject::whereHas('subjectOfferings', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        });

        // Filter by selected subject
        if ($request->filled('subject') && $request->subject !== 'all') {
            $subjectsQuery->where('id', $request->subject);
        }

        // Eager load only offerings for this teacher
        $subjects = $subjectsQuery->with(['subjectOfferings' => function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id)
                ->with(['teacher.user', 'section', 'semester']);
        }])->get();

        return view('attendance.teacher.index', compact('subjects'));
    }









    /**
     * View attendance history for a subject offering
     */
    // Admin view
    public function adminView($subjectOfferingId)
    {
        $subjectOffering = SubjectOffering::with([
            'subject',
            'teacher.user',
            'section',
            'semester',
            'attendanceSessions.attendanceRecords.student'
        ])->findOrFail($subjectOfferingId);

        return view('attendance.admin.view', compact('subjectOffering'));
    }

    // Teacher view
    public function teacherView($subjectOfferingId)
    {
        $subjectOffering = SubjectOffering::with([
            'subject',
            'teacher.user',
            'section',
            'semester',
            'attendanceSessions.attendanceRecords.student'
        ])->findOrFail($subjectOfferingId);

        return view('attendance.teacher.view', compact('subjectOffering'));
    }


    /**
     * Show form for creating attendance
     */
    public function create($subjectOfferingId)
    {
        $user = auth()->user();
        $teacher = $user->teacher; // teacher model for the logged-in user

        $subjectOffering = SubjectOffering::with(['subject', 'teacher.user', 'section', 'semester'])
            ->where('teacher_id', $teacher->id) // match on teacher table ID
            ->findOrFail($subjectOfferingId);

        if (!$subjectOffering) {
            dd("Subject Offering not found for teacher {$user->id}", $subjectOfferingId);
        }

        $students = Student::whereHas('enrollments.enrollmentSubjectOfferings', function ($q) use ($subjectOfferingId) {
            $q->where('subject_offering_id', $subjectOfferingId);
        })->get();

        return view('attendance.teacher.create', compact('subjectOffering', 'students'));
    }



    /**
     * Store attendance records
     */
    public function store(Request $request, $subjectOfferingId)
    {
        $session = AttendanceSession::create([
            'subject_offering_id' => $subjectOfferingId,
            'date' => $request->date ?? now()->toDateString(),
            'topic' => $request->topic,
        ]);

        // Determine whether the input is 'students' or 'status'
        $attendanceData = $request->input('status') ?? $request->input('students');

        if ($attendanceData) {
            // Normalize to array if only one student
            if (!is_array($attendanceData)) {
                $attendanceData = [$attendanceData];
            }

            foreach ($attendanceData as $studentId => $status) {
                AttendanceRecord::create([
                    'attendance_session_id' => $session->id,
                    'student_id' => $studentId,
                    'status' => $status,
                    'remarks' => $request->remarks[$studentId] ?? null
                ]);
            }
        }

        return redirect()->route('attendance.teacher.view', $subjectOfferingId)
            ->with('success', 'Attendance recorded successfully!');
    }


    /**
     * Show form to edit an existing attendance session
     */
    public function edit($sessionId)
    {
        $session = AttendanceSession::with([
            'subjectOffering.subject',
            'attendanceRecords.student'
        ])->findOrFail($sessionId);

        return view('attendance.teacher.edit', compact('session'));
    }

    /**
     * Update an existing attendance session
     */
    public function update(Request $request, $sessionId)
    {
        $session = AttendanceSession::findOrFail($sessionId);
        $session->update([
            'topic' => $request->topic,
            'date' => $request->date ?? $session->date
        ]);

        foreach ($request->status as $recordId => $status) {
            $record = AttendanceRecord::findOrFail($recordId);
            $record->update([
                'status' => $status,
                'remarks' => $request->remarks[$recordId] ?? null
            ]);
        }

        return redirect()->route('attendance.teacher.view', $session->subject_offering_id)
            ->with('success', 'Attendance updated successfully!');
    }

    /**
     * Delete an attendance session and its records
     */
    public function destroy($sessionId)
    {
        $session = AttendanceSession::findOrFail($sessionId);
        $subjectOfferingId = $session->subject_offering_id;

        $session->attendanceRecords()->delete();
        $session->delete();

        return redirect()->route('attendance.teacher.view', $subjectOfferingId)
            ->with('success', 'Attendance session deleted successfully!');
    }
}
