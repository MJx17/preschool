<x-app-layout>
    <div class="max-w-6xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Homeworks</h1>
        <a href="{{ route('homeworks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Homework</a>

        <table class="w-full mt-6 border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Title</th>
                    <th class="px-4 py-2 border">Lesson</th>
                    <th class="px-4 py-2 border">Due Date</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($homeworks as $homework)
                    <tr>
                        <td class="border px-4 py-2">{{ $homework->title }}</td>
                        <td class="border px-4 py-2">{{ $homework->lesson->title ?? '—' }}</td>
                        <td class="border px-4 py-2">{{ $homework->due_date ?? '—' }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('homeworks.show', $homework) }}" class="text-blue-500">View</a> |
                            <a href="{{ route('homeworks.edit', $homework) }}" class="text-green-500">Edit</a> |
                            <form action="{{ route('homeworks.destroy', $homework) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-red-500" onclick="return confirm('Delete this homework?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $homeworks->links() }}
        </div>
    </div>
</x-app-layout>
