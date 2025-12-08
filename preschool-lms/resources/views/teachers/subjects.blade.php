<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Teacher Subjects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">
                        {{ $teacher->first_name }} {{ $teacher->surname }}
                    </h3>

                    @if($subjectOfferings->isEmpty())
                    <p>No subjects assigned to this teacher.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-200 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Subject Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Subject Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Units</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Days</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Room</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Block</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($subjectOfferings as $offering)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    <td class="px-6 py-4 text-sm">{{ $offering->subject->code ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $offering->subject->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $offering->subject->units ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm">{{ implode(', ', json_decode($offering->days, true) ?? []) }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        {{ \Carbon\Carbon::parse($offering->start_time)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($offering->end_time)->format('h:i A') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $offering->room ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $offering->block ?? 'N/A' }}</td>

                               
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $subjectOfferings->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>