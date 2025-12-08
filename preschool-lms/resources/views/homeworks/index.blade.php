<x-app-layout>
    <div class="max-w-6xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Homeworks</h1>

        <a href="{{ route('homeworks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
            Add Homework
        </a>

        {{-- Filters --}}
        <form method="GET" class="flex flex-wrap gap-4 mb-4 items-end">
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
        <table class="w-full mt-2 border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Title</th>
                    <th class="px-4 py-2 border">Lesson</th>
                    <th class="px-4 py-2 border">Quarter</th>
                    <th class="px-4 py-2 border">Subject / Section / Teacher</th>
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
                        <td class="border px-4 py-2">
                            @if($homework->lesson->subjectOffering)
                                <div class="font-medium">{{ $homework->lesson->subjectOffering->subject->name }}</div>
                                <div class="text-sm text-gray-600">Section: {{ $homework->lesson->subjectOffering->section->name }}</div>
                                <div class="text-sm text-gray-600">Teacher: {{ $homework->lesson->subjectOffering->teacher->user->name }}</div>
                            @else
                                <span class="text-gray-500 italic">Not linked</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $homework->due_date ?? '—' }}</td>
                        <td class="border px-4 py-2 space-x-1">
                            <a href="{{ route('homeworks.show', $homework) }}" class="text-blue-500">View</a>
                            <a href="{{ route('homeworks.edit', $homework) }}" class="text-green-500">Edit</a>
                            <form action="{{ route('homeworks.destroy', $homework) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-red-500" onclick="return confirm('Delete this homework?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No homeworks found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $homeworks->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
