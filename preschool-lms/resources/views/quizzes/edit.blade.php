<x-app-layout>
    <div class="max-w-3xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Edit Quiz</h1>

        <form action="{{ route('quizzes.update', $quiz) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold mb-1">Title</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" 
                       value="{{ old('title', $quiz->title) }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $quiz->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Lesson (optional)</label>
                <select name="lesson_id" class="w-full border rounded px-3 py-2">
                    <option value="">— None —</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}" 
                            {{ $quiz->lesson_id == $lesson->id ? 'selected' : '' }}>
                            {{ $lesson->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Time Limit (minutes)</label>
                <input type="number" name="time_limit" class="w-full border rounded px-3 py-2"
                       value="{{ old('time_limit', $quiz->time_limit) }}">
            </div>

            <!-- ✅ Status dropdown -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="draft" {{ $quiz->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $quiz->status === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ $quiz->status === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update Quiz</button>
        </form>
    </div>
</x-app-layout>
