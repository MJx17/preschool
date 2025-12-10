<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Subject Assignments
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Filters --}}
        <form method="GET" class="flex flex-wrap gap-4 mb-4 items-center">
            {{-- Teacher Filter --}}
            <select name="teacher_id" class="border rounded p-2">
                <option value="">All Teachers</option>
                @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->first_name }} {{ $teacher->surname }}
                </option>
                @endforeach
            </select>

            {{-- Section Filter --}}
            <select name="section_id" class="border rounded p-2">
                <option value="">All Sections</option>
                @foreach($sections as $section)
                <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                    {{ $section->name }}
                </option>
                @endforeach
            </select>

            {{-- Semester Filter --}}
            <select name="semester_id" class="border rounded p-2">
                <option value="">All Semesters</option>
                @foreach($semesters as $sem)
                <option value="{{ $sem->id }}" {{ request('semester_id') == $sem->id ? 'selected' : '' }}>
                    {{ $sem->semester }} @if($sem->status === 'active') (Active) @endif
                </option>
                @endforeach
            </select>


            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Filter
            </button>
        </form>

        {{-- Add New Assignment --}}
        <div class="flex justify-end">
            <a href="{{ route('subject_assignment.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                Add New Assignment
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="text-green-600 mb-4">{{ session('success') }}</div>
        @endif

        {{-- Subject Assignments by Grade --}}
        @forelse($subjectAssignments as $gradeId => $sectionsByGrade)
        @php
        $gradeName = optional($sectionsByGrade->first()->first()->subject->gradeLevel)->name ?? 'N/A';
        @endphp

        <div x-data="{ openGrade: true }" class="border rounded-lg shadow-lg overflow-hidden">
            {{-- Grade Header --}}
            <div @click="openGrade = !openGrade" class="bg-gray-100 dark:bg-gray-800 p-4 flex justify-between items-center cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $gradeName }}</h3>
                <span class="text-gray-500 dark:text-gray-400">{{ count($sectionsByGrade) }} sections</span>
            </div>

            {{-- Sections --}}
            <div x-show="openGrade" x-cloak class="p-4 bg-white dark:bg-gray-900 space-y-4">
                @foreach($sectionsByGrade as $sectionId => $assignmentsBySection)
                @php $section = $assignmentsBySection->first()->section; @endphp
                <div x-data="{ openSection: false }" class="border rounded shadow-sm overflow-hidden">
                    {{-- Section Header --}}
                    <div @click="openSection = !openSection" class="bg-gray-50 dark:bg-gray-800 p-3 flex justify-between items-center cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <h4 class="font-semibold text-gray-700 dark:text-gray-100">{{ $section->name ?? '-' }}</h4>
                        <span class="text-gray-500 dark:text-gray-400">{{ $assignmentsBySection->count() }} subjects</span>
                    </div>

                    {{-- Subjects Table --}}
                    <div x-show="openSection" x-cloak class="p-3 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subject</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Semester</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Teacher</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Room</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Days</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Time</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($assignmentsBySection as $assignment)
                                <tr>
                                    <td class="px-4 py-2">{{ $assignment->subject->code ?? $assignment->subject->name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $assignment->semester->semester ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $assignment->teacher ? $assignment->teacher->first_name . ' ' . $assignment->teacher->surname : 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $assignment->room ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $assignment->formatted_days ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $assignment->class_time ?? '-' }}</td>
                                    <td class="px-4 py-2 text-right space-x-2">
                                        <a href="{{ route('subject_assignment.edit', $assignment) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                        <form action="{{ route('subject_assignment.destroy', $assignment) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="text-center text-gray-500 mt-6">No assignments found.</div>
        @endforelse
    </div>
</x-app-layout>