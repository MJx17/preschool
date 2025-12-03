<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Attendance - {{ $session->subjectOffering->subject->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                <form action="{{ route('attendance.teacher.update', $session->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Session Details -->
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-200">Session Details</h3>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-medium">Topic</label>
                        <input type="text" name="topic" value="{{ $session->topic }}"
                            class="w-full p-2 border dark:bg-gray-700 dark:text-white rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-medium">Date</label>
                        <input type="date" name="date" value="{{ $session->date }}"
                            class="w-full p-2 border dark:bg-gray-700 dark:text-white rounded">
                    </div>

                    <!-- Student Attendance Records -->
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-200">Student Attendance</h3>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2">Student</th>
                                <th class="border-b py-2">Status</th>
                                <th class="border-b py-2">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($session->attendanceRecords as $record)
                            <tr>
                                <td class="py-2 text-gray-800 dark:text-gray-300">
                                    {{ $record->student->name }}
                                </td>

                                <td class="py-2">
                                    <select name="status[{{ $record->id }}]"
                                        class="p-2 border rounded dark:bg-gray-700 dark:text-white">
                                        <option value="Present" {{ $record->status == 'Present' ? 'selected' : '' }}>Present</option>
                                        <option value="Absent" {{ $record->status == 'Absent' ? 'selected' : '' }}>Absent</option>
                                        <option value="Late" {{ $record->status == 'Late' ? 'selected' : '' }}>Late</option>
                                        <option value="Excused" {{ $record->status == 'Excused' ? 'selected' : '' }}>Excused</option>

                                    </select>
                                </td>

                                <td class="py-2">
                                    <input type="text"
                                        name="remarks[{{ $record->id }}]"
                                        value="{{ $record->remarks }}"
                                        class="w-full p-2 border dark:bg-gray-700 dark:text-white rounded">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Submit -->
                    <div class="mt-6">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">
                            Save Changes
                        </button>

                        <a href="{{ route('attendance.teacher.view', $session->subject_offering_id) }}"
                            class="ml-3 text-gray-600 dark:text-gray-300 hover:underline">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>