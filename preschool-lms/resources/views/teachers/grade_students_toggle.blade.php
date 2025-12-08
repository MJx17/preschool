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

                    <div x-data="{ editMode: false }" class="space-y-4">

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">{{ $subjectOffering->subject->name }}</h3>
                            <button @click="editMode = !editMode" 
                                    class="px-4 py-2 rounded text-white"
                                    :class="editMode ? 'bg-gray-600 hover:bg-gray-700' : 'bg-blue-500 hover:bg-blue-600'">
                                <span x-text="editMode ? 'Switch to View' : 'Switch to Edit'"></span>
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <form :class="editMode ? '' : 'pointer-events-none'" 
                                  action="{{ route('teacher.updateGrades', $subjectOffering->id) }}" 
                                  method="POST">
                                @csrf
                                @method('PUT')

                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-200">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">1st Grading</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">2nd Grading</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">3rd Grading</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">4th Grading</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Final Grade</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200">
                                        @foreach($subjectOffering->enrollmentSubjectOfferings as $eso)
                                            <tr class="hover:bg-gray-100">
                                                <td class="px-4 py-2 text-sm">{{ $eso->enrollment->student->id }}</td>
                                                <td class="px-4 py-2 text-sm">{{ $eso->enrollment->student->fullname }}</td>

                                                @foreach(['first_grading','second_grading','third_grading','fourth_grading','final_grade'] as $field)
                                                    <td class="px-2 py-1 text-center">
                                                        <template x-if="editMode">
                                                            <input type="number" 
                                                                   name="grades[{{ $eso->id }}][{{ $field }}]" 
                                                                   value="{{ old('grades.' . $eso->id . '.' . $field, $eso->$field) }}" 
                                                                   class="border p-1 w-16 text-center" min="0" max="100">
                                                        </template>
                                                        <template x-if="!editMode">
                                                            <span>{{ $eso->$field ?? '-' }}</span>
                                                        </template>
                                                    </td>
                                                @endforeach

                                                <td class="px-2 py-1">
                                                    <template x-if="editMode">
                                                        <input type="text" 
                                                               name="grades[{{ $eso->id }}][remarks]" 
                                                               value="{{ old('grades.' . $eso->id . '.remarks', $eso->remarks) }}" 
                                                               class="border p-1 w-full text-sm">
                                                    </template>
                                                    <template x-if="!editMode">
                                                        <span>{{ $eso->remarks ?? '-' }}</span>
                                                    </template>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 flex justify-end gap-2" x-show="editMode">
                                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg">Save</button>
                                    <button type="button" @click="editMode = false" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Cancel</button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>
