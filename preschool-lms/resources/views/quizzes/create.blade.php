<x-app-layout>
    <div class="max-w-3xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Add New Quiz</h1>

        <form action="{{ route('quizzes.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Title -->
            <div>
                <label class="block mb-1 font-medium">Quiz Title</label>
                <input type="text" name="title" 
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            <!-- Description -->
            <div>
                <label class="block mb-1 font-medium">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <!-- Lesson -->
            <div>
                <label class="block mb-1 font-medium">Select Lesson</label>
                <select name="lesson_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Choose Lesson --</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Time Limit -->
            <div>
                <label class="block mb-1 font-medium">Time Limit (minutes)</label>
                <input type="number" name="time_limit" 
                       class="w-full border rounded px-3 py-2"
                       placeholder="e.g. 30">
            </div>

            <!-- Status -->
            <div>
                <label class="block mb-1 font-medium">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="draft" selected>Draft</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                </select>
            </div>

            <!-- Type -->
            <div>
                <label class="block mb-1 font-medium">Quiz Type</label>
                <select name="type" class="w-full border rounded px-3 py-2" required>
                    <option value="short" selected>Short</option>
                    <option value="long">Long</option>
                </select>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded">
                    Save Quiz
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
