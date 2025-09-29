<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\CourseSubject;
use App\Models\StudentSubject;
use App\Models\TeacherSubject;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\FinancialInformation;
use Carbon\Carbon;

class DepartmentCourseSubjectSemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Step 1: Create Departments
        $departments = [
            'Mathematics',
            'Science',
            'English',
            'Filipino',
            'Araling Panlipunan',
            'MAPEH', // Music, Arts, PE, Health
            'TLE',   // Technology and Livelihood Education
            'Values Education'
        ];

        foreach ($departments as $departmentName) {
            Department::create(['name' => $departmentName]);
        }



        // Step 3: Create Semesters
        $semester1 = Semester::create([
            'academic_year' => '2022-2023',
            'semester' => '1st',
            'start_date' => Carbon::parse('2022-08-01'),
            'end_date' => Carbon::parse('2022-12-15'),
            'status' => 'closed',
        ]);

         $semester2 = Semester::create([
            'academic_year' => '2022-2023',
            'semester' => '2nd',
            'start_date' => Carbon::parse('2023-01-10'),
            'end_date' => Carbon::parse('2023-05-15'),
            'status' => 'active',
        ]);

        $semester3 = Semester::create([
            'academic_year' => '2023-2024',
            'semester' => '1st',
            'start_date' => Carbon::parse('2023-08-01'),
            'end_date' => Carbon::parse('2023-12-15'),
            'status' => 'upcoming',
        ]);



        // Fetch Teachers
        $teacher1 = Teacher::find(1);
        $teacher2 = Teacher::find(2);
        $teacher3 = Teacher::find(3);
        $teacher4 = Teacher::find(4);
        $teacher5 = Teacher::find(5);
        $teacher6 = Teacher::find(6);
        $teacher7 = Teacher::find(7);
        $teacher8 = Teacher::find(8);
        $teacher9 = Teacher::find(9);


        // Step 4: Create Subjects

        $nurserySubjects = [
            [
                'name' => 'Early Literacy and Language',
                'code' => 'NUR-ELL',
                'grade_level' => 'nursery',
                'fee' => 0,
                'units' => 0,
                'room' => 'Room 1',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher1->id,
                'days' => json_encode(['Monday', 'Wednesday']),
                'start_time' => '08:00',
                'end_time' => '09:00',
            ],
            [
                'name' => 'Early Numeracy and Math Readiness',
                'code' => 'NUR-ENM',
                'grade_level' => 'nursery',
                'fee' => 0,
                'units' => 0,
                'room' => 'Room 1',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher2->id,
                'days' => json_encode(['Monday', 'Wednesday']),
                'start_time' => '09:15',
                'end_time' => '10:15',
            ],
            [
                'name' => 'Creative Play and Arts',
                'code' => 'NUR-CPA',
                'grade_level' => 'nursery',
                'fee' => 0,
                'units' => 0,
                'room' => 'Room 1',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher3->id,
                'days' => json_encode(['Tuesday', 'Thursday']),
                'start_time' => '08:00',
                'end_time' => '09:00',
            ],
            [
                'name' => 'Music, Movement and PE',
                'code' => 'NUR-MMP',
                'grade_level' => 'nursery',
                'fee' => 0,
                'units' => 0,
                'room' => 'Room 1',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher4->id,
                'days' => json_encode(['Tuesday', 'Thursday']),
                'start_time' => '09:15',
                'end_time' => '10:15',
            ],
            [
                'name' => 'Values Formation / Good Manners',
                'code' => 'NUR-VF',
                'grade_level' => 'nursery',
                'fee' => 0,
                'units' => 0,
                'room' => 'Room 1',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher5->id,
                'days' => json_encode(['Friday']),
                'start_time' => '08:00',
                'end_time' => '09:30',
            ],
        ];

        // Create nursery subjects
        foreach ($nurserySubjects as $subject) {
            Subject::create($subject);
        }

        $preKinderSubjects = [
            [
                'name' => 'Language and Pre-Reading Skills',
                'code' => 'PK-LPR',
                'grade_level' => 'kinder', // enum value
                'fee' => 0,
                'units' => 0,
                'room' => 'Room 2',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher1->id,
                'days' => json_encode(['Monday', 'Wednesday']),
                'start_time' => '08:00',
                'end_time' => '09:00',
            ],
            [
                'name' => 'Numbers and Pre-Math Skills',
                'code' => 'PK-NPM',
                'grade_level' => 'kinder',
                'fee' => 0,
                'units' => 0,
                'room' => 'Room 2',
                'semester_id' =>  $semester2->id,
                'teacher_id' => $teacher2->id,
                'days' => json_encode(['Monday', 'Wednesday']),
                'start_time' => '09:15',
                'end_time' => '10:15',
            ],
            [
                'name' => 'Creative Arts and Play',
                'code' => 'PK-CAP',
                'grade_level' => 'kinder',
                'fee' => 0,
                'units' => 0,
                'room' => 'Room 2',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher3->id,
                'days' => json_encode(['Tuesday', 'Thursday']),
                'start_time' => '08:00',
                'end_time' => '09:00',
            ],
            [
                'name' => 'Music, Movement and Gross Motor Skills',
                'code' => 'PK-MMG',
                'grade_level' => 'kinder',
                'fee' => 0,
                'units' => 0,
                'room' => 'Room 2',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher4->id,
                'days' => json_encode(['Tuesday', 'Thursday']),
                'start_time' => '09:15',
                'end_time' => '10:15',
            ],
            [
                'name' => 'Values Formation / Good Manners',
                'code' => 'PK-VF',
                'grade_level' => 'kinder',
                'fee' => 0,
                'units' => 0,
                'room' => 'Room 2',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher5->id,
                'days' => json_encode(['Friday']),
                'start_time' => '08:00',
                'end_time' => '09:30',
            ],
        ];

        // Create Pre-Kinder subjects
        foreach ($preKinderSubjects as $subject) {
            Subject::create($subject);
        }

        $grade1Subjects = [
            [
                'name' => 'Mother Tongue',
                'code' => 'G1-MT',
                'grade_level' => 'grade_1', // enum value
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade1-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher1->id,
                'days' => json_encode(['Monday', 'Wednesday']),
                'start_time' => '08:00',
                'end_time' => '09:00',
            ],
            [
                'name' => 'Filipino',
                'code' => 'G1-FIL',
                'grade_level' => 'grade_1',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade1-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher2->id,
                'days' => json_encode(['Monday', 'Wednesday']),
                'start_time' => '09:15',
                'end_time' => '10:15',
            ],
            [
                'name' => 'English',
                'code' => 'G1-ENG',
                'grade_level' => 'grade_1',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade1-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher3->id,
                'days' => json_encode(['Tuesday', 'Thursday']),
                'start_time' => '08:00',
                'end_time' => '09:00',
            ],
            [
                'name' => 'Mathematics',
                'code' => 'G1-MATH',
                'grade_level' => 'grade_1',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade1-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher4->id,
                'days' => json_encode(['Tuesday', 'Thursday']),
                'start_time' => '09:15',
                'end_time' => '10:15',
            ],
            [
                'name' => 'Araling Panlipunan',
                'code' => 'G1-AP',
                'grade_level' => 'grade_1',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade1-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher5->id,
                'days' => json_encode(['Wednesday', 'Friday']),
                'start_time' => '10:30',
                'end_time' => '11:15',
            ],
            [
                'name' => 'Edukasyon sa Pagpapakatao (EsP)',
                'code' => 'G1-ESP',
                'grade_level' => 'grade_1',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade1-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher6->id,
                'days' => json_encode(['Friday']),
                'start_time' => '11:30',
                'end_time' => '12:00',
            ],
            [
                'name' => 'Music, Arts, PE, and Health (MAPEH)',
                'code' => 'G1-MAPEH',
                'grade_level' => 'grade_1',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade1-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher7->id,
                'days' => json_encode(['Monday', 'Wednesday']),
                'start_time' => '13:00',
                'end_time' => '14:00',
            ],
        ];

        foreach ($grade1Subjects as $subject) {
            Subject::create($subject);
        }


        $grade2Subjects = [
            [
                'name' => 'Mother Tongue',
                'code' => 'G2-MT',
                'grade_level' => 'grade_2', // enum value
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade2-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher1->id,
                'days' => json_encode(['Monday', 'Wednesday']),
                'start_time' => '08:00',
                'end_time' => '09:00',
            ],
            [
                'name' => 'Filipino',
                'code' => 'G2-FIL',
                'grade_level' => 'grade_2',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade2-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher2->id,
                'days' => json_encode(['Monday', 'Wednesday']),
                'start_time' => '09:15',
                'end_time' => '10:15',
            ],
            [
                'name' => 'English',
                'code' => 'G2-ENG',
                'grade_level' => 'grade_2',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade2-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher3->id,
                'days' => json_encode(['Tuesday', 'Thursday']),
                'start_time' => '08:00',
                'end_time' => '09:00',
            ],
            [
                'name' => 'Mathematics',
                'code' => 'G2-MATH',
                'grade_level' => 'grade_2',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade2-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher4->id,
                'days' => json_encode(['Tuesday', 'Thursday']),
                'start_time' => '09:15',
                'end_time' => '10:15',
            ],
            [
                'name' => 'Araling Panlipunan',
                'code' => 'G2-AP',
                'grade_level' => 'grade_2',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade2-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher5->id,
                'days' => json_encode(['Wednesday', 'Friday']),
                'start_time' => '10:30',
                'end_time' => '11:15',
            ],
            [
                'name' => 'Edukasyon sa Pagpapakatao (EsP)',
                'code' => 'G2-ESP',
                'grade_level' => 'grade_2',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade2-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher6->id,
                'days' => json_encode(['Friday']),
                'start_time' => '11:30',
                'end_time' => '12:00',
            ],
            [
                'name' => 'Music, Arts, PE, and Health (MAPEH)',
                'code' => 'G2-MAPEH',
                'grade_level' => 'grade_2',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade2-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher7->id,
                'days' => json_encode(['Monday', 'Wednesday']),
                'start_time' => '13:00',
                'end_time' => '14:00',
            ],
        ];

        foreach ($grade2Subjects as $subject) {
            Subject::create($subject);
        }

        // Grade 3 subjects
        $grade3Subjects = [
            [
                'name' => 'Mother Tongue',
                'code' => 'G3-MT',
                'grade_level' => 'grade_3', // enum value
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade3-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher1->id,
                'days' => json_encode(['Monday', 'Wednesday']),
                'start_time' => '08:00',
                'end_time' => '09:00',
            ],
            [
                'name' => 'Filipino',
                'code' => 'G3-FIL',
                'grade_level' => 'grade_3',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade3-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher2->id,
                'days' => json_encode(['Monday', 'Wednesday']),
                'start_time' => '09:15',
                'end_time' => '10:15',
            ],
            [
                'name' => 'English',
                'code' => 'G3-ENG',
                'grade_level' => 'grade_3',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade3-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher3->id,
                'days' => json_encode(['Tuesday', 'Thursday']),
                'start_time' => '08:00',
                'end_time' => '09:00',
            ],
            [
                'name' => 'Mathematics',
                'code' => 'G3-MATH',
                'grade_level' => 'grade_3',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade3-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher4->id,
                'days' => json_encode(['Tuesday', 'Thursday']),
                'start_time' => '09:15',
                'end_time' => '10:15',
            ],
            [
                'name' => 'Araling Panlipunan',
                'code' => 'G3-AP',
                'grade_level' => 'grade_3',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade3-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher5->id,
                'days' => json_encode(['Wednesday', 'Friday']),
                'start_time' => '10:30',
                'end_time' => '11:15',
            ],
            [
                'name' => 'Edukasyon sa Pagpapakatao (EsP)',
                'code' => 'G3-ESP',
                'grade_level' => 'grade_3',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade3-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher6->id,
                'days' => json_encode(['Friday']),
                'start_time' => '11:30',
                'end_time' => '12:00',
            ],
            [
                'name' => 'Music, Arts, PE, and Health (MAPEH)',
                'code' => 'G3-MAPEH',
                'grade_level' => 'grade_3',
                'fee' => 0,
                'units' => 0,
                'room' => 'Grade3-Room',
                'semester_id' =>   $semester2->id,
                'teacher_id' => $teacher7->id,
                'days' => json_encode(['Monday', 'Wednesday']),
                'start_time' => '13:00',
                'end_time' => '14:00',
            ],
        ];

        foreach ($grade3Subjects as $subject) {
            Subject::create($subject);
        }


        // Helper function for subjects
        function getSubjects($gradeLevel, $semesterId)
        {
            return Subject::where('grade_level', $gradeLevel)
                ->where('semester_id', $semesterId)
                ->pluck('id')
                ->toArray();
        }

        // Students
        $student1 = Student::find(1);
        $student2 = Student::find(2);

        // Ensure semester exists
        $semester = Semester::find(1);

        if (!$semester) {
            $this->command->error("Semester not found.");
            return;
        }

        // Enroll Students
        if ($student1) {
            $subjects = getSubjects('grade_1', $semester->id);
            $this->enrollStudent($student1, 'grade_1', $semester->id, $subjects);
        }

        if ($student2) {
            $subjects = getSubjects('grade_2', $semester->id);
            $this->enrollStudent($student2, 'grade_2', $semester->id, $subjects);
        }

        $this->command->info('Students enrolled successfully!');
    }


    private function enrollStudent($student, $gradeLevel, $semesterId, $subjectIds)
    {
        // Step 1: Create enrollment (no course_id)
        $enrollment = Enrollment::updateOrCreate(
            [
                'student_id'  => $student->id,
                'grade_level' => $gradeLevel,
                'semester_id' => $semesterId,
                'category'    => 'new',
            ],
            ['subject_ids' => json_encode($subjectIds)]
        );

        // Step 2: Update student's status
        $student->status = 'enrolled';
        $student->save();

        // Step 3: Assign subjects to Student
        foreach ($subjectIds as $subjectId) {
            StudentSubject::updateOrCreate([
                'student_id'    => $student->id,
                'subject_id'    => $subjectId,
                'enrollment_id' => $enrollment->id,
            ], [
                'status' => 'enrolled',
                'grade'  => null,
            ]);
        }

        // Step 4: Fees & Payments (your existing logic unchanged)
        $tuitionFee      = 5000.00;
        $labFee          = 500.00;
        $miscellaneousFee = 300.00;
        $otherFee        = 200.00;
        $discount        = 100.00;
        $initialPayment  = 1000.00;

        $totalFee = $tuitionFee + $labFee + $miscellaneousFee + $otherFee - $discount - $initialPayment;

        $fee = Fee::create([
            'enrollment_id'    => $enrollment->id,
            'tuition_fee'      => $tuitionFee,
            'lab_fee'          => $labFee,
            'miscellaneous_fee' => $miscellaneousFee,
            'other_fee'        => $otherFee,
            'discount'         => $discount,
            'initial_payment'  => $initialPayment,
        ]);

        $installmentAmount = $totalFee > 0 ? $totalFee / 4 : 0;

        Payment::create([
            'fee_id'            => $fee->id,
            'prelims_payment'   => $installmentAmount,
            'prelims_paid'      => false,
            'midterms_payment'  => $installmentAmount,
            'midterms_paid'     => false,
            'pre_final_payment' => $installmentAmount,
            'pre_final_paid'    => false,
            'final_payment'     => $installmentAmount,
            'final_paid'        => false,
            'status'            => 'Pending',
        ]);

        $dummyFinancialData = [
            'financier'               => 'Myself',
            'company_name'            => 'ABC Corp',
            'company_address'         => '123 Street, City, Country',
            'income'                  => 35000,
            'scholarship'             => 5000,
            'contact_number'          => '123-456-7890',
            'relative_names'          => ['John Doe', 'Jane Smith'],
            'relationships'           => ['Father', 'Mother'],
            'position_courses'        => ['Manager', 'Engineer'],
            'relative_contact_numbers' => ['987-654-3210', '555-123-4567'],
        ];

        $financialData = array_merge($dummyFinancialData, [
            'enrollment_id'           => $enrollment->id,
            'relative_names'          => json_encode($dummyFinancialData['relative_names']),
            'relationships'           => json_encode($dummyFinancialData['relationships']),
            'position_courses'        => json_encode($dummyFinancialData['position_courses']),
            'relative_contact_numbers' => json_encode($dummyFinancialData['relative_contact_numbers']),
        ]);

        FinancialInformation::create($financialData);
    }
}
