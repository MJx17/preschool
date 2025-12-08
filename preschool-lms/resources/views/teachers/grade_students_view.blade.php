<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Grades for ' . $subjectOffering->subject->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-medium mb-4">
                        {{ $subjectOffering->subject->name }}
                    </h3>

                    @if($subjectOffering->enrollmentSubjectOfferings->isEmpty())
                        
                        <p>No students are enrolled in this subject offering.</p>

                    @else
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

                                            <!-- Student ID -->
                                            <td class="px-4 py-2 text-sm">
                                                {{ $record->enrollment->student->id }}
                                            </td>

                                            <!-- Student Name -->
                                            <td class="px-4 py-2 text-sm">
                                                {{ $record->enrollment->student->fullname }}
                                            </td>

                                            <!-- Grades -->
                                            <td class="px-2 py-1 text-center">
                                                {{ $record->grade?->first_grading ?? '-' }}
                                            </td>
                                            <td class="px-2 py-1 text-center">
                                                {{ $record->grade?->second_grading ?? '-' }}
                                            </td>
                                            <td class="px-2 py-1 text-center">
                                                {{ $record->grade?->third_grading ?? '-' }}
                                            </td>
                                            <td class="px-2 py-1 text-center">
                                                {{ $record->grade?->fourth_grading ?? '-' }}
                                            </td>
                                            <td class="px-2 py-1 text-center">
                                                {{ $record->grade?->final_grade ?? '-' }}
                                            </td>
                                            <td class="px-2 py-1 text-center">
                                                {{ $record->grade?->remarks ?? '-' }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Back Button -->
                        <div class="mt-4 flex justify-end gap-2">
                            @if(auth()->user()->hasRole('teacher') && optional(auth()->user()->teacher)->id)
                                <a href="{{ route('teachers.show', auth()->user()->teacher->id) }}"
                                   class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                                   Back
                                </a>
                            @endif

                            @if(auth()->user()->hasRole('admin'))
                                <a href="javascript:history.back()"
                                   class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                                   Back
                                </a>
                            @endif
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
