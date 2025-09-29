<x-app-layout>
    <div class="max-w-6xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Lessons</h1>

        <a href="{{ route('lessons.create') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded-md mb-4 inline-block">
           + Add Lesson
        </a>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Title</th>
                    <th class="border px-4 py-2">Image</th>
                    <th class="border px-4 py-2">Video</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lessons as $lesson)
                    <tr>
                        <td class="border px-4 py-2">{{ $lesson->id }}</td>
                        <td class="border px-4 py-2">{{ $lesson->title }}</td>
                        <td class="border px-4 py-2">
                            @if($lesson->image_url)
                                <img src="{{ $lesson->image_url }}" class="h-12 w-12 object-cover rounded">
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            @if($lesson->video_url)
                                <a href="{{ $lesson->video_url }}" target="_blank" class="text-blue-600 underline">Watch</a>
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('lessons.show', $lesson) }}" class="text-green-600">View</a> |
                            <a href="{{ route('lessons.edit', $lesson) }}" class="text-yellow-600">Edit</a> |
                            <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this lesson?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No lessons found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
