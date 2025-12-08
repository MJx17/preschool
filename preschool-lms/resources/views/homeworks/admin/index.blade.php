<x-app-layout>
    <div class="max-w-7xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">All Homeworks (Admin)</h1>

        {{-- Filters --}}
        <form method="GET" class="flex flex-wrap gap-4 mb-4 items-end">
            {{-- Teacher --}}
            <div>
                <label class="block text-sm font-medium mb-1">Teacher</label>
                <select name="teacher_id" class="border p-2 rounded">
                    <option value="">All Teachers</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Lesson --}}
            <div>
                <label class="block text-sm font-medium mb-1">Lesson</label>
                <select name="lesson_id" class="border p-2 rounded">
                    <option value="">All Lessons</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ request('lesson_id') == $lesson->id ? 'selected' : '' }}>
                            {{ $lesson->title }}
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
                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
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
                        <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
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
                        <option value="{{ $q }}" {{ request('quarter') == $q ? 'selected' : '' }}>Quarter {{ $q }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
            </div>
        </form>

        {{-- Homeworks Table --}}
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Title</th>
                    <th class="px-4 py-2 border">Lesson</th>
                    <th class="px-4 py-2 border">Quarter</th>
                    <th class="px-4 py-2 border">Subject</th>
                    <th class="px-4 py-2 border">Section</th>
                    <th class="px-4 py-2 border">Teacher</th>
                    <th class="px-4 py-2 border">Due Date</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($homeworks as $homework)
                    <tr>
                        <td class="border px-4 py-2">{{ $homework->title }}</td>
                        <td class="border px-4 py-2">{{ $homework->lesson->title ?? '—' }}</td>
                        <td class="border px-4 py-2">{{ $homework->lesson->quarter ? 'Quarter '.$homework->lesson->quarter : '—' }}</td>
                        <td class="border px-4 py-2">{{ $homework->lesson->subjectOffering->subject->name ?? '—' }}</td>
                        <td class="border px-4 py-2">{{ $homework->lesson->subjectOffering->section->name ?? '—' }}</td>
                        <td class="border px-4 py-2">{{ $homework->lesson->subjectOffering->teacher->user->name ?? '—' }}</td>
                        <td class="border px-4 py-2">{{ $homework->due_date ?? '—' }}</td>
                        <td class="border px-4 py-2 space-x-1">
                            <a href="{{ route('homeworks.show', $homework) }}" class="text-blue-500">View</a>
                            | <a href="{{ route('homeworks.edit', $homework) }}" class="text-green-500">Edit</a>
                            | <form action="{{ route('homeworks.destroy', $homework) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-red-500" onclick="return confirm('Delete this homework?')">Delete</button>
                              </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">No homeworks found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
             
            {{ $homeworks->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
