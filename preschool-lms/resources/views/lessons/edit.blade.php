<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Edit Lesson</h1>

        <form action="{{ route('lessons.update', $lesson) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold">Title</label>
                <input type="text" name="title" class="w-full border rounded-md p-2" value="{{ $lesson->title }}" required>
            </div>

            <div>
                <label class="block font-semibold">Description</label>
                <textarea name="description" class="w-full border rounded-md p-2">{{ $lesson->description }}</textarea>
            </div>

            <div>
                <label class="block font-semibold">Image URL</label>
                <input type="url" name="image_url" class="w-full border rounded-md p-2" value="{{ $lesson->image_url }}">
            </div>

            <div>
                <label class="block font-semibold">Video URL</label>
                <input type="url" name="video_url" class="w-full border rounded-md p-2" value="{{ $lesson->video_url }}">
            </div>

            <div>
                <label class="block font-semibold">Document URL</label>
                <input type="url" name="document_url" class="w-full border rounded-md p-2" value="{{ $lesson->document_url }}">
            </div>

            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Update Lesson</button>
        </form>
    </div>
</x-app-layout>
