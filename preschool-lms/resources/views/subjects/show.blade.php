{{-- resources/views/subjects/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Subject Details – {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {{-- Subject Basic Info --}}
                <h3 class="text-lg font-bold mb-4">Subject Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div><span class="font-semibold">Code:</span> {{ $subject->code }}</div>
                    <div>
                        <span class="font-semibold">Grade Level:</span>
                        {{ $subject->gradeLevel?->name ?? 'N/A' }}
                    </div>

                    <div><span class="font-semibold">Units:</span> {{ $subject->units }}</div>
                    <div><span class="font-semibold">Fee:</span> ₱{{ number_format($subject->fee,2) }}</div>
                    @if($subject->prerequisite)
                    <div class="col-span-2">
                        <span class="font-semibold">Prerequisite:</span> {{ $subject->prerequisite->name }}
                    </div>
                    @endif
                </div>

                {{-- Offerings list --}}
                <h3 class="text-lg font-bold mt-8 mb-4">Subject Schedules</h3>
                @if($subject->subjectOfferings->count())
                <table class="min-w-full border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Semester</th>
                            <th class="px-4 py-2 text-left">Teacher</th>
                            <th class="px-4 py-2 text-left">Schedule</th>
                            <th class="px-4 py-2 text-left">Room</th>
                            <th class="px-4 py-2 text-left">Block</th>
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
                                {{-- if you have days/time stored --}}
                                @if($subjectOffering->days)
                                {{ implode(', ', json_decode($subjectOffering->days,true)) }}
                                {{ $subjectOffering->start_time }} – {{ $subjectOffering->end_time }}
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $subjectOffering->room }}</td>
                            <td class="px-4 py-2">{{ $subjectOffering->block }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-gray-500">No offerings for this subject yet.</p>
                @endif

                <div class="mt-6">
                    <a href="{{ route('subjects.index') }}"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Back to list
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>