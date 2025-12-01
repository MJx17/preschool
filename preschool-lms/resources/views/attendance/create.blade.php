<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            📝 Take Attendance — {{ $subjectOffering->subject->name ?? 'Unknown Subject' }}
        </h2>
        <p class="text-gray-600 text-sm">
            {{ $subjectOffering->teacher->name ?? 'Teacher N/A' }}
        </p>
    </x-slot>

    <div 
        class="max-w-5xl mx-auto bg-white p-6 shadow rounded-lg mt-6"
        x-data="{ markAll(status) {
            document.querySelectorAll('select[name^=\'students\']').forEach(select => {
                select.value = status;
            });
        }}"
    >
        <form action="{{ route('attendance.store', $subjectOffering->id) }}" method="POST">
            @csrf

            {{-- Date & Topic --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold mb-1">Date:</label>
                    <input type="date" name="date" value="{{ now()->toDateString() }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Topic / Lesson:</label>
                    <input type="text" name="topic" placeholder="Enter topic covered" class="w-full border rounded p-2">
                </div>
            </div>

            {{-- Mark All Buttons --}}
            <div class="flex flex-wrap gap-2 mb-4">
                <button type="button" x-on:click="markAll('Present')" class="bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600">
                    ✅ Mark All Present
                </button>
                <button type="button" x-on:click="markAll('Absent')" class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600">
                    ❌ Mark All Absent
                </button>
                <button type="button" x-on:click="markAll('Late')" class="bg-yellow-500 text-white px-3 py-2 rounded hover:bg-yellow-600">
                    ⏰ Mark All Late
                </button>
                <button type="button" x-on:click="markAll('Excused')" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">
                    📄 Mark All Excused
                </button>
            </div>

            {{-- Students Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-3 py-2 text-left">#</th>
                            <th class="border px-3 py-2 text-left">Student Name</th>
                            <th class="border px-3 py-2 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $index => $student)
                            <tr>
                                <td class="border px-3 py-2">{{ $index + 1 }}</td>
                                <td class="border px-3 py-2">{{ $student->full_name ?? $student->name }}</td>
                                <td class="border px-3 py-2 text-center">
                                    <select name="students[{{ $student->id }}]" class="border rounded p-1">
                                        <option value="Present">✅ Present</option>
                                        <option value="Absent">❌ Absent</option>
                                        <option value="Late">⏰ Late</option>
                                        <option value="Excused">📄 Excused</option>
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-gray-500 p-4">
                                    No students enrolled in this subject offering.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Submit --}}
            <div class="mt-6 text-right">
                <a href="{{ route('attendance.index') }}" class="inline-block bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2 hover:bg-gray-400">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    💾 Save Attendance
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
