<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Section Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-4">
            <h3 class="text-2xl font-bold mb-2">{{ $section->name }} - {{ $section->gradeLevel->name }}</h3>
            <p class="text-gray-600 mb-4">
                Enrolled Students: {{ $section->enrollments->count() }}/{{ $section->max_students }}
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Students Enrolled</h3>
            
            @if($section->enrollments->isEmpty())
                <p class="text-gray-500">No students enrolled in this section yet.</p>
            @else
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Student Name</th>
                            <th class="px-4 py-2 border">Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($section->enrollments as $index => $enrollment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border">{{ $enrollment->student->fullname }}</td>
                                <td class="px-4 py-2 border">{{ ucfirst($enrollment->category) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
