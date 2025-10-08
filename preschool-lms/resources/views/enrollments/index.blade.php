<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Enrollments
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Semester Filter --}}
            <div class="mb-4 flex items-center justify-between">
                @if($semesters->count() > 0)
                <form action="{{ route('enrollments.index') }}" method="GET" class="flex items-center space-x-2 w-full max-w-sm">
                    <label for="semester" class="font-semibold whitespace-nowrap">Semester:</label>
                    <div class="relative flex-1">
                        <select name="semester_id" id="semester"
                            class="block appearance-none w-full border rounded p-2 pr-8 cursor-pointer"
                            onchange="this.form.submit()">
                            @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" @if($semesterId==$semester->id) selected @endif>
                                {{ $semester->semester  }} - {{ $semester-> status_label }} <!-- Use the correct column -->
                            </option>
                            @endforeach
                        </select>

                    </div>
                </form>
                @else
                <span class="text-gray-500">No semesters available</span>
                @endif

                <a href="{{ route('enrollments.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Add New Enrollment
                </a>
            </div>

            {{-- Enrollment Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($enrollments->count() > 0)
                    <table class="w-full border border-gray-200 rounded">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-2 border">Student</th>
                                <th class="p-2 border">Grade Level</th>
                                <th class="p-2 border">Semester</th>
                                <th class="p-2 border">Category</th>
                                <th class="p-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollments as $enrollment)
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 border">{{ $enrollment->student->fullname ?? 'N/A' }}</td>
                                <td class="p-2 border">{{ $enrollment->grade_level_text ?? 'N/A' }}</td>
                                <td class="p-2 border">{{ $enrollment->full_semester ?? 'N/A' }}</td>
                                <td class="p-2 border">{{ $enrollment->category_text ?? 'N/A' }}</td>

                                <td class="p-2 border space-x-2">
                                    <a href="{{ route('enrollments.show', $enrollment->id) }}" class="text-blue-500 hover:underline">View</a>
                                    <a href="{{ route('enrollments.edit', $enrollment->id) }}" class="text-yellow-500 hover:underline">Edit</a>
                                    <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $enrollments->links() }}
                    </div>
                    @else
                    <div class="text-center py-8 text-gray-500">
                        No enrollments found for this semester.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>