<x-app-layout>
    <div class="max-w-7xl mx-auto py-8">

        <h1 class="text-2xl font-bold mb-6">All Lessons (Admin)</h1>

        {{-- Filter Form --}}
        <form method="GET" class="flex flex-wrap gap-4 mb-6 items-end">

            {{-- Teacher --}}
            <div>
                <label class="block text-sm font-medium mb-1">Teacher</label>
                <select name="teacher_id" class="border p-2 rounded">
                    <option value="">All Teachers</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}"
                        {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->user->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Subject --}}
            <div>
                <label class="block text-sm font-medium mb-1">Subject</label>
                <select name="subject_id" class="border p-2 rounded">
                    <option value="">All Subjects</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}"
                        {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->code }} - {{ $subject->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            {{-- Grade Level --}}
            {{-- Grade Level --}}
            <div>
                <label class="block text-sm font-medium mb-1">Grade Level</label>
                <select name="grade_level_id" class="border p-2 rounded">
                    <option value="">All Grade Levels</option>
                    @foreach($gradeLevels as $gl)
                    <option value="{{ $gl->id }}"
                        {{ $selectedGradeLevel == $gl->id ? 'selected' : '' }}>
                        {{ $gl->name }}
                    </option>
                    @endforeach
                </select>
            </div>



            {{-- Section --}}
            <div>
                <label class="block text-sm font-medium mb-1">Section</label>
                <select name="section_id" class="border p-2 rounded">
                    <option value="">All Sections</option>
                    @foreach($sections as $section)
                    <option value="{{ $section->id }}"
                        {{ request('section_id') == $section->id ? 'selected' : '' }}>
                        {{ $section->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Quarter --}}
            <div>
                <label class="block text-sm font-medium mb-1">Quarter</label>
                <select name="quarter" class="border p-2 rounded">
                    <option value="">All Quarters</option>
                    @foreach($quarters as $q)
                    <option value="{{ $q }}"
                        {{ request('quarter') == $q ? 'selected' : '' }}>
                        Quarter {{ $q }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded">
                    Filter
                </button>
            </div>

        </form>

        {{-- Lessons Table --}}
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Title</th>
                    <th class="border px-4 py-2">Quarter</th>
                    <th class="border px-4 py-2">Grade Level</th>
                    <th class="border px-4 py-2">Subject</th>
                    <th class="border px-4 py-2">Teacher</th>
                    <th class="border px-4 py-2">Section</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($lessons as $lesson)
                <tr>
                    <td class="border px-4 py-2">{{ $lesson->id }}</td>
                    <td class="border px-4 py-2 font-semibold">{{ $lesson->title }}</td>

                    {{-- Quarter --}}
                    <td class="border px-4 py-2">
                        {{ $lesson->quarter ? 'Quarter '.$lesson->quarter : '-' }}
                    </td>

                    {{-- Grade Level --}}
                    <td class="border px-4 py-2">
                        {{ $lesson->subjectOffering->subject->gradeLevel->name ?? '-' }}
                    </td>

                    {{-- Subject --}}
                    <td class="border px-4 py-2">
                        {{ $lesson->subjectOffering->subject->name ?? '-' }}
                    </td>

                    {{-- Teacher --}}
                    <td class="border px-4 py-2">
                        {{ $lesson->subjectOffering->teacher->user->name ?? '-' }}
                    </td>

                    {{-- Section --}}
                    <td class="border px-4 py-2">
                        {{ $lesson->subjectOffering->section->name ?? '-' }}
                    </td>

                    {{-- Actions --}}
                    <td class="border px-4 py-2 space-x-2">
                        <a href="{{ route('lessons.show', $lesson) }}" class="text-green-600">View</a>
                        <a href="{{ route('lessons.edit', $lesson) }}" class="text-yellow-600">Edit</a>
                        <form action="{{ route('lessons.destroy', $lesson) }}" method="POST"
                            class="inline-block"
                            onsubmit="return confirm('Delete this lesson?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">No lessons found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>


        {{-- Pagination --}}
        <div class="mt-4">
            {{ $lessons->withQueryString()->links() }}
        </div>

    </div>
</x-app-layout>