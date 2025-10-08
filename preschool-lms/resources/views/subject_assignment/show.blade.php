<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Subject Assignment Details
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-6 sm:px-8 lg:px-10">
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg p-8 space-y-6">

            <h3 class="text-lg font-semibold text-blue-800 dark:text-white">General Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 dark:text-gray-300 font-medium">Subject:</p>
                    <p class="text-gray-800 dark:text-gray-100">{{ $subjectAssignment->subject->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-300 font-medium">Semester:</p>
                    <p class="text-gray-800 dark:text-gray-100">{{ $subjectAssignment->semester->semester }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-300 font-medium">Teacher:</p>
                    <p class="text-gray-800 dark:text-gray-100">{{ $subjectAssignment->teacher->user->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-300 font-medium">Block:</p>
                    <p class="text-gray-800 dark:text-gray-100">{{ $subjectAssignment->block }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-300 font-medium">Room:</p>
                    <p class="text-gray-800 dark:text-gray-100">{{ $subjectAssignment->room }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-300 font-medium">Days:</p>
                    <p class="text-gray-800 dark:text-gray-100">{{ $subjectAssignment->formatted_days }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-300 font-medium">Time:</p>
                    <p class="text-gray-800 dark:text-gray-100">{{ $subjectAssignment->class_time }}</p>
                </div>
            </div>

            <div class="flex justify-end mt-6 space-x-4">
                <a href="{{ route('subject-assignment.edit', $subjectAssignment->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300">
                   Edit
                </a>
                <form action="{{ route('subject-assignment.destroy', $subjectAssignment->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this assignment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300">
                        Delete
                    </button>
                </form>
                <a href="{{ route('subject-assignment.index') }}"
                   class="bg-gray-400 hover:bg-gray-500 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300">
                   Back to List
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
