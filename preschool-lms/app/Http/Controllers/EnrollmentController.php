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
        $semesters = Semester::orderBy('start_date', 'desc')->get();
        $gradeLevels = GradeLevel::orderBy('name')->get();
        $students = Student::orderBy('surname')->get();

        $selectedSemesterId = $request->get('semester_id');
        $selectedGradeLevelId = $request->get('grade_level_id');

        // Available students (not already enrolled in this semester)
        $availableStudentIds = $students->pluck('id');
        if ($selectedSemesterId) {
            $enrolledStudentIds = Enrollment::where('semester_id', $selectedSemesterId)->pluck('student_id');
            $availableStudentIds = $availableStudentIds->diff($enrolledStudentIds);
        }

        // Load sections only if grade level and semester are selected
        $sections = collect();
        if ($selectedGradeLevelId && $selectedSemesterId) {
            $sections = Section::withCount(['enrollments' => function ($q) use ($selectedSemesterId) {
                $q->where('semester_id', $selectedSemesterId);
            }])
                ->where('grade_level_id', $selectedGradeLevelId)
                ->get()
                ->filter(fn($section) => $section->enrollments_count < $section->max_students);
        }

        // Load subjects
        $subjects = collect();
        if ($selectedSemesterId && $selectedGradeLevelId) {
            $subjects = SubjectOffering::with(['subject', 'teacher.user'])
                ->where('semester_id', $selectedSemesterId)
                ->whereHas('subject', fn($q) => $q->where('grade_level_id', $selectedGradeLevelId))
                ->get();
        }

        return view('enrollments.create', compact(
            'semesters',
            'gradeLevels',
            'students',
            'availableStudentIds',
            'sections',
            'subjects',
            'selectedSemesterId',
            'selectedGradeLevelId'
        ));
    }


    public function store(Request $request)
    {
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
        ]);

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
        // Start query for subjects
        $query = Subject::query()->with('gradeLevel');

        // If a grade_level_id filter is passed
        if ($request->filled('grade_level_id')) {
            $query->where('grade_level_id', $request->grade_level_id);
        }

        // If a semester_id filter is passed, only include subjects offered in that semester
        if ($request->filled('semester_id')) {
            $query->whereHas('subjectOfferings', function ($q) use ($request) {
                $q->where('semester_id', $request->semester_id);
            });
        }

        // Get subjects and group by grade level name
        $subjects = $query->get()->groupBy(function ($subject) {
            return $subject->gradeLevel->name ?? 'Unknown';
        });

        return response()->json($subjects);
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
        $enrollment = Enrollment::findOrFail($id);

        // All students
        $students = Student::all();

        // All active semesters
        $semesters = Semester::all();

        // Get subjects for this enrollment based on semester + grade_level
        $subjects = Subject::where('semester_id', $enrollment->semester_id)
            ->where('grade_level', $enrollment->grade_level)
            ->get();

        // Selected subjects stored in enrollment
        $selectedSubjects = json_decode($enrollment->subject_ids, true);

        // Fee info
        $fee = Fee::where('enrollment_id', $id)->first();

        // Financial info
        $financialData = FinancialInformation::where('enrollment_id', $id)->first();

        // Payment info (if fee exists)
        $payment = $fee ? Payment::where('fee_id', $fee->id)->first() : null;

        return view(
            'enrollments.edit',
            compact(
                'enrollment',
                'students',
                'semesters',
                'subjects',
                'selectedSubjects',
                'fee',
                'payment',
                'financialData'
            )
        );
    }



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id' => 'sometimes|exists:students,id',
            'semester_id' => 'sometimes|exists:semesters,id',
            'grade_level' => 'sometimes|string',
            'subjects' => 'sometimes|array',
            'subjects.*' => 'exists:subjects,id',
            'category' => 'sometimes|string',
            'tuition_fee' => 'sometimes|numeric',
            'lab_fee' => 'sometimes|nullable|numeric',
            'miscellaneous_fee' => 'sometimes|nullable|numeric',
            'other_fee' => 'sometimes|nullable|numeric',
            'discount' => 'sometimes|nullable|numeric',
            'initial_payment' => 'sometimes|numeric',
            'prelims_paid' => 'sometimes|boolean',
            'midterms_paid' => 'sometimes|boolean',
            'pre_final_paid' => 'sometimes|boolean',
            'final_paid' => 'sometimes|boolean',
            'financier' => 'nullable|string',
            'company_name' => 'nullable|string',
            'company_address' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'income' => 'nullable|numeric',
            'scholarship' => 'nullable|string',
            'relative_names' => 'sometimes|array',
            'relationships' => 'sometimes|array',
            'position_courses' => 'sometimes|array',
            'relative_contact_numbers' => 'sometimes|array',
        ]);

        try {
            DB::beginTransaction();

            // Find existing enrollment
            $enrollment = Enrollment::findOrFail($id);

            // Update only the provided fields for the enrollment
            $enrollment->update($request->only([
                'student_id',
                'semester_id',
                'course_id',
                'year_level',
                'category'
            ]));

            // Get related fee record
            $fee = Fee::where('enrollment_id', $id)->first();

            if ($fee) {
                // Update tuition fees and related fields if provided in the request
                $fee->update($request->only([
                    'tuition_fee',
                    'lab_fee',
                    'miscellaneous_fee',
                    'other_fee',
                    'discount',
                    'initial_payment',
                ]));

                // Recalculate balance after payment status
                $totalFees = $fee->tuition_fee + $fee->lab_fee + $fee->miscellaneous_fee + $fee->other_fee;
                $balance = $totalFees - $fee->discount - $fee->initial_payment;

                $payment = Payment::where('fee_id', $fee->id)->first();

                if ($payment) {
                    $payment->update([
                        'prelims_paid' => $request->has('prelims_paid') ? true : false,
                        'midterms_paid' => $request->has('midterms_paid') ? true : false,
                        'pre_final_paid' => $request->has('pre_final_paid') ? true : false,
                        'final_paid' => $request->has('final_paid') ? true : false,
                    ]);

                    // Deduct payments made only for installments marked as 'Paid'
                    if ($payment->prelims_paid) $balance -= $payment->prelims_payment;
                    if ($payment->midterms_paid) $balance -= $payment->midterms_payment;
                    if ($payment->pre_final_paid) $balance -= $payment->pre_final_payment;
                    if ($payment->final_paid) $balance -= $payment->final_payment;
                }

                $remainingBalance = max($balance, 0);
                $installmentAmount = $remainingBalance / 4;

                // Prepare financial data
                $financialData = [
                    'enrollment_id' => $enrollment->id,
                    'financier' => $validated['financier'] ?? null,
                    'company_name' => $validated['company_name'] ?? null,
                    'company_address' => $validated['company_address'] ?? null,
                    'contact_number' => $validated['contact_number'] ?? null,
                    'income' => $validated['income'] ?? null,
                    'scholarship' => $validated['scholarship'] ?? null,
                ];

                // Handle relative data fields with default empty arrays if not present
                $relativeNames = $validated['relative_names'] ?? [];
                $relationships = $validated['relationships'] ?? [];
                $positionCourses = $validated['position_courses'] ?? [];
                $relativeContactNumbers = $validated['relative_contact_numbers'] ?? [];

                // Fetch existing financial data (if any)
                $existingFinancialData = FinancialInformation::where('enrollment_id', $enrollment->id)->first();

                // Decode existing relative data if present, otherwise use empty arrays
                // Ensure all variables are arrays (if null, turn into empty arrays)
                $existingRelativeNames = $existingFinancialData ? json_decode($existingFinancialData->relative_names, true) : [];
                $existingRelationships = $existingFinancialData ? json_decode($existingFinancialData->relationships, true) : [];
                $existingPositionCourses = $existingFinancialData ? json_decode($existingFinancialData->position_courses, true) : [];
                $existingRelativeContactNumbers = $existingFinancialData ? json_decode($existingFinancialData->relative_contact_numbers, true) : [];

                // Merge new data with existing, ensuring no duplicates, while handling null values
                $relativeNames = array_unique(array_merge($existingRelativeNames ?: [], $relativeNames ?: []));
                $relationships = array_unique(array_merge($existingRelationships ?: [], $relationships ?: []));
                $positionCourses = array_unique(array_merge($existingPositionCourses ?: [], $positionCourses ?: []));
                $relativeContactNumbers = array_unique(array_merge($existingRelativeContactNumbers ?: [], $relativeContactNumbers ?: []));


                // Save or update the financial information with merged relative data
                $financialData['relative_names'] = json_encode($relativeNames);
                $financialData['relationships'] = json_encode($relationships);
                $financialData['position_courses'] = json_encode($positionCourses);
                $financialData['relative_contact_numbers'] = json_encode($relativeContactNumbers);

                // Check if financial data exists and update or create
                if ($existingFinancialData) {
                    $existingFinancialData->update($financialData);
                } else {
                    FinancialInformation::create($financialData);
                }
            }

            DB::commit();

            return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating enrollment.', 'error' => $e->getMessage()], 500);
        }
    }
}
