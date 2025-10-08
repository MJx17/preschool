<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Semester;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SubjectOffering;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\EnrollmentSubjectOffering;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\FinancialInformation;
use Carbon\Carbon;

class DepartmentCourseSubjectSemesterSeeder extends Seeder
{
    public function run(): void
    {
        /** -----------------------------
         * 1. Departments
         * ----------------------------- */
        $departments = [
            'Mathematics','Science','English','Filipino',
            'Araling Panlipunan','MAPEH','TLE','Values Education'
        ];
        foreach ($departments as $name) {
            Department::firstOrCreate(['name' => $name]);
        }

        /** -----------------------------
         * 2. Semesters
         * ----------------------------- */
        Semester::updateOrCreate(
            ['semester' => '1st Semester 2024-2025'],
            [
                'start_date' => Carbon::parse('2024-08-01')->toDateString(),
                'end_date'   => Carbon::parse('2024-12-15')->toDateString(),
                'status'     => 'closed',
            ]
        );
        
        // Active
        Semester::updateOrCreate(
            ['semester' => '1st Semester 2025-2026'],
            [
                'start_date' => Carbon::parse('2025-08-01')->toDateString(),
                'end_date'   => Carbon::parse('2025-12-15')->toDateString(),
                'status'     => 'active',
            ]
        );
        
        // Upcoming
        Semester::updateOrCreate(
            ['semester' => '1st Semester 2026-2027'],
            [
                'start_date' => Carbon::parse('2026-08-01')->toDateString(),
                'end_date'   => Carbon::parse('2026-12-15')->toDateString(),
                'status'     => 'upcoming',
            ]
        );

        $activeSemester = Semester::where('status','active')->first();

        /** -----------------------------
         * 3. Subjects
         * ----------------------------- */
        $subjects = [
            ['name'=>'Early Literacy and Language','code'=>'NUR-ELL','grade_level'=>'nursery','fee'=>0,'units'=>0],
            ['name'=>'Early Numeracy and Math Readiness','code'=>'NUR-ENM','grade_level'=>'nursery','fee'=>0,'units'=>0],
            ['name'=>'Reading Readiness','code'=>'KIN-RR','grade_level'=>'kinder','fee'=>0,'units'=>0],
            ['name'=>'Values Formation / Good Manners','code'=>'KIN-VF','grade_level'=>'kinder','fee'=>0,'units'=>0],
            ['name'=>'Mother Tongue','code'=>'G1-MT','grade_level'=>'grade_1','fee'=>0,'units'=>0],
            ['name'=>'Mathematics 1','code'=>'G1-MATH','grade_level'=>'grade_1','fee'=>0,'units'=>0],
            ['name'=>'Mother Tongue','code'=>'G2-MT','grade_level'=>'grade_2','fee'=>0,'units'=>0],
            ['name'=>'Music, Arts, PE, and Health','code'=>'G2-MAPEH','grade_level'=>'grade_2','fee'=>0,'units'=>0],
            ['name'=>'Mother Tongue','code'=>'G3-MT','grade_level'=>'grade_3','fee'=>0,'units'=>0],
            ['name'=>'Mathematics 3','code'=>'G3-MATH','grade_level'=>'grade_3','fee'=>0,'units'=>0],
        ];
        foreach ($subjects as $subjectData) {
            Subject::firstOrCreate(['code'=>$subjectData['code']], $subjectData);
        }

        /** -----------------------------
         * 4. Subject Offerings for active semester
         * ----------------------------- */
        $teacher = Teacher::first(); // pick first teacher for demo
        foreach (Subject::all() as $subject) {
            SubjectOffering::firstOrCreate(
                [
                    'subject_id'=>$subject->id,
                    'semester_id'=>$activeSemester->id,
                ],
                [
                    'teacher_id'=>$teacher?->id,
                    'block'=>'A',
                    'room'=>'101',
                    'days'=>json_encode(['Monday','Wednesday']),
                    'start_time'=>'08:00:00',
                    'end_time'=>'09:00:00',
                ]
            );
        }

        /** -----------------------------
         * 5. Enroll students
         * ----------------------------- */
        $student1 = Student::find(1);
        $student2 = Student::find(2);

        if ($student1) {
            $ids = $this->getSubjectOfferings('grade_1', $activeSemester->id);
            $this->enrollStudent($student1, 'grade_1', $activeSemester->id, $ids);
        }
        if ($student2) {
            $ids = $this->getSubjectOfferings('grade_2', $activeSemester->id);
            $this->enrollStudent($student2, 'grade_2', $activeSemester->id, $ids);
        }

        $this->command->info('Departments, subjects, offerings & student enrollments seeded!');
    }

    private function getSubjectOfferings($gradeLevel, $semesterId): array
    {
        return SubjectOffering::where('semester_id',$semesterId)
            ->whereHas('subject', fn($q)=>$q->where('grade_level',$gradeLevel))
            ->pluck('id')
            ->toArray();
    }

    private function enrollStudent($student,$gradeLevel,$semesterId,$subjectOfferingIds): void
    {
        // enrollment
        $enrollment = Enrollment::updateOrCreate([
            'student_id'=>$student->id,
            'grade_level'=>$gradeLevel,
            'semester_id'=>$semesterId,
            'category'=>'new',
        ]);

        $student->status='enrolled';
        $student->save();

        // pivot offerings
        foreach ($subjectOfferingIds as $offeringId) {
            EnrollmentSubjectOffering::updateOrCreate(
                [
                    'enrollment_id'=>$enrollment->id,
                    'subject_offering_id'=>$offeringId,
                ],
                ['status'=>'enrolled','grade'=>null]
            );
        }

        // dummy fees/payments
        $tuition=5000; $lab=500; $misc=300; $other=200; $discount=100; $initial=1000;
        $total=$tuition+$lab+$misc+$other-$discount-$initial;

        $fee=Fee::create([
            'enrollment_id'=>$enrollment->id,
            'tuition_fee'=>$tuition,
            'lab_fee'=>$lab,
            'miscellaneous_fee'=>$misc,
            'other_fee'=>$other,
            'discount'=>$discount,
            'initial_payment'=>$initial,
        ]);

        $installment=$total>0?$total/4:0;
        Payment::create([
            'fee_id'=>$fee->id,
            'prelims_payment'=>$installment,
            'prelims_paid'=>false,
            'midterms_payment'=>$installment,
            'midterms_paid'=>false,
            'pre_final_payment'=>$installment,
            'pre_final_paid'=>false,
            'final_payment'=>$installment,
            'final_paid'=>false,
            'status'=>'Pending',
        ]);

        $dummy = [
            'financier'=>'Myself','company_name'=>'ABC Corp','company_address'=>'123 Street',
            'income'=>35000,'scholarship'=>5000,'contact_number'=>'123-456-7890',
            'relative_names'=>['John Doe','Jane Smith'],
            'relationships'=>['Father','Mother'],
            'position_courses'=>['Manager','Engineer'],
            'relative_contact_numbers'=>['987-654-3210','555-123-4567'],
        ];
        FinancialInformation::create([
            'enrollment_id'=>$enrollment->id,
            'financier'=>$dummy['financier'],
            'company_name'=>$dummy['company_name'],
            'company_address'=>$dummy['company_address'],
            'income'=>$dummy['income'],
            'scholarship'=>$dummy['scholarship'],
            'contact_number'=>$dummy['contact_number'],
            'relative_names'=>json_encode($dummy['relative_names']),
            'relationships'=>json_encode($dummy['relationships']),
            'position_courses'=>json_encode($dummy['position_courses']),
            'relative_contact_numbers'=>json_encode($dummy['relative_contact_numbers']),
        ]);
    }
}
