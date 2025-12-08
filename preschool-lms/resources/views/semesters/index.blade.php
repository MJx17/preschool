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

            <div x-data="{ search: '', semesterText: '', status: '' }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Filters -->
                <div class="mb-4 flex flex-col md:flex-row md:items-center gap-2">
                    <!-- Search Box -->
                    <input type="text" placeholder="Search semesters..."
                        class="w-full md:w-1/3 p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        x-model="search">

                    <!-- Semester Filter -->
                    <select x-model="semesterText"
                        class="w-full md:w-1/4 p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        <option value="">All Semesters</option>
                        @foreach($semesters->pluck('semester_text')->unique() as $semText)
                        <option value="{{ $semText }}">{{ $semText }}</option>
                        @endforeach
                    </select>

                    <!-- Status Filter -->
                    <select x-model="status"
                        class="w-full md:w-1/4 p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <!-- Semesters Table -->
                @if($semesters->count())
                <div class="overflow-x-auto">
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
                            <tr class="hover:bg-gray-50"
                                x-show="
                                            (!search || '{{ $semester->semester_text }}'.toLowerCase().includes(search.toLowerCase()))
                                            && (!semesterText || '{{ $semester->semester_text }}' === semesterText)
                                            && (!status || '{{ $semester->status }}' === status)
                                        ">
                                <td class="p-2 border">{{ $semester->semester_text ?? $semester->semester }}</td>
                                <td class="p-2 border">{{ $semester->start_date }}</td>
                                <td class="p-2 border">{{ $semester->end_date }}</td>
                                <td class="p-2 border">
                                    <span @class([ 'font-semibold px-2 py-1 rounded' , 'bg-green-100 text-green-800'=> $semester->status === 'active',
                                        'bg-yellow-100 text-yellow-800' => $semester->status === 'upcoming',
                                        'bg-red-100 text-red-800' => $semester->status === 'closed',
                                        ])>
                                        {{ $semester->semester }}
                                    </span>
                                </td>

                                <td class="p-2 border space-x-2">
                                    <a href="{{ route('semesters.edit', $semester->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition">Edit</a>
                                    <form id="delete-form-{{ $semester->id }}"
                                        action="{{ route('semesters.destroy', $semester->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
                                            onclick="confirmDelete('delete-form-{{ $semester->id }}')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 text-gray-500">No semesters available.</div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>