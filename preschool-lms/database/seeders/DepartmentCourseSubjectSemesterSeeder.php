<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    Department,
    Semester,
    Teacher,
    Subject,
    SubjectOffering,
    Student,
    Enrollment,
    EnrollmentSubjectOffering,
    Fee,
    Payment,
    FinancialInformation,
    GradeLevel,
    Section
};
use Carbon\Carbon;

class DepartmentCourseSubjectSemesterSeeder extends Seeder
{
    public function run(): void
    {
        /** -----------------------------
         * 1. Grade Levels & Sections
         * ----------------------------- */
        $gradeLevels = [
            ['name' => 'Nursery', 'code' => 'nursery', 'sections' => ['A', 'B']],
            ['name' => 'Kinder', 'code' => 'kinder', 'sections' => ['A', 'B']],
            ['name' => 'Grade 1', 'code' => 'grade_1', 'sections' => ['A', 'B']],
            ['name' => 'Grade 2', 'code' => 'grade_2', 'sections' => ['A']],
            ['name' => 'Grade 3', 'code' => 'grade_3', 'sections' => ['A']],
        ];

        foreach ($gradeLevels as $level) {
            $gradeLevel = GradeLevel::firstOrCreate(['code' => $level['code']], [
                'name' => $level['name']
            ]);

            // Seed sections
            foreach ($level['sections'] as $sectionName) {
                $gradeLevel->sections()->firstOrCreate(['name' => $sectionName]);
            }
        }

        /** -----------------------------
         * 2. Departments
         * ----------------------------- */
        $departments = [
            'Mathematics',
            'Science',
            'English',
            'Filipino',
            'Araling Panlipunan',
            'MAPEH',
            'TLE',
            'Values Education'
        ];
        foreach ($departments as $name) {
            Department::firstOrCreate(['name' => $name]);
        }

        /** -----------------------------
         * 3. Semesters
         * ----------------------------- */
        $semesters = [
            ['semester' => '1st Semester 2024-2025', 'start' => '2024-08-01', 'end' => '2024-12-15', 'status' => 'closed'],
            ['semester' => '1st Semester 2025-2026', 'start' => '2025-08-01', 'end' => '2025-12-15', 'status' => 'active'],
            ['semester' => '1st Semester 2026-2027', 'start' => '2026-08-01', 'end' => '2026-12-15', 'status' => 'upcoming'],
        ];

        foreach ($semesters as $sem) {
            Semester::updateOrCreate(
                ['semester' => $sem['semester']],
                [
                    'start_date' => Carbon::parse($sem['start'])->toDateString(),
                    'end_date'   => Carbon::parse($sem['end'])->toDateString(),
                    'status'     => $sem['status'],
                ]
            );
        }

        $activeSemester = Semester::where('status', 'active')->first();

        /** -----------------------------
         * 4. Subjects
         * ----------------------------- */
        $subjects = [
            ['name' => 'Early Literacy and Language', 'code' => 'NUR-ELL', 'grade' => 'nursery', 'fee' => 0, 'units' => 3],
            ['name' => 'Early Numeracy and Math Readiness', 'code' => 'NUR-ENM', 'grade' => 'nursery', 'fee' => 0, 'units' => 2],
            ['name' => 'Reading Readiness', 'code' => 'KIN-RR', 'grade' => 'kinder', 'fee' => 0, 'units' => 2],
            ['name' => 'Values Formation / Good Manners', 'code' => 'KIN-VF', 'grade' => 'kinder', 'fee' => 0, 'units' => 3],
            ['name' => 'Mother Tongue', 'code' => 'G1-MT', 'grade' => 'grade_1', 'fee' => 0, 'units' => 1],
            ['name' => 'Mathematics 1', 'code' => 'G1-MATH', 'grade' => 'grade_1', 'fee' => 0, 'units' => 1],
            ['name' => 'Mother Tongue', 'code' => 'G2-MT', 'grade' => 'grade_2', 'fee' => 0, 'units' => 0],
            ['name' => 'Music, Arts, PE, and Health', 'code' => 'G2-MAPEH', 'grade' => 'grade_2', 'fee' => 0, 'units' => 1],
            ['name' => 'Mother Tongue', 'code' => 'G3-MT', 'grade' => 'grade_3', 'fee' => 0, 'units' => 0],
            ['name' => 'Mathematics 3', 'code' => 'G3-MATH', 'grade' => 'grade_3', 'fee' => 0, 'units' => 1],
        ];

        foreach ($subjects as $subjectData) {
            $gradeLevel = GradeLevel::where('code', $subjectData['grade'])->first();
            if (!$gradeLevel) continue;

            $subject = Subject::firstOrCreate(
                ['code' => $subjectData['code']],
                [
                    'name' => $subjectData['name'],
                    'units' => $subjectData['units'],
                    'fee' => $subjectData['fee'],
                    'grade_level_id' => $gradeLevel->id,
                    'prerequisite_id' => null,
                ]
            );
        }

        /** -----------------------------
         * 5. Subject Offerings per Section + Teacher
         * ----------------------------- */

        $teachers = Teacher::all();
        $semesters = Semester::all();

        // 1️⃣ Create or update SubjectOfferings per Section
        foreach (Subject::all() as $subject) {
            $gradeLevel = $subject->gradeLevel;
            if (!$gradeLevel) continue;

            foreach ($gradeLevel->sections as $section) {
                foreach ($semesters as $semester) {
                    $teacher = $teachers->random(); // assign a random teacher

                    // Use updateOrCreate instead of firstOrCreate
                    SubjectOffering::updateOrCreate(
                        [
                            'subject_id' => $subject->id,
                            'semester_id' => $semester->id,
                            'section_id' => $section->id,
                        ],
                        [
                            'teacher_id' => $teacher->id,
                            'start_time' => '08:00:00',
                            'end_time' => '09:00:00',
                            'days' => json_encode(['Monday', 'Wednesday', 'Friday']),
                            'room' => null,
                        ]
                    );
                }
            }
        }

        // 2️⃣ Enroll students and attach SubjectOfferings
        $students = Student::all();
        foreach ($students as $student) {
            $gradeCode = $student->grade_level_code ?? 'grade_1';
            $gradeLevel = GradeLevel::where('code', $gradeCode)->first();
            if (!$gradeLevel) {
                $this->command->warn("No grade level found for student {$student->id}");
                continue;
            }

            // Assign a random section
            $section = $gradeLevel->sections->random();
            $this->command->info("Assigning Student {$student->id} ({$student->first_name}) to Section {$section->name}");

            // Create or update enrollment
            $enrollment = Enrollment::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'semester_id' => $activeSemester->id,
                ],
                [
                    'grade_level_id' => $gradeLevel->id,
                    'section_id' => $section->id,
                    'category' => 'new',
                ]
            );

            $student->update(['status' => 'enrolled']);

            // Get SubjectOfferings for this section & semester
            $subjectOfferingIds = $section->subjectOfferings()
                ->where('semester_id', $activeSemester->id)
                ->pluck('id'); // just IDs

            $this->command->info("SubjectOfferings for section {$section->name}: " . $subjectOfferingIds->implode(', '));

            // Attach via pivot table and replace existing entries to avoid duplicates
            $syncData = $subjectOfferingIds->mapWithKeys(function ($id) {
                return [$id => ['status' => 'enrolled', 'grade' => null]];
            })->toArray();

            $attached = $enrollment->subjectOfferings()->sync($syncData);
            $this->command->info("Enrollment ID {$enrollment->id} synced: Attached = " . implode(', ', $attached['attached']));



            // 3️⃣ Fees & Payments
            $tuition = 5000;
            $lab = 500;
            $misc = 300;
            $other = 200;
            $discount = 100;
            $initialPayment = 1000;

            $fee = Fee::create([
                'enrollment_id' => $enrollment->id,
                'tuition_fee' => $tuition,
                'lab_fee' => $lab,
                'miscellaneous_fee' => $misc,
                'other_fee' => $other,
                'discount' => $discount,
                'initial_payment' => $initialPayment,
            ]);

            $remainingBalance = max(($tuition + $lab + $misc + $other) - $discount - $initialPayment, 0);
            $installment = $remainingBalance > 0 ? $remainingBalance / 4 : 0;

            Payment::create([
                'fee_id' => $fee->id,
                'prelims_payment' => $installment,
                'prelims_paid' => false,
                'midterms_payment' => $installment,
                'midterms_paid' => false,
                'pre_final_payment' => $installment,
                'pre_final_paid' => false,
                'final_payment' => $installment,
                'final_paid' => false,
                'status' => 'Pending',
            ]);

            // 4️⃣ Financial Information (optional)
            FinancialInformation::updateOrCreate(
                ['enrollment_id' => $enrollment->id],
                [
                    'financier' => 'Myself',
                    'company_name' => 'ABC Corp',
                    'company_address' => '123 Street',
                    'income' => 35000,
                    'scholarship' => 5000,
                    'contact_number' => '123-456-7890',
                    'relative_names' => json_encode(['John Doe', 'Jane Smith']),
                    'relationships' => json_encode(['Father', 'Mother']),
                    'position_courses' => json_encode(['Manager', 'Engineer']),
                    'relative_contact_numbers' => json_encode(['987-654-3210', '555-123-4567']),
                ]
            );
        }

        $this->command->info('Seeding completed: Enrollments, SubjectOfferings, Fees & Payments!');
    }
}
