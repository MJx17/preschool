<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📚 Lessons
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Lessons List</h3>
                        <a href="{{ route('lessons.create') }}"
                           class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                            ➕ Add Lesson
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">#</th>
                                <th class="border p-2">Title</th>
                                <th class="border p-2">Type</th>
                                <th class="border p-2">Created By</th>
                                <th class="border p-2">Created At</th>
                                <th class="border p-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lessons as $lesson)
                                <tr>
                                    <td class="border p-2">{{ $lesson->id }}</td>
                                    <td class="border p-2">{{ $lesson->title }}</td>
                                    <td class="border p-2 capitalize">{{ $lesson->type }}</td>
                                    <td class="border p-2">{{ $lesson->teacher->name ?? 'N/A' }}</td>
                                    <td class="border p-2">{{ $lesson->created_at->format('M d, Y') }}</td>
                                    <td class="border p-2 text-center">
                                        <a href="{{ route('lessons.show', $lesson->id) }}"
                                           class="text-blue-500 hover:underline">View</a> |
                                        <a href="{{ route('lessons.edit', $lesson->id) }}"
                                           class="text-yellow-500 hover:underline">Edit</a> |
                                        <form action="{{ route('lessons.destroy', $lesson->id) }}"
                                              method="POST" class="inline-block"
                                              onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border p-4 text-center text-gray-500">
                                        No lessons found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $lessons->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
