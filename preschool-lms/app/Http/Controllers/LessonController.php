<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Section;
use App\Models\SubjectOffering;
use App\Models\Semester;
use App\Models\GradeLevel;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * List all lessons for the logged-in teacher.
     */
    public function index(Request $request)
    {
        $teacherId = auth()->user()->teacher->id;

        $query = Lesson::whereHas(
            'subjectOffering',
            fn($q) =>
            $q->where('teacher_id', $teacherId)
        )->with(
            'subjectOffering.subject',
            'subjectOffering.section',
            'subjectOffering.teacher.user'
        );

        // ── Filters ───────────────────────────────

        // Quarter filter
        if ($request->filled('quarter')) {
            $query->where('quarter', $request->quarter);
        }

        // Grade Level filter
        if ($request->filled('grade_level_id')) {
            $query->whereHas(
                'subjectOffering.subject',
                fn($q) =>
                $q->where('grade_level_id', $request->grade_level_id)
            );
        }

        // Subject filter
        if ($request->filled('subject_id')) {
            $query->whereHas(
                'subjectOffering',
                fn($q) =>
                $q->where('subject_id', $request->subject_id)
            );
        }

        // Section filter
        if ($request->filled('section_id')) {
            $query->whereHas(
                'subjectOffering',
                fn($q) =>
                $q->where('section_id', $request->section_id)
            );
        }

        $lessons = $query->latest()->paginate(10);

        // Teacher's subject offerings
        $subjectOfferings = SubjectOffering::where('teacher_id', $teacherId)
            ->with('subject', 'section')
            ->get();

        $subjects = $subjectOfferings->pluck('subject')->unique('id')->filter();
        $sections = $subjectOfferings->pluck('section')->unique('id')->filter();

        // Grade levels via subjects
        $gradeLevelIds = $subjects->pluck('grade_level_id')->filter()->unique()->values();
        $gradeLevels = \App\Models\GradeLevel::whereIn('id', $gradeLevelIds)->get();

        return view('lessons.index', [
            'lessons' => $lessons,
            'quarters' => [1, 2, 3, 4],
            'selectedQuarter' => $request->quarter,
            'subjects' => $subjects,
            'selectedSubject' => $request->subject_id,
            'sections' => $sections,
            'selectedSection' => $request->section_id,
            'gradeLevels' => $gradeLevels,
            'selectedGradeLevel' => $request->grade_level_id,
        ]);
    }



    public function adminIndex(Request $request)
    {
        $query = Lesson::with(
            'subjectOffering.subject',
            'subjectOffering.section',
            'subjectOffering.teacher.user'
        );

        // Teacher filter
        if ($request->filled('teacher_id')) {
            $query->whereHas(
                'subjectOffering',
                fn($q) =>
                $q->where('teacher_id', $request->teacher_id)
            );
        }

        // Subject filter
        if ($request->filled('subject_id')) {
            $query->whereHas(
                'subjectOffering',
                fn($q) =>
                $q->where('subject_id', $request->subject_id)
            );
        }

        // Section filter
        if ($request->filled('section_id')) {
            $query->whereHas(
                'subjectOffering',
                fn($q) =>
                $q->where('section_id', $request->section_id)
            );
        }

        // Quarter filter
        if ($request->filled('quarter')) {
            $query->where('quarter', $request->quarter);
        }

        // Grade level filter
        if ($request->filled('grade_level_id')) {
            $query->whereHas(
                'subjectOffering.subject',
                fn($q) =>
                $q->where('grade_level_id', $request->grade_level_id)
            );
        }

        $lessons = $query->latest()->paginate(20);

        // All grade levels
        $gradeLevels = GradeLevel::all();

        return view('lessons.admin.index', [
            'lessons' => $lessons,
            'teachers' => Teacher::with('user')->get(),
            'subjects' => Subject::all(),
            'sections' => Section::all(),
            'quarters' => [1, 2, 3, 4],
            'selectedQuarter' => $request->quarter,
            'gradeLevels' => $gradeLevels,
            'selectedGradeLevel' => $request->grade_level_id,
        ]);
    }


    /**
     * Show create form for a lesson.
     * Only includes subject offerings assigned to the teacher.
     */

    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            abort(403, 'Admins cannot create lessons.');
        }

        // Get the active semester
        $activeSemester = Semester::where('status', 'active')->first();

        // Get all subject offerings of this teacher for the active semester
        $offerings = SubjectOffering::with(['subject', 'section.gradeLevel'])
            ->where('teacher_id', $user->teacher->id)
            ->when($activeSemester, fn($query) => $query->where('semester_id', $activeSemester->id))
            ->get();

        // Deduplicate by subject_id + section_id
        $subjectOfferings = $offerings->unique(fn($item) => $item->subject_id . '-' . $item->section_id)
            ->map(fn($item) => [
                'id' => $item->id,
                'gradeLevel' => $item->section?->gradeLevel?->name ?? '-',
                'subjectCode' => $item->subject?->code ?? '-',
                'sectionName' => $item->section?->name ?? '-',
            ])
            ->values();

        return view('lessons.create', compact('subjectOfferings'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'                => 'required|string|max:255',
            'description'          => 'nullable|string',
            'image_url'            => 'nullable|url',
            'video_url'            => 'nullable|url',
            'document_url'         => 'nullable|url',
            'subject_offerings_id' => 'required|exists:subject_offerings,id',
            'quarter'              => 'required|in:1,2,3,4',
        ]);

        // Ensure the logged-in teacher owns the subject offering
        $subjectOffering = SubjectOffering::findOrFail($validated['subject_offerings_id']);
        if ($subjectOffering->teacher_id !== auth()->user()->teacher->id) {
            abort(403, 'You cannot create a lesson for this subject offering.');
        }

        Lesson::create($validated);

        return redirect()->route('lessons.index')
            ->with('success', 'Lesson created successfully!');
    }


    /**
     * Show a lesson.
     */
    public function show(Lesson $lesson)
    {
        // Optional: only allow teacher to view their own lesson
        if ($lesson->subjectOffering->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        // Convert YouTube and Google Docs links as before
        if ($lesson->video_url && str_contains($lesson->video_url, 'youtube.com/watch')) {
            $lesson->video_url = preg_replace('/watch\?v=([^\&\?\/]+)/', 'embed/$1', $lesson->video_url);
        }

        if ($lesson->document_url && str_contains($lesson->document_url, 'docs.google.com')) {
            $lesson->document_url = str_replace('/edit', '/preview', $lesson->document_url);
        }

        return view('lessons.show', compact('lesson'));
    }
    /**
     * Show edit form.
     */

    public function edit(Lesson $lesson)
    {
        $user = auth()->user();

        // Prevent admin from editing if needed
        if ($user->hasRole('admin')) {
            abort(403, 'Admins cannot edit lessons.');
        }

        // Get active semester
        $activeSemester = Semester::where('status', 'active')->first();

        // Get subject offerings for this teacher and active semester
        $subjectOfferings = SubjectOffering::with(['subject', 'section.gradeLevel'])
            ->when($activeSemester, fn($query) => $query->where('semester_id', $activeSemester->id))
            ->where('teacher_id', $user->teacher->id)
            ->get()
            ->unique('subject_id') // Remove duplicates by subject if needed
            ->map(fn($offering) => [
                'id' => $offering->id,
                'gradeLevel' => $offering->section?->gradeLevel?->name ?? '-',
                'subjectCode' => $offering->subject?->code ?? '-',
                'sectionName' => $offering->section?->name ?? '-',
            ])
            ->values(); // Reset keys for JSON

        return view('lessons.edit', compact('lesson', 'subjectOfferings'));
    }


    public function update(Request $request, Lesson $lesson)
    {
        $user = auth()->user();

        // Only allow teachers to update their own lessons
        if ($user->hasRole('teacher')) {
            if ($lesson->subjectOffering->teacher_id !== $user->teacher->id) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            abort(403, 'Admins cannot update lessons.');
        }

        // Validate request
        $validated = $request->validate([
            'title'                => 'required|string|max:255',
            'description'          => 'nullable|string',
            'image_url'            => 'nullable|url',
            'video_url'            => 'nullable|url',
            'document_url'         => 'nullable|url',
            'subject_offerings_id' => 'required|exists:subject_offerings,id',
            'quarter'              => 'required|in:1,2,3,4',
        ]);

        // Ensure selected subject offering belongs to teacher and active semester
        $subjectOffering = SubjectOffering::findOrFail($validated['subject_offerings_id']);
        $activeSemester = $subjectOffering->semester;

        if ($user->hasRole('teacher') && ($subjectOffering->teacher_id !== $user->teacher->id || $activeSemester->status !== 'active')) {
            abort(403, 'You can only select your own subject offerings in the active semester.');
        }

        // Update lesson
        $lesson->update($validated);

        return redirect()->route('lessons.index')
            ->with('success', 'Lesson updated successfully!');
    }
    
    public function destroy(Lesson $lesson)
    {
        $user = auth()->user();

        // Allow if admin role, otherwise check teacher ownership
        if (!$user->hasRole('admin') && $lesson->subjectOffering->teacher_id !== $user->teacher->id) {
            abort(403, 'Unauthorized action.');
        }

        $lesson->delete();

        // Redirect based on role
        if ($user->hasRole('admin')) {
            return redirect()->route('lessons.admin.index') // use admin-specific route
                ->with('success', 'Lesson deleted successfully!');
        } else {
            return redirect()->route('lessons.index') // teacher route
                ->with('success', 'Lesson deleted successfully!');
        }
    }
}
