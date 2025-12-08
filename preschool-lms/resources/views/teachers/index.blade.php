<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Professors') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <div class="flex justify-between mb-6">
            <div class="flex justify-between mb-6 gap-2">
                <a href="{{ route('teachers.create') }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Add Professor
                </a>
                <a href="{{ route('register_teacher') }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    New User
                </a>


            </div>
        </div>

        <div class="overflow-x-auto shadow-sm rounded-lg">
            <table class="min-w-full table-auto border-collapse bg-white rounded">
                <thead>
                    <tr class="bg-gray-300">
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">User ID</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Name</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Designation</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)
                        <tr class="border-b hover:bg-gray-100 transition duration-300 ease-in-out">
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $teacher->user_id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                {{ $teacher->first_name }} {{ $teacher->middle_name }} {{ $teacher->surname }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $teacher->email }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $teacher->designation }}</td>
                            <td class="px-4 py-2 text-sm flex items-center space-x-2">
                                <!-- Show Button -->
                                <a href="{{ route('teachers.show', $teacher->id) }}"
                                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                                    View
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('teachers.edit', $teacher->id) }}"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                                    Edit
                                </a>

                                <!-- Delete Button (inside a form) -->
                                <form id="delete-form-{{ $teacher->id }}"
                                    action="{{ route('teachers.destroy', $teacher->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200"
                                        onclick="confirmDelete('delete-form-{{ $teacher->id }}')">
                                        Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $teachers->links() }}
        </div>
    </div>
</x-app-layout>