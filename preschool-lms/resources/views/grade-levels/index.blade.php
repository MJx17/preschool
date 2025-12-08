<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Grade Levels') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('grade-levels.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
               + Add Grade Level
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($grades as $grade)
                        <tr>
                            <td class="px-6 py-4">{{ $grade->id }}</td>
                            <td class="px-6 py-4">{{ $grade->name }}</td>
                            <td class="px-6 py-4">{{ $grade->code }}</td>
                            <td class="px-6 py-4 flex space-x-2">
                                <a href="{{ route('grade-levels.edit', $grade->id) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Edit</a>

                                <form action="{{ route('grade-levels.destroy', $grade->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($grades->isEmpty())
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No grade levels found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
