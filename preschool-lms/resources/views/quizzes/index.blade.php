<x-app-layout>
    <div class="max-w-6xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Quizzes</h1>

        <a href="{{ route('quizzes.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-md mb-4 inline-block">
            + Add Quiz
        </a>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Title</th>
                    <th class="border px-4 py-2">Lesson</th>
                    <th class="border px-4 py-2">Subject / Section</th>
                    <th class="border px-4 py-2">Time Limit</th>
                    <th class="border px-4 py-2">Type</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($quizzes as $quiz)
                    <tr>
                        <td class="border px-4 py-2">{{ $quiz->id }}</td>
                        <td class="border px-4 py-2 font-semibold">{{ $quiz->title }}</td>

                        {{-- Lesson --}}
                        <td class="border px-4 py-2">
                            {{ $quiz->lesson?->title ?? '-' }}
                        </td>

                        {{-- Subject / Section --}}
                        <td class="border px-4 py-2">
                            @if($quiz->lesson?->subjectOffering)
                                <div class="font-medium">{{ $quiz->lesson->subjectOffering->subject->name }}</div>
                                <div class="text-sm text-gray-600">
                                    Section: {{ $quiz->lesson->subjectOffering->section->name }}
                                </div>
                                @if($quiz->lesson->subjectOffering->teacher)
                                    <div class="text-sm text-gray-600">
                                        Teacher: {{ $quiz->lesson->subjectOffering->teacher->user->name }}
                                    </div>
                                @endif
                            @else
                                <span class="text-gray-500 italic">Not linked</span>
                            @endif
                        </td>

                        {{-- Time Limit --}}
                        <td class="border px-4 py-2">
                            {{ $quiz->time_limit ? $quiz->time_limit.' min' : '-' }}
                        </td>

                        {{-- Type --}}
                        <td class="border px-4 py-2 capitalize">{{ $quiz->type ?? '-' }}</td>

                        {{-- Status --}}
                        <td class="border px-4 py-2">
                            @switch($quiz->status)
                                @case('draft')
                                    <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded text-sm">Draft</span>
                                    @break
                                @case('published')
                                    <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-sm">Published</span>
                                    @break
                                @case('archived')
                                    <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-sm">Archived</span>
                                    @break
                            @endswitch
                        </td>

                        {{-- Actions --}}
                        <td class="border px-4 py-2 text-center space-x-2">
                            <a href="{{ route('quizzes.show', $quiz) }}" class="text-green-600">View</a>
                            <a href="{{ route('quizzes.edit', $quiz) }}" class="text-yellow-600">Edit</a>
                            <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Delete this quiz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">No quizzes found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $quizzes->links() }}
        </div>
    </div>
</x-app-layout>
