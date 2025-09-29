<x-app-layout>
    <div class="max-w-3xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Edit Homework</h1>

        <form action="{{ route('homeworks.update', $homework) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block">Title</label>
                <input type="text" name="title" value="{{ $homework->title }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block">Instructions</label>
                <textarea name="instructions" class="w-full border rounded px-3 py-2">{{ $homework->instructions }}</textarea>
            </div>

            <div>
                <label class="block">File URL</label>
                <input type="text" name="file_url" value="{{ $homework->file_url }}" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block">Video URL</label>
                <input type="text" name="video_url" value="{{ $homework->video_url }}" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block">Due Date</label>
                <input type="date" name="due_date" value="{{ $homework->due_date }}" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block">Related Lesson</label>
                <select name="lesson_id" class="w-full border rounded px-3 py-2">
                    <option value="">— None —</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ $lesson->id == $homework->lesson_id ? 'selected' : '' }}>
                            {{ $lesson->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</x-app-layout>
