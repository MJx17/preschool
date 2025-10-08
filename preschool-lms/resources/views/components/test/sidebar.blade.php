<div id="sidebar"
    class="bg-white shadow-lg transition-all duration-300
            w-64 lg:relative lg:translate-x-0 lg:flex-shrink-0
            fixed inset-y-0 left-0 transform -translate-x-full lg:transform-none z-50 overflow-hidden">

    <!-- Header -->
    <div class="p-4 border-b flex justify-between items-center">
        <h1 class="font-bold">{{ config('app.name', 'LMS') }}</h1>
        <button class="lg:hidden text-gray-600" onclick="toggleSidebar()">✖</button>

        <!-- <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="w-6 h6 border rounded-full"> -->



    </div>

    <!-- Navigation -->
    <nav class="mt-4 space-y-2">

        <!-- Dashboard (for all logged-in users) -->

        <!-- Student links -->
        @if(auth()->check() && auth()->user()->hasRole('student'))
        <a href="{{ route('student.create') }}" class="block px-4 py-2 hover:bg-gray-200">Details</a>

        @if(auth()->user()->student)
        <a href="{{ route('student_subject.subjects', auth()->user()->student->id) }}"
            class="block px-4 py-2 hover:bg-gray-200">Subjects</a>

        @if(auth()->user()->student->enrollment)
        <a href="{{ route('enrollments.fees', auth()->user()->student->enrollment->id) }}"
            class="block px-4 py-2 hover:bg-gray-200">Enrollment</a>
        @endif
        @endif
        @endif


        <!-- Admin links -->
        @if(auth()->user()?->hasRole('admin'))
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-200">Dashboard</a>
        <a href="{{ route('users.index') }}" class="block px-4 py-2 hover:bg-gray-200">Users</a>
        <a href="{{ route('subjects.index') }}" class="block px-4 py-2 hover:bg-gray-200">Subjects</a>
        <a href="{{ route('enrollments.index') }}" class="block px-4 py-2 hover:bg-gray-200">Enrollment</a>
        <a href="{{ route('student.indexAdmin') }}" class="block px-4 py-2 hover:bg-gray-200">Student List</a>
        <a href="{{ route('departments.index') }}" class="block px-4 py-2 hover:bg-gray-200">Departments</a>
        <a href="{{ route('lessons.index') }}" class="block px-4 py-2 hover:bg-gray-200">Lessons</a>
        <a href="{{ route('homeworks.index') }}" class="block px-4 py-2 hover:bg-gray-200">Homeworks</a>
        <a href="{{ route('quizzes.index') }}" class="block px-4 py-2 hover:bg-gray-200">Quizzes</a>
         <a href="{{ route('semesters.index') }}" class="block px-4 py-2 hover:bg-gray-200">Semesters</a>
         <a href="{{ route('subject_assignment.index') }}" class="block px-4 py-2 hover:bg-gray-200">Subject Assignment</a>
        @endif

        <!-- Professor links -->
        @if(auth()->user()?->hasRole('professor'))
        <a href="{{ route('professors.subjects', auth()->user()->professor->id) }}"
            class="block px-4 py-2 hover:bg-gray-200">Subjects</a>
        <a href="{{ route('professors.show', auth()->user()->professor->id) }}"
            class="block px-4 py-2 hover:bg-gray-200">Assessment</a>
        <a href="{{ route('professors.profile', auth()->user()->professor->id) }}"
            class="block px-4 py-2 hover:bg-gray-200">Details</a>
        @endif

    </nav>
</div>