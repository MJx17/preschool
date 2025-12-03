<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            📊 Attendance Records — {{ $subjectOffering->subject->name ?? 'Unknown Subject' }}
        </h2>
        <p class="text-gray-600 text-sm">
            {{ optional($subjectOffering->teacher->user)->name ?? 'Teacher N/A' }}
        </p>
    </x-slot>

    <div class="max-w-6xl mx-auto bg-white p-6 shadow rounded-lg mt-6">

        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('attendance.teacher.index') }}"
                class="inline-block bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                ← Back to Subjects
            </a>
        </div>

        {{-- Subject Offering Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <p class="font-semibold">Section:</p>
                <p>{{ optional($subjectOffering->section)->name ?? '-' }}</p>
            </div>
            <div>
                <p class="font-semibold">Semester:</p>
                <p>{{ optional($subjectOffering->semester)->academic_year ?? '-' }} – {{ optional($subjectOffering->semester)->semester ?? '-' }}</p>
            </div>
            <div>
                <p class="font-semibold">Schedule:</p>
                <p>
                    @if($subjectOffering->days)
                    {{ implode(', ', json_decode($subjectOffering->days, true)) }}
                    {{ $subjectOffering->start_time ?? '-' }} – {{ $subjectOffering->end_time ?? '-' }}
                    @else
                    -
                    @endif
                </p>
            </div>
            <div>
                <p class="font-semibold">Room:</p>
                <p>{{ $subjectOffering->room ?? '-' }}</p>
            </div>
        </div>

        {{-- Attendance Sessions --}}
        @forelse($subjectOffering->attendanceSessions as $session)
        <div class="mb-6 border rounded-lg p-4 shadow-sm">
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-semibold text-gray-700">
                    🗓 {{ $session->date ?? 'N/A' }} — {{ $session->topic ?? 'No Topic' }}
                </h3>

                <div class="flex items-center gap-4">

                    {{-- Edit --}}
                    <a href="{{ route('attendance.teacher.edit', $session->id) }}"
                        class="text-blue-600 hover:underline text-sm">
                        Edit Session
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('attendance.teacher.destroy', $session->id) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this session? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline text-sm">
                            Delete
                        </button>
                    </form>

                </div>
            </div>
    

            <div class="overflow-x-auto">
                <table class="min-w-full border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-3 py-2 text-left">#</th>
                            <th class="border px-3 py-2 text-left">Student Name</th>
                            <th class="border px-3 py-2 text-center">Status</th>
                            <th class="border px-3 py-2 text-left">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($session->attendanceRecords as $index => $record)
                        <tr>
                            <td class="border px-3 py-2">{{ $index + 1 }}</td>
                            <td class="border px-3 py-2">{{ $record->student->full_name ?? $record->student->name }}</td>
                            <td class="border px-3 py-2 text-center">{{ $record->status }}</td>
                            <td class="border px-3 py-2">{{ $record->remarks ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 p-4">
                                No attendance records for this session.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <p class="text-gray-500">No attendance sessions recorded for this subject offering yet.</p>
        @endforelse

    </div>
</x-app-layout>