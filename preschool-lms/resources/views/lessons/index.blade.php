<x-app-layout>
    <div class="max-w-6xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Lessons</h1>

        <a href="{{ route('lessons.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-md mb-4 inline-block">
            + Add Lesson
        </a>

        {{-- FILTERS --}}
        <form method="GET" class="mb-6  p-4 flex gap-4 flex-wrap">

            {{-- Subject Filter --}}
            <div>
                <label class="block text-sm font-semibold">Subject</label>
                <select name="subject_id" class="border rounded px-3 py-2">
                    <option value="">All</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}"
                        {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Section Filter --}}
            <div>
                <label class="block text-sm font-semibold">Section</label>
                <select name="section_id" class="border rounded px-3 py-2">
                    <option value="">All</option>
                    @foreach($sections as $section)
                    <option value="{{ $section->id }}"
                        {{ request('section_id') == $section->id ? 'selected' : '' }}>
                        {{ $section->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Quarter Filter --}}
            <div>
                <label class="block text-sm font-semibold">Quarter</label>
                <select name="quarter" class="border rounded px-3 py-2">
                    <option value="">All</option>
                    <option value="1" {{ request('quarter') == 1 ? 'selected' : '' }}>1st Quarter</option>
                    <option value="2" {{ request('quarter') == 2 ? 'selected' : '' }}>2nd Quarter</option>
                    <option value="3" {{ request('quarter') == 3 ? 'selected' : '' }}>3rd Quarter</option>
                    <option value="4" {{ request('quarter') == 4 ? 'selected' : '' }}>4th Quarter</option>
                </select>
            </div>

            {{-- Filter Button --}}
            <div class="flex items-end">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
            </div>

        </form>


        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Title</th>
                    <th class="border px-4 py-2">Quarter</th>
                    <th class="border px-4 py-2">Grade Level</th>
                    <th class="border px-4 py-2">Subject Offering</th>
                    <th class="border px-4 py-2">Image</th>
                    <th class="border px-4 py-2">Video</th>
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

                    {{-- SUBJECT OFFERING DETAILS --}}
                    <td class="border px-4 py-2">
                        @if ($lesson->subjectOffering)
                        <div class="font-medium">{{ $lesson->subjectOffering->subject->name }}</div>
                        <div class="text-sm text-gray-600">
                            Section: {{ $lesson->subjectOffering->section->name }}
                        </div>
                        @if ($lesson->subjectOffering->teacher)
                        <div class="text-sm text-gray-600">
                            Teacher: {{ $lesson->subjectOffering->teacher->user->name }}
                        </div>
                        @endif
                        @else
                        <span class="text-gray-500 italic">Not linked</span>
                        @endif
                    </td>

                    {{-- IMAGE --}}
                    <td class="border px-4 py-2 text-center">
                        @if($lesson->image_url)
                        <img src="{{ $lesson->image_url }}" class="h-12 w-12 object-cover rounded mx-auto">
                        @else
                        <span class="text-gray-400 text-sm">None</span>
                        @endif
                    </td>

                    {{-- VIDEO --}}
                    <td class="border px-4 py-2 text-center">
                        @if($lesson->video_url)
                        <a href="{{ $lesson->video_url }}" target="_blank" class="text-blue-600 underline">
                            Watch
                        </a>
                        @else
                        <span class="text-gray-400 text-sm">None</span>
                        @endif
                    </td>

                    {{-- ACTIONS --}}
                    <td class="border px-4 py-2 text-center space-x-2">
                        <a href="{{ route('lessons.show', $lesson) }}" class="text-green-600">View</a>
                        <a href="{{ route('lessons.edit', $lesson) }}" class="text-yellow-600">Edit</a>
                        <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="inline-block"
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

    </div>
</x-app-layout>