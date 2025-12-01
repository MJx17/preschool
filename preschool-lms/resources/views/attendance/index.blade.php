<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">📋 Attendance Records</h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded-lg">
        <form method="GET" class="flex flex-wrap gap-4 mb-4">
            <div>
                <label class="font-semibold">Filter by Subject:</label>
                <select name="subject_offering_id" class="border rounded p-2">
                    <option value="all">All</option>
                    @foreach ($subjectOfferings as $offering)
                        <option value="{{ $offering->id }}" {{ request('subject_offering_id') == $offering->id ? 'selected' : '' }}>
                            {{ $offering->subject->name ?? 'Unknown Subject' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-semibold">Date:</label>
                <input type="date" name="date" value="{{ request('date') }}" class="border rounded p-2">
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full border">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-2 border">Date</th>
                        <th class="p-2 border">Subject</th>
                        <th class="p-2 border">Teacher</th>
                        <th class="p-2 border">Topic</th>
                        <th class="p-2 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sessions as $session)
                        <tr>
                            <td class="p-2 border">{{ $session->date->format('M d, Y') }}</td>
                            <td class="p-2 border">{{ $session->subjectOffering->subject->name ?? 'N/A' }}</td>
                            <td class="p-2 border">{{ $session->subjectOffering->teacher->name ?? 'N/A' }}</td>
                            <td class="p-2 border">{{ $session->topic ?? '-' }}</td>
                            <td class="p-2 border text-center">
                                <a href="{{ route('attendance.create', $session->subject_offering_id) }}" class="text-blue-600 hover:underline">Take Attendance</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-gray-500">No attendance sessions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $sessions->links() }}
        </div>
    </div>
</x-app-layout>
