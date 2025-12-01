<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController; // make sure this is imported
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\SubjectPdfController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Auth\RegisteredTeacherUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TeacherGradingController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SubjectOfferingController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GradeLevelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/attendance', function () {
    return view('attendance');
})->name('attendance'); // 


// ✅ FIXED: dashboard route wrapped properly with middleware
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('lessons', LessonController::class);
Route::resource('homeworks', HomeworkController::class);
Route::resource('quizzes', QuizController::class);
Route::resource('questions', QuestionController::class);

Route::get('/contact', [ContactController::class, 'showForm']);
Route::post('/contact', [ContactController::class, 'sendEmail'])->name('contact.send');








Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    // Route to display the form
    Route::get('/admin/register-teacher', [RegisteredTeacherUserController::class, 'create'])
        ->name('register_teacher');

    // Handle teacher registration form submission
    Route::post('/admin/register-teacher', [RegisteredTeacherUserController::class, 'store']);
    Route::resource('grade-levels', GradeLevelController::class);
    Route::resource('sections', SectionController::class);
    Route::get('/sections/by-grade/{grade}', [SectionController::class, 'byGrade']);
});



Route::middleware(['auth', 'verified', 'role:admin|student'])->group(function () {
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student-info', [StudentController::class, 'indexStudent'])->name('student.indexStudent');

    Route::get('/enrollments/{id}/details', [EnrollmentController::class, 'fees'])->name('enrollments.fees');
});




Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/student-list', [StudentController::class, 'indexAdmin'])->name('student.indexAdmin');

    Route::get('/users-list', [UserController::class, 'index'])->name('users.index');
    // Edit student data
    Route::get('student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');

    // Update student data
    Route::put('student/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::get('/student/view/{id}', [StudentController::class, 'show'])->name('student.show');

    // Delete student data
    Route::delete('student/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
});

// Roles
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});


// Permissions
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'Edit'])->name('permissions.edit');
    Route::patch('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::resource('enrollments', EnrollmentController::class);

    Route::resource('fees', FeeController::class);

    Route::resource('semesters', SemesterController::class);

    Route::resource('payment', PaymentController::class);

    Route::resource('subjects', SubjectController::class)->parameters([
        'subjects' => 'id', // Use 'id' instead of 'subjects_id'
    ]);
    Route::resource('departments', DepartmentController::class)->parameters([
        'departments' => 'department_id',
    ]);

    Route::resource('teachers', TeacherController::class)
        ->parameters(['teacher' => 'teacher_id'])
        ->except(['show']); // Exclude 'show' because it's restricted to teachers only



    Route::get('subject_assignment', [SubjectOfferingController::class, 'index'])
        ->name('subject_assignment.index');

    Route::get('subject_assignment/create', [SubjectOfferingController::class, 'create'])
        ->name('subject_assignment.create');

    Route::post('subject_assignment/store', [SubjectOfferingController::class, 'store'])
        ->name('subject_assignment.store');

    Route::get('subject_assignment/{id}/edit', [SubjectOfferingController::class, 'edit'])
        ->name('subject_assignment.edit');

    Route::post('subject_assignment/{id}/update', [SubjectOfferingController::class, 'update'])
        ->name('subject_assignment.update');

    Route::delete('subject_assignment/{id}/delete', [SubjectOfferingController::class, 'destroy'])
        ->name('subject_assignment.destroy');
});


Route::middleware(['auth', 'verified', 'role:teacher|admin'])->group(function () {
    Route::get('teachers/{teacher_id}', [TeacherController::class, 'show'])
        ->name('teachers.show');

    Route::get('teachers/{teacher_id}/subjects', [TeacherController::class, 'subjects'])
        ->name('teachers.subjects');

    Route::get('/teachers/{teacher}/profile', [TeacherController::class, 'profile'])
        ->name('teachers.profile');
    Route::get('teacher/subjects/{subjectId}/students', [TeacherGradingController::class, 'showStudentsForGrading'])->name('teachers.grade_students');
    Route::put('teacher/subjects/{subjectId}/grades', [TeacherGradingController::class, 'updateGrades'])->name('teacher.updateGrades');
});



Route::get('/get-subjects', [EnrollmentController::class, 'getSubjects'])->name('get.subjects');
Route::get('/teacher-list', [TeacherController::class, 'getTeachers']);


Route::prefix('attendance')
    ->middleware(['auth', 'verified', 'role:teacher|admin'])
    ->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])
            ->name('attendance.index');

        Route::get('/teacher/subjects', [AttendanceController::class, 'teacherSubjects'])
            ->name('attendance.teacherSubjects');

        Route::get('{subjectOffering}/create', [AttendanceController::class, 'create'])
            ->name('attendance.create');

        Route::post('{subjectOffering}', [AttendanceController::class, 'store'])
            ->name('attendance.store');
    });



// Route to show the subjects in a view (no download yet)
Route::get('/subjects-pdf', [SubjectPdfController::class, 'showSubjectsPDF'])->name('subjects-pdf');

// Update the route to accept studentId as a parameter
Route::get('/download-subjects-pdf/{studentId}', [SubjectPdfController::class, 'downloadSubjectsPDF'])->name('download-subjects-pdf');
// Route::get('/fees-pdf/{studentId}', [SubjectPdfController::class, 'fees'])->name('fees-pdf');


Route::get('/fees-pdf/{id}', [SubjectPdfController::class, 'fees'])->name('pdf.fees');
Route::get('/fees-financial/{id}', [SubjectPdfController::class, 'financialInformation'])->name('pdf.financial');
Route::get('/fees-permit/{id}', [SubjectPdfController::class, 'permit'])->name('pdf.permit');

Route::get('/financial-letter', function () {
    return view('pdf.financial'); // Display the Blade template
});





require __DIR__ . '/auth.php';
