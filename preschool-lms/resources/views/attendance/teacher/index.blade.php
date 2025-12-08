<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">📋 Attendance Records</h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded-lg">

        {{-- FILTERS --}}
        <form method="GET" class="flex flex-wrap gap-4 mb-6">
            <select name="subject" class="border rounded p-2">
                <option value="all">All Subjects</option>
                @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>
                    {{ $subject->code }} - {{ $subject->name }}
                </option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Filter
            </button>
        </form>

        {{-- SUBJECTS --}}
        @forelse($subjects as $subject)
        <div class="mb-6">
            <h3 class="font-semibold text-gray-700 mb-2">{{ $subject->code }} - {{ $subject->name }}</h3>

            @if($subject->subjectOfferings->isNotEmpty())
            <table class="min-w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Semester</th>
                        <th class="px-4 py-2 text-left">Teacher</th>
                        <th class="px-4 py-2 text-left">Days</th>
                        <th class="px-4 py-2 text-left">Time</th>
                        <th class="px-4 py-2 text-left">Room</th>
                        <th class="px-4 py-2 text-left">Section</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subject->subjectOfferings as $offering)
                    <tr class="border-t">
                        <td class="px-4 py-2">
                            {{ optional($offering->semester)->academic_year ?? '-' }}
                            –
                            {{ optional($offering->semester)->semester ?? '-' }}
                        </td>

                        <td class="px-4 py-2">
                            {{ optional($offering->teacher->user)->name ?? 'TBA' }}
                        </td>

                        {{-- DAYS --}}
                        <td class="px-4 py-2">
                            @if($offering->days)
                                {{ implode(', ', json_decode($offering->days, true)) }}
                            @else
                                -
                            @endif
                        </td>

                        {{-- TIME --}}
                        <td class="px-4 py-2">
                            @if($offering->start_time && $offering->end_time)
                                {{ \Carbon\Carbon::parse($offering->start_time)->format('g:i A') }}
                                –
                                {{ \Carbon\Carbon::parse($offering->end_time)->format('g:i A') }}
                            @else
                                -
                            @endif
                        </td>

                        <td class="px-4 py-2">{{ $offering->room ?? '-' }}</td>
                        <td class="px-4 py-2">{{ optional($offering->section)->name ?? '-' }}</td>

                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('attendance.teacher.create', $offering->id) }}" class="text-green-600 hover:underline">
                                Take Attendance
                            </a>
                            <a href="{{ route('attendance.teacher.view', $offering->id) }}" class="text-blue-600 hover:underline">
                                View Attendance
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @else
            <p class="text-gray-500">No offerings for this subject yet.</p>
            @endif
        </div>

        @empty
        <p class="text-gray-500">No subjects assigned to you yet.</p>
        @endforelse

    </div>
</x-app-layout>
