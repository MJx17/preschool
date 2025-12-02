<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Subject Offerings') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="bg-white p-6 shadow rounded">
            @if($subjects->count() > 0)
                <table class="min-w-full text-sm">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Subject</th>
                            <th class="px-4 py-2 text-left">Section</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjects as $offering)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $offering->subject->name }}</td>
                                <td class="px-4 py-2">{{ $offering->section->name }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('attendance.create', $offering->id) }}"
                                       class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                        📝 Mark Attendance
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-600">No subjects assigned to you.</p>
            @endif
        </div>
    </div>
</x-app-layout>
