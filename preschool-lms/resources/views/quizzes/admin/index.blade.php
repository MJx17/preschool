<x-app-layout>
    <div class="max-w-7xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">All Quizzes</h1>

        {{-- Quizzes Table --}}
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Title</th>
                    <th class="px-4 py-2 border">Lesson</th>
                    <th class="px-4 py-2 border">Quarter</th>
                    <th class="px-4 py-2 border">Subject</th>
                    <th class="px-4 py-2 border">Section</th>
                    <th class="px-4 py-2 border">Type</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quizzes as $quiz)
                    <tr>
                        <td class="border px-4 py-2">{{ $quiz->title }}</td>
                        <td class="border px-4 py-2">{{ $quiz->lesson->title ?? '—' }}</td>
                        <td class="border px-4 py-2">{{ $quiz->lesson->quarter ?? '—' }}</td>
                        <td class="border px-4 py-2">{{ $quiz->subjectOffering->subject->name ?? '—' }}</td>
                        <td class="border px-4 py-2">{{ $quiz->subjectOffering->section->name ?? '—' }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($quiz->type) }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($quiz->status) }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('quizzes.show', $quiz) }}" class="text-blue-500">View</a>
                            <a href="{{ route('quizzes.edit', $quiz) }}" class="text-green-500">Edit</a>
                            <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500" onclick="return confirm('Delete this quiz?')">Delete</button>
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
