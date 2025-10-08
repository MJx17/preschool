<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Semesters
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between">
                <a href="{{ route('semesters.create') }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                   Add New Semester
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($semesters->count())
                        <table class="w-full border border-gray-200 rounded">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-2 border">Semester</th>
                                    <th class="p-2 border">Start Date</th>
                                    <th class="p-2 border">End Date</th>
                                    <th class="p-2 border">Status</th>
                                    <th class="p-2 border">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semesters as $semester)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-2 border">{{ $semester->semester_text ?? $semester->semester }}</td>
                                    <td class="p-2 border">{{ $semester->start_date }}</td>
                                    <td class="p-2 border">{{ $semester->end_date }}</td>
                                    <td class="p-2 border">{{ ucfirst($semester->status) }}</td>
                                    <td class="p-2 border space-x-2">
                                        <a href="{{ route('semesters.edit', $semester->id) }}" class="text-yellow-500 hover:underline">Edit</a>
                                        <form action="{{ route('semesters.destroy', $semester->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-8 text-gray-500">No semesters available.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
