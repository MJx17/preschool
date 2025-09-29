<x-app-layout>
    <div class="max-w-6xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Quizzes</h1>

        <a href="{{ route('quizzes.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded">Add Quiz</a>

        <table class="w-full mt-6 border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Title</th>
                    <th class="px-4 py-2 border">Lesson</th>
                    <th class="px-4 py-2 border">Time Limit</th>
                    <th class="px-4 py-2 border">Status</th> <!-- ✅ Added -->
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quizzes as $quiz)
                    <tr>
                        <td class="border px-4 py-2">{{ $quiz->title }}</td>
                        <td class="border px-4 py-2">{{ $quiz->lesson->title ?? '—' }}</td>
                        <td class="border px-4 py-2">{{ $quiz->time_limit ? $quiz->time_limit . ' min' : '—' }}</td>
                        <td class="border px-4 py-2">
                            @if($quiz->status === 'draft')
                                <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded text-sm">Draft</span>
                            @elseif($quiz->status === 'published')
                                <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-sm">Published</span>
                            @elseif($quiz->status === 'archived')
                                <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-sm">Archived</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('quizzes.show', $quiz) }}" class="text-blue-500">View</a> |
                            <a href="{{ route('quizzes.edit', $quiz) }}" class="text-green-500">Edit</a> |
                            <form action="{{ route('quizzes.destroy', $quiz) }}" 
                                  method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-red-500" onclick="return confirm('Delete this quiz?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No quizzes found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $quizzes->links() }}
        </div>
    </div>
</x-app-layout>
