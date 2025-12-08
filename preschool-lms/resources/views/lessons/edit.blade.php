<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Edit Lesson</h1>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lessons.update', $lesson->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Subject Offering Dropdown --}}
            <div>
                <label class="block font-semibold">Select Subject/Section</label>
                <select name="subject_offerings_id" required class="w-full border rounded-md p-2">
                    <option value="">-- Select Subject/Section --</option>
                    @foreach ($subjectOfferings as $offering)
                        <option value="{{ $offering['id'] }}" 
                            {{ $lesson->subject_offerings_id == $offering['id'] ? 'selected' : '' }}>
                            {{ $offering['gradeLevel'] }} — {{ $offering['subjectCode'] }} — {{ $offering['sectionName'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Title --}}
            <div>
                <label class="block font-semibold">Title</label>
                <input type="text" name="title" value="{{ old('title', $lesson->title) }}" class="w-full border rounded-md p-2" required>
            </div>

            {{-- Description --}}
            <div>
                <label class="block font-semibold">Description</label>
                <textarea name="description" class="w-full border rounded-md p-2">{{ old('description', $lesson->description) }}</textarea>
            </div>

            {{-- Quarter --}}
            <div>
                <label class="block text-sm font-medium">Quarter</label>
                <select name="quarter" required class="mt-1 block w-full border rounded p-2">
                    <option value="">Select Quarter</option>
                    @for ($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" {{ old('quarter', $lesson->quarter) == $i ? 'selected' : '' }}>Quarter {{ $i }}</option>
                    @endfor
                </select>
            </div>

            {{-- Image/Video/Document --}}
            <div>
                <label class="block font-semibold">Image URL</label>
                <input type="url" name="image_url" value="{{ old('image_url', $lesson->image_url) }}" class="w-full border rounded-md p-2">
            </div>
            <div>
                <label class="block font-semibold">Video URL</label>
                <input type="url" name="video_url" value="{{ old('video_url', $lesson->video_url) }}" class="w-full border rounded-md p-2">
            </div>
            <div>
                <label class="block font-semibold">Document URL</label>
                <input type="url" name="document_url" value="{{ old('document_url', $lesson->document_url) }}" class="w-full border rounded-md p-2">
            </div>

            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Update Lesson</button>
        </form>
    </div>
</x-app-layout>
