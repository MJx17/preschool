<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Grade Students for ' . $subjectOffering->subject->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-medium mb-4">{{ $subjectOffering->subject->name }}</h3>

                    @if($subjectOffering->enrollmentSubjectOfferings->isEmpty())
                        <p>No students are enrolled in this subject offering.</p>
                    @else
                        <form action="{{ route('teacher.updateGrades', $subjectOffering->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-200">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Student ID</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Student Name</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">1st Grading</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">2nd Grading</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">3rd Grading</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">4th Grading</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Final Grade</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Remarks</th>
                                        </tr>
                                    </thead>

                                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200">
                                        @foreach($subjectOffering->enrollmentSubjectOfferings as $record)
                                            <tr class="hover:bg-gray-100">
                                                <td class="px-4 py-2 text-sm">{{ $record->enrollment->student->id }}</td>
                                                <td class="px-4 py-2 text-sm">{{ $record->enrollment->student->fullname }}</td>

                                                @foreach(['first_grading','second_grading','third_grading','fourth_grading','final_grade'] as $field)
                                                    <td class="px-2 py-1">
                                                        <input type="number"
                                                               name="grades[{{ $record->id }}][{{ $field }}]"
                                                               value="{{ old('grades.' . $record->id . '.' . $field, optional($record->grade)->$field) }}"
                                                               class="border p-1 w-16 text-center"
                                                               min="0" max="100">
                                                    </td>
                                                @endforeach

                                                <td class="px-2 py-1">
                                                    <input type="text"
                                                           name="grades[{{ $record->id }}][remarks]"
                                                           value="{{ old('grades.' . $record->id . '.remarks', optional($record->grade)->remarks) }}"
                                                           class="border p-1 w-full text-sm">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 flex justify-end gap-2">
                                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg">Save Grades</button>
                                <a href="javascript:history.back()"
                                   class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                                   Cancel
                                </a>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
