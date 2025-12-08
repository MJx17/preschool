<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sections') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('sections.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                + Add Section
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grade Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Students</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($sections as $section)
                    <tr>
                        <td class="px-6 py-4">{{ $section->id }}</td>
                        <td class="px-6 py-4">{{ $section->name }}</td>
                        <td class="px-6 py-4">{{ $section->gradeLevel->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            {{ $section->enrollments_count ?? 0 }}/{{ $section->max_students ?? '-' }}
                        </td>

                        <td class="px-6 py-4 flex space-x-2">
                            <a href="{{ route('sections.show', $section->id) }}"
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">View</a>
                            <a href="{{ route('sections.edit', $section->id) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Edit</a>
                           
                            <form id="delete-form-{{ $section->id }}"
                                action="{{ route('sections.destroy', $section->id) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
                                    onclick="confirmDelete('delete-form-{{ $section->id }}')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                    @if($sections->isEmpty())
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No sections found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>