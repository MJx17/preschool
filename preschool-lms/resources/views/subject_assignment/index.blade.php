<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Subject Assignment
        </h2>
    </x-slot>

    <div class="max-w-full mx-auto py-8 sm:px-6 lg:px-8">

        {{-- Filters --}}
        <form method="GET" class="flex flex-wrap gap-4 mb-4 items-center">
            {{-- Teacher Filter --}}
            <select name="teacher_id" class="border rounded p-2">
                <option value="">All Teachers</option>
                @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->user->name ?? 'N/A' }}
                </option>
                @endforeach
            </select>

            {{-- Section Filter --}}
            <select name="section" class="border rounded p-2">
                <option value="">All Sections</option>
                @foreach($sections as $section)
                <option value="{{ $section->name }}" {{ request('section') == $section->name ? 'selected' : '' }}>
                    {{ $section->name }}
                </option>
                @endforeach
            </select>

            {{-- Semester Filter --}}
            <select name="semester_id" class="border rounded p-2">
                <option value="">All Semesters</option>
                @foreach($semesters as $sem)
                <option value="{{ $sem->id }}" {{ request('semester_id') == $sem->id ? 'selected' : '' }}>
                    {{ $sem->semester }}
                </option>
                @endforeach
            </select>

            {{-- Submit --}}
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
        </form>

        <div class="flex justify-end mb-4">
            <a href="{{ route('subject_assignment.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                Add New Schedule
            </a>
        </div>

        @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-900 shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Teacher</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Section</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Grade Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Room</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Days</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($subjectAssignments as $assignment)
                    <tr>
                        <td class="px-6 py-4">{{ $assignment->subject->code }}</td>
                        <td class="p-2 ">
                            <span @class([ 'font-semibold px-2 py-1 rounded' , 'bg-green-100 text-green-800'=> $assignment->semester->status === 'active',
                                'bg-yellow-100 text-yellow-800' => $assignment->semester->status === 'upcoming',
                                'bg-red-100 text-red-800' => $assignment->semester->status === 'closed',
                                ])>
                                {{ $assignment->semester->semester }}
                            </span>
                        </td>

                        <td class="px-6 py-4">{{ $assignment->teacher->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $assignment->section->name ?? '-' }}</td>
                        <td class="px-6 py-4">{{ optional($assignment->subject->gradeLevel)->name ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $assignment->room }}</td>
                        <td class="px-6 py-4">{{ $assignment->formatted_days ?: '-' }}</td>
                        <td class="px-6 py-4">{{ $assignment->class_time }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('subject_assignment.edit', $assignment) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('subject_assignment.destroy', $assignment) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">No assignments found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>