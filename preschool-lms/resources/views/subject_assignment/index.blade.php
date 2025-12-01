<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Subject Assignment
        </h2>
    </x-slot>

    <div class="max-w-full mx-auto py-8 sm:px-6 lg:px-8">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Block</th>
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
                        <td class="px-6 py-4">{{ $assignment->semester->semester }}</td>
                        <td class="px-6 py-4">{{ $assignment->teacher->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $assignment->block }}</td>
                        <td class="px-6 py-4">{{ $assignment->room }}</td>
                        <td class="px-6 py-4">
                            {{ $assignment->formatted_days ?: '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $assignment->class_time }}
                        </td>
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