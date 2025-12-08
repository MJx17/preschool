<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">📋 Attendance Records</h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded-lg">

        {{-- FILTERS --}}
        <form method="GET" class="flex flex-wrap gap-4 mb-4">
            <select name="subject" class="border rounded p-2">
                <option value="all">All Subjects</option>
                @foreach ($subjects as $subject)
                <option value="{{ $subject->name }}" {{ request('subject') == $subject->name ? 'selected' : '' }}>
                    {{ $subject->code }} - {{ $subject->name }}
                </option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
        </form>

        {{-- TABLE --}}
        @forelse($subjects as $subject)
        <h3 class="font-semibold text-gray-700 mb-2">{{ $subject->code }} - {{ $subject->name }}</h3>

        @if($subject->subjectOfferings->isNotEmpty())
        <table class="min-w-full border text-sm mb-6">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Semester</th>
                    <th class="px-4 py-2 text-left">Teacher</th>
                    <th class="px-4 py-2 text-left">Schedule</th>
                    <th class="px-4 py-2 text-left">Time</th>
                    <th class="px-4 py-2 text-left">Room</th>
                    <th class="px-4 py-2 text-left">Section</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subject->subjectOfferings as $subjectOffering)
                <tr class="border-t">
                    <td class="px-4 py-2">
                        {{ $subjectOffering->semester->academic_year }} – {{ $subjectOffering->semester->semester }}
                    </td>
                    <td class="px-4 py-2">
                        {{ optional($subjectOffering->teacher->user)->name ?? 'TBA' }}
                    </td>
                    <td class="px-4 py-2">
                        @if($subjectOffering->days)
                        {{ implode(', ', json_decode($subjectOffering->days,true)) }}
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if($subjectOffering->days)
                        {{ $subjectOffering->start_time }} – {{ $subjectOffering->end_time }}
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $subjectOffering->room }}</td>
                    <td class="px-4 py-2">{{ $subjectOffering->section->name }}</td>
                    <td class="px-4 py-2 space-x-2">


                        <a href="{{ route('attendance.admin.view', $subjectOffering->id) }}"
                            class="text-blue-600 hover:underline">
                            View Attendance
                        </a>


                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-gray-500 mb-6">No offerings for this subject yet.</p>
        @endif
        @empty
        <p class="text-gray-500">No subjects available.</p>
        @endforelse

    </div>
</x-app-layout>