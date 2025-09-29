<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Add New Lesson</h1>

        {{-- Show validation errors --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lessons.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-semibold">Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border rounded-md p-2" required>
            </div>

            <div>
                <label class="block font-semibold">Description</label>
                <textarea name="description" class="w-full border rounded-md p-2">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block font-semibold">Image URL</label>
                <input type="url" name="image_url" value="{{ old('image_url') }}"
                       class="w-full border rounded-md p-2">
            </div>

            <div>
                <label class="block font-semibold">Video URL</label>
                <input type="url" name="video_url" value="{{ old('video_url') }}"
                       class="w-full border rounded-md p-2">
            </div>

            <div>
                <label class="block font-semibold">Document URL</label>
                <input type="url" name="document_url" value="{{ old('document_url') }}"
                       class="w-full border rounded-md p-2">
            </div>

            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">
                Save Lesson
            </button>
        </form>
    </div>
</x-app-layout>
