<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Payment;
use App\Models\Fee;
use App\Models\FinancialInformation;
use App\Models\SubjectOffering;
use App\Models\EnrollmentSubjectOffering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


class EnrollmentController extends Controller
{
    // Display a listing of enrollments
    public function index(Request $request)
    {
        $semesterId = $request->get('semester_id');

        if (!$semesterId) {
            $activeSemester = Semester::where('status', 'active')->first();
            $semesterId = $activeSemester->id ?? null;
        }

        $semesters = Semester::orderBy('start_date', 'desc')->get();

        $enrollments = Enrollment::with(['student', 'semester'])
            ->when($semesterId, fn($query) => $query->where('semester_id', $semesterId))
            ->paginate(15);

        return view('enrollments.index', compact('enrollments', 'semesters', 'semesterId'));
    }

    // public function create(Request $request)
    // {
    //     $semesterOptions = Semester::orderBy('start_date', 'desc')->get();
    //     $gradeLevels = \App\Models\GradeLevel::orderBy('name')->get();
    //     $students = Student::all();

    //     $selectedSemesterId = $request->get('semester_id');
    //     $selectedGradeLevelId = $request->get('grade_level_id');

    //     // Available students (not yet enrolled in selected semester)
    //     $availableStudentIds = $students->pluck('id');
    //     if ($selectedSemesterId) {
    //         $enrolledStudentIds = Enrollment::where('semester_id', $selectedSemesterId)
    //             ->pluck('student_id');

    //         $availableStudentIds = $students->pluck('id')->diff($enrolledStudentIds);
    //     }

    //     // Fetch subjects for selected grade level and semester
    //     $subjects = collect();
    //     if ($selectedSemesterId && $selectedGradeLevelId) {
    //         $subjects = \App\Models\SubjectOffering::where('semester_id', $selectedSemesterId)
    //             ->whereHas('subject', fn($q) => $q->where('grade_level_id', $selectedGradeLevelId))
    //             ->with('subject')
    //             ->get();
    //     }

    //     return view('enrollments.create', compact(
    //         'students',
    //         'gradeLevels',
    //         'availableStudentIds',
    //         'subjects'
    //     ))
    //         ->with('semesters', $semesterOptions)
    //         ->with('selectedSemesterId', $selectedSemesterId)
    //         ->with('selectedGradeLevelId', $selectedGradeLevelId);
    // }


    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'student_id' => [
    //             'required',
    //             'exists:students,id',
    //             Rule::unique('enrollments')->where(fn($q) => $q->where('semester_id', $request->semester_id)),
    //         ],
    //         'semester_id' => 'required|exists:semesters,id',
    //         'grade_level_id' => 'required|exists:grade_levels,id',
    //         'category' => 'required|string|in:new,old,shifter',
    //         // Fees
    //         'tuition_fee' => 'required|numeric|min:0',
    //         'lab_fee' => 'nullable|numeric|min:0',
    //         'miscellaneous_fee' => 'nullable|numeric|min:0',
    //         'other_fee' => 'nullable|numeric|min:0',
    //         'discount' => 'nullable|numeric|min:0',
    //         'initial_payment' => 'nullable|numeric|min:0',
    //         // Payment status
    //         'prelims_paid' => 'nullable|boolean',
    //         'midterms_paid' => 'nullable|boolean',
    //         'pre_final_paid' => 'nullable|boolean',
    //         'final_paid' => 'nullable|boolean',
    //         // Financial info
    //         'financier' => 'nullable|string',
    //         'company_name' => 'nullable|string',
    //         'company_address' => 'nullable|string',
    //         'contact_number' => 'nullable|string',
    //         'income' => 'nullable|numeric|min:0',
    //         'scholarship' => 'nullable|numeric|min:0',
    //         'relative_names' => 'nullable|array',
    //         'relationships' => 'nullable|array',
    //         'position_courses' => 'nullable|array',
    //         'relative_contact_numbers' => 'nullable|array',
    //     ]);

    //     DB::transaction(function () use ($validated) {

    //         // 1️⃣ Create Enrollment
    //         $enrollment = Enrollment::create([
    //             'student_id' => $validated['student_id'],
    //             'semester_id' => $validated['semester_id'],
    //             'category' => $validated['category'],
    //             'grade_level_id' => $validated['grade_level_id'],
    //         ]);

    //         // 2️⃣ Automatically attach subjects (based on grade level + semester)
    //         $subjectOfferings = \App\Models\SubjectOffering::where('semester_id', $validated['semester_id'])
    //             ->whereHas('subject', fn($q) => $q->where('grade_level_id', $validated['grade_level_id']))
    //             ->pluck('id');

    //         foreach ($subjectOfferings as $offeringId) {
    //             \App\Models\EnrollmentSubjectOffering::updateOrCreate(
    //                 ['enrollment_id' => $enrollment->id, 'subject_offering_id' => $offeringId],
    //                 ['status' => 'enrolled', 'grade' => null]
    //             );
    //         }

    //         // 3️⃣ Create Fees
    //         $totalFees = ($validated['tuition_fee'] ?? 0)
    //             + ($validated['lab_fee'] ?? 0)
    //             + ($validated['miscellaneous_fee'] ?? 0)
    //             + ($validated['other_fee'] ?? 0);

    //         $discount = $validated['discount'] ?? 0;
    //         $initialPayment = $validated['initial_payment'] ?? 0;
    //         $remainingBalance = max($totalFees - $discount - $initialPayment, 0);
    //         $installment = $remainingBalance / 4;

    //         $fee = Fee::create([
    //             'enrollment_id' => $enrollment->id,
    //             'tuition_fee' => $validated['tuition_fee'],
    //             'lab_fee' => $validated['lab_fee'] ?? 0,
    //             'miscellaneous_fee' => $validated['miscellaneous_fee'] ?? 0,
    //             'other_fee' => $validated['other_fee'] ?? 0,
    //             'discount' => $discount,
    //             'initial_payment' => $initialPayment,
    //         ]);

    //         Payment::create([
    //             'fee_id' => $fee->id,
    //             'prelims_payment' => $installment,
    //             'prelims_paid' => $validated['prelims_paid'] ?? false,
    //             'midterms_payment' => $installment,
    //             'midterms_paid' => $validated['midterms_paid'] ?? false,
    //             'pre_final_payment' => $installment,
    //             'pre_final_paid' => $validated['pre_final_paid'] ?? false,
    //             'final_payment' => $installment,
    //             'final_paid' => $validated['final_paid'] ?? false,
    //             'status' => 'Pending',
    //         ]);

    //         // 4️⃣ Update student status
    //         $enrollment->student->update(['status' => 'enrolled']);
    //     });

    //     return redirect()->route('enrollments.index')->with('success', 'Enrollment created successfully!');
    // }





    public function create(Request $request)
    {
        // Active semester
        $activeSemester = Semester::where('status', 'active')->first();

        if (!$activeSemester) {
            return back()->with('error', 'No active semester found.');
        }

        $gradeLevels = GradeLevel::orderBy('name')->get();
        $students = Student::orderBy('surname')->get();

        $selectedGradeLevelId = $request->get('grade_level_id') ?? old('grade_level_id');

        // Students not yet enrolled in this semester
        $enrolledStudents = Enrollment::where('semester_id', $activeSemester->id)->pluck('student_id');
        $availableStudentIds = $students->pluck('id')->diff($enrolledStudents);

        // Sections for selected grade level & active semester
        $sections = collect();
        if ($selectedGradeLevelId) {
            $sectionsQuery = Section::withCount([
                'enrollments as enrollments_count' => function ($q) use ($activeSemester) {
                    $q->where('semester_id', $activeSemester->id);
                }
            ])->where('grade_level_id', $selectedGradeLevelId);

            // Get all sections first, then filter by capacity
            $sections = $sectionsQuery->get()->filter(function ($section) {
                return $section->enrollments_count < $section->max_students;
            });
        }

        // Subjects for selected grade level & active semester
        $subjects = collect();
        if ($selectedGradeLevelId) {
            $subjects = SubjectOffering::with(['subject', 'teacher.user'])
                ->where('semester_id', $activeSemester->id)
                ->whereHas('subject', function ($q) use ($selectedGradeLevelId) {
                    $q->where('grade_level_id', $selectedGradeLevelId);
                })
                ->get();
        }

        return view('enrollments.create', compact(
            'activeSemester',
            'gradeLevels',
            'students',
            'availableStudentIds',
            'sections',
            'subjects',
            'selectedGradeLevelId'
        ));
    }


    public function store(Request $request)
    {
        // dd('STORE HIT', $request->all());
        $validated = $request->validate([
            'student_id'        => [
                'required',
                'exists:students,id',
                Rule::unique('enrollments')->where(
                    fn($q) => $q->where('semester_id', $request->semester_id)
                ),
            ],
            'semester_id'       => 'required|exists:semesters,id',
            'grade_level_id'    => 'required|exists:grade_levels,id',
            'section_id'        => 'required|exists:sections,id',
            'category'          => 'required|string|in:new,old,shifter',

            // FINANCIAL DATA
            'tuition_fee'       => 'required|numeric|min:0',
            'lab_fee'           => 'nullable|numeric|min:0',
            'miscellaneous_fee' => 'nullable|numeric|min:0',
            'other_fee'         => 'nullable|numeric|min:0',
            'discount'          => 'nullable|numeric|min:0',
            'initial_payment'   => 'nullable|numeric|min:0',

            //    Financial info
            'financier' => 'nullable|string',
            'company_name' => 'nullable|string',
            'company_address' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'income' => 'nullable|numeric|min:0',
            'scholarship' => 'nullable|numeric|min:0',
            'relative_names' => 'nullable|array',
            'relationships' => 'nullable|array',
            'position_courses' => 'nullable|array',
            'relative_contact_numbers' => 'nullable|array',
        ]);

        Log::info('Enrollment validated data:', $validated);

        DB::transaction(function () use ($validated) {

            // 1️⃣ Check section capacity
            $section = Section::withCount(['enrollments' => function ($q) use ($validated) {
                $q->where('semester_id', $validated['semester_id']);
            }])->findOrFail($validated['section_id']);

            if ($section->enrollments_count >= $section->max_students) {
                throw ValidationException::withMessages([
                    'section_id' => "The selected section '{$section->name}' is already full."
                ]);
            }

            // 2️⃣ Create Enrollment
            $enrollment = Enrollment::create([
                'student_id'     => $validated['student_id'],
                'semester_id'    => $validated['semester_id'],
                'grade_level_id' => $validated['grade_level_id'],
                'section_id'     => $section->id,
                'category'       => $validated['category'],
            ]);

            Log::info("Enrollment created", ['enrollment_id' => $enrollment->id]);

            // 3️⃣ Attach Subject Offerings
            $subjectOfferings = SubjectOffering::where('semester_id', $validated['semester_id'])
                ->where('section_id', $section->id)
                ->get();

            foreach ($subjectOfferings as $offering) {
                EnrollmentSubjectOffering::updateOrCreate(
                    [
                        'enrollment_id'       => $enrollment->id,
                        'subject_offering_id' => $offering->id
                    ],
                    [
                        'status' => 'enrolled',
                        'grade'  => null
                    ]
                );
            }

            // 4️⃣ Fees & Payments
            $total = ($validated['tuition_fee'] ?? 0)
                + ($validated['lab_fee'] ?? 0)
                + ($validated['miscellaneous_fee'] ?? 0)
                + ($validated['other_fee'] ?? 0);

            $discount = $validated['discount'] ?? 0;
            $initial  = $validated['initial_payment'] ?? 0;
            $remaining = max($total - $discount - $initial, 0);
            $installment = $remaining / 4;

            $fee = Fee::create([
                'enrollment_id'     => $enrollment->id,
                'tuition_fee'       => $validated['tuition_fee'],
                'lab_fee'           => $validated['lab_fee'] ?? 0,
                'miscellaneous_fee' => $validated['miscellaneous_fee'] ?? 0,
                'other_fee'         => $validated['other_fee'] ?? 0,
                'discount'          => $discount,
                'initial_payment'   => $initial,
            ]);

            Payment::create([
                'fee_id'            => $fee->id,
                'prelims_payment'   => $installment,
                'midterms_payment'  => $installment,
                'pre_final_payment' => $installment,
                'final_payment'     => $installment,
                'prelims_paid'      => false,
                'midterms_paid'     => false,
                'pre_final_paid'    => false,
                'final_paid'        => false,
                'status'            => 'Pending',
            ]);

            // 5️⃣ Update student status
            $enrollment->student->update(['status' => 'enrolled']);
            Log::info("Enrollment transaction completed", ['enrollment_id' => $enrollment->id]);
        });


        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment created successfully!');
    }





    // Delete an enrollment
    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $studentId = $enrollment->student_id; // Retrieve student_id before deletion
        $enrollment->delete();

        // Update the student's status

        Student::where('id', $studentId)->update(['status' => 'not_enrolled']);


        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully!');
    }

    public function getSubjects(Request $request)
    {
        $gradeLevelId = $request->input('grade_level_id');
        $semesterId   = $request->input('semester_id');

        // Ensure we have a semester ID, fallback to active semester
        if (!$semesterId) {
            $activeSemester = Semester::where('status', 'active')->first();
            $semesterId = $activeSemester?->id;
        }

        // Query subjects
        $subjects = Subject::with(['gradeLevel', 'subjectOfferings' => function ($q) use ($semesterId) {
            $q->where('semester_id', $semesterId);
        }]);

        // Filter by grade level if provided
        if ($gradeLevelId) {
            $subjects->where('grade_level_id', $gradeLevelId);
        }

        $subjects = $subjects->get();

        // Group by grade level name (optional)
        $subjectsByGrade = $subjects->groupBy(fn($subject) => $subject->gradeLevel->name ?? 'Unknown');

        // Transform to a simple structure for frontend
        $result = [];
        foreach ($subjectsByGrade as $gradeName => $subjects) {
            $result[$gradeName] = $subjects->map(fn($s) => [
                'id'   => $s->id,
                'name' => $s->name,
                'code' => $s->code,
                'offerings' => $s->subjectOfferings->map(fn($so) => [
                    'id' => $so->id,
                    'teacher_id' => $so->teacher_id,
                    'room' => $so->room,
                    'days' => $so->days,
                    'start_time' => $so->start_time,
                    'end_time' => $so->end_time,
                ]),
            ]);
        }

        return response()->json($result);
    }




    public function fees($id)
    {
        $enrollment = Enrollment::with(['student', 'subjectOfferings', 'fees', 'fees.payments', 'financialInformation'])->findOrFail($id);


        $user = auth()->user(); // Get the logged-in user
        $student = $enrollment->student;
        // Ensure the user is a teacher and can only access their own profile
        if ($user->hasRole('student') && optional($user->student)->id !== $student->id) {
            abort(403, 'Unauthorized access');
        }

        // Initialize variables
        $totalFees = 0;
        $remainingBalance = 0;
        $installmentAmount = 0;
        $overallStatus = 'Paid';
        $balance = 0; // Sum of all fees minus discounts and initial payment
        $remainingPayment = 0;
        $payment = null;

        if ($enrollment->fees && $enrollment->fees->payments) {
            $payment = $enrollment->fees->payments;

            // Fees calculation
            $tuitionFee = $enrollment->fees->tuition_fee ?? 0;
            $labFee = $enrollment->fees->lab_fee ?? 0;
            $miscFee = $enrollment->fees->miscellaneous_fee ?? 0;
            $otherFee = $enrollment->fees->other_fee ?? 0;
            $discount = $enrollment->fees->discount ?? 0;
            $initialPayment = $enrollment->fees->initial_payment ?? 0;

            // Step 1: Calculate the total fees (sum of all fees)
            $totalFees = $tuitionFee + $labFee + $miscFee + $otherFee;

            // Step 2: Calculate the balance after discount and initial payment
            $balance = $totalFees - $discount - $initialPayment;

            // Step 3: Initialize remainingBalance to the balance
            $remainingBalance = $balance;

            // Deduct payments made only for installments marked as 'Paid'
            if ($payment->prelims_paid) {
                $remainingBalance -= $payment->prelims_payment;
            }
            if ($payment->midterms_paid) {
                $remainingBalance -= $payment->midterms_payment;
            }
            if ($payment->pre_final_paid) {
                $remainingBalance -= $payment->pre_final_payment;
            }
            if ($payment->final_paid) {
                $remainingBalance -= $payment->final_payment;
            }

            // Ensure no negative remaining balance
            $remainingBalance = max($remainingBalance, 0);

            // Step 4: Calculate installment amount (remaining balance divided by 4)
            $installmentAmount = $remainingBalance / 4;

            // Overall status calculation (whether all payments are made)
            if (!$payment->prelims_paid || !$payment->midterms_paid || !$payment->pre_final_paid || !$payment->final_paid) {
                $overallStatus = 'Pending';
            }
        }

        // Return the view with the necessary data
        return view('enrollments.fees', compact('enrollment', 'totalFees', 'balance', 'installmentAmount', 'payment', 'remainingBalance', 'overallStatus'));
    }


    public function edit($id)
    {
        $enrollment = Enrollment::with(['student', 'section', 'gradeLevel', 'semester'])->findOrFail($id);

        // All students
        $students = Student::orderBy('surname')->get();

        // Active semester is the one of the enrollment (not editable)
        $activeSemester = $enrollment->semester;

        // Grade levels
        $gradeLevels = GradeLevel::orderBy('name')->get();

        $fee = $enrollment->fees;

        // Sections for this grade level & semester
        $sectionsQuery = Section::withCount([
            'enrollments as enrollments_count' => function ($q) use ($activeSemester) {
                $q->where('semester_id', $activeSemester->id);
            }
        ])->where('grade_level_id', $enrollment->grade_level_id);

        $sections = $sectionsQuery->get()->filter(fn($s) => $s->enrollments_count < $s->max_students || $s->id == $enrollment->section_id);

        // Subjects for this grade level & semester
        $subjects = SubjectOffering::with(['subject', 'teacher.user'])
            ->where('semester_id', $activeSemester->id)
            ->whereHas('subject', fn($q) => $q->where('grade_level_id', $enrollment->grade_level_id))
            ->get();

        // Students not yet enrolled (allow current student)
        $enrolledStudents = Enrollment::where('semester_id', $activeSemester->id)
            ->where('id', '!=', $enrollment->id)
            ->pluck('student_id');
        $availableStudentIds = $students->pluck('id')->diff($enrolledStudents);

        return view('enrollments.edit', compact(
            'enrollment',
            'students',
            'availableStudentIds',
            'activeSemester',
            'gradeLevels',
            'sections',
            'subjects'
        ));
    }



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'grade_level_id' => 'required|exists:grade_levels,id',
            'section_id' => 'required|exists:sections,id',
            'category' => 'required|string|in:new,old,shifter',
            'tuition_fee' => 'required|numeric|min:0',
            'lab_fee' => 'nullable|numeric|min:0',
            'miscellaneous_fee' => 'nullable|numeric|min:0',
            'other_fee' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'initial_payment' => 'nullable|numeric|min:0',
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subject_offerings,id',
            'financier' => 'nullable|string',
            'company_name' => 'nullable|string',
            'company_address' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'income' => 'nullable|numeric|min:0',
            'scholarship' => 'nullable|numeric|min:0',
            'relative_names' => 'nullable|array',
            'relationships' => 'nullable|array',
            'position_courses' => 'nullable|array',
            'relative_contact_numbers' => 'nullable|array',
        ]);

        DB::transaction(function () use ($validated, $id, $request) {

            $enrollment = Enrollment::findOrFail($id);

            // 1️⃣ Check section capacity if changed
            if ($validated['section_id'] != $enrollment->section_id) {
                $section = Section::withCount(['enrollments' => function ($q) use ($validated) {
                    $q->where('semester_id', $validated['semester_id']);
                }])->findOrFail($validated['section_id']);

                if ($section->enrollments_count >= $section->max_students) {
                    throw ValidationException::withMessages([
                        'section_id' => "The selected section '{$section->name}' is already full."
                    ]);
                }
            }

            // 2️⃣ Update enrollment
            $enrollment->update([
                'student_id' => $validated['student_id'],
                'semester_id' => $validated['semester_id'],
                'grade_level_id' => $validated['grade_level_id'],
                'section_id' => $validated['section_id'],
                'category' => $validated['category'],
            ]);

            // 3️⃣ Update subjects
            if (!empty($validated['subjects'])) {
                $currentSubjects = EnrollmentSubjectOffering::where('enrollment_id', $enrollment->id)
                    ->pluck('subject_offering_id')->toArray();

                $newSubjects = $validated['subjects'];

                // Remove unselected
                EnrollmentSubjectOffering::where('enrollment_id', $enrollment->id)
                    ->whereNotIn('subject_offering_id', $newSubjects)
                    ->delete();

                // Add new
                foreach (array_diff($newSubjects, $currentSubjects) as $subjectId) {
                    EnrollmentSubjectOffering::updateOrCreate([
                        'enrollment_id' => $enrollment->id,
                        'subject_offering_id' => $subjectId
                    ], ['status' => 'enrolled', 'grade' => null]);
                }
            }

            // 4️⃣ Update fees
            $fee = Fee::firstOrCreate(
                ['enrollment_id' => $enrollment->id],
                [
                    'tuition_fee' => $validated['tuition_fee'],
                    'lab_fee' => $validated['lab_fee'] ?? 0,
                    'miscellaneous_fee' => $validated['miscellaneous_fee'] ?? 0,
                    'other_fee' => $validated['other_fee'] ?? 0,
                    'discount' => $validated['discount'] ?? 0,
                    'initial_payment' => $validated['initial_payment'] ?? 0,
                ]
            );

            $fee->update([
                'tuition_fee' => $validated['tuition_fee'],
                'lab_fee' => $validated['lab_fee'] ?? 0,
                'miscellaneous_fee' => $validated['miscellaneous_fee'] ?? 0,
                'other_fee' => $validated['other_fee'] ?? 0,
                'discount' => $validated['discount'] ?? 0,
                'initial_payment' => $validated['initial_payment'] ?? 0,
            ]);

            // 5️⃣ Update payment installments
            $total = $fee->tuition_fee + $fee->lab_fee + $fee->miscellaneous_fee + $fee->other_fee;
            $remaining = max($total - $fee->discount - $fee->initial_payment, 0);
            $installment = $remaining / 4;

            $payment = Payment::firstOrCreate(['fee_id' => $fee->id]);
            $payment->update([
                'prelims_payment' => $installment,
                'midterms_payment' => $installment,
                'pre_final_payment' => $installment,
                'final_payment' => $installment,
            ]);

            // 6️⃣ Update student status
            $enrollment->student->update(['status' => 'enrolled']);

            // 7️⃣ Update financial info
            $financialData = [
                'enrollment_id' => $enrollment->id,
                'financier' => $validated['financier'] ?? null,
                'company_name' => $validated['company_name'] ?? null,
                'company_address' => $validated['company_address'] ?? null,
                'contact_number' => $validated['contact_number'] ?? null,
                'income' => $validated['income'] ?? null,
                'scholarship' => $validated['scholarship'] ?? null,
                'relative_names' => json_encode($validated['relative_names'] ?? []),
                'relationships' => json_encode($validated['relationships'] ?? []),
                'position_courses' => json_encode($validated['position_courses'] ?? []),
                'relative_contact_numbers' => json_encode($validated['relative_contact_numbers'] ?? []),
            ];

            FinancialInformation::updateOrCreate(
                ['enrollment_id' => $enrollment->id],
                $financialData
            );
        });

        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully!');
    }
}
