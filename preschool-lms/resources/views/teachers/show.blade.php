<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Teacher Details
        </h2>
    </x-slot>

    <div class="container mx-auto py-8 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Section: Teacher Profile -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center text-center border-l-4 border-blue-500 lg:col-span-1 h-fit">
                <div class="w-24 h-24 bg-indigo-500 text-white flex items-center justify-center rounded-full text-3xl mb-4 shadow-lg">
                    🎓
                </div>
                <h1 class="text-xl font-bold text-gray-900">{{ $teacher->first_name }} {{ $teacher->surname }}</h1>
                <p class="text-gray-500 text-sm">{{ $teacher->designation }}</p>

                <div class="mt-4 text-gray-700 text-left w-full space-y-2">
                    <p class="flex items-center">
                        📧 <span class="ml-2 text-sm">{{ $teacher->email }}</span>
                    </p>
                    <p class="flex items-center">
                        📞 <span class="ml-2 text-sm">{{ $teacher->contact_number }}</span>
                    </p>
                </div>
            </div>

            <!-- Right Section: Subject Offerings -->
            <div class="lg:col-span-2 bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4">📚 Assigned Subjects (Current Semester)</h3>

                <div x-data="{ search: '', section: '' }" class="space-y-4">
                    <!-- Filters -->
                    <div class="flex gap-2">
                        <input type="text"
                            placeholder="Search subjects..."
                            class="flex-1 p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                            x-model="search" />

                        <select x-model="section"
                            class="p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                            <option value="">All Sections</option>
                            @foreach($subjectOfferings->pluck('section.name')->unique() as $sec)
                            <option value="{{ $sec }}">{{ $sec }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject Offerings Table -->
                    <div class="overflow-x-auto h-[500px] overflow-y-auto scrollbar-hide">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-200 text-left">
                                <tr>
                                    <th class="px-4 py-2">Code</th>
                                    <th class="px-4 py-2">Subject</th>
                                    <th class="px-4 py-2">Section</th>
                                    <th class="px-4 py-2">Students</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subjectOfferings as $offering)
                                <tr class="bg-white hover:bg-gray-200 border-b"
                                    x-show="
                                            ($el.textContent.toLowerCase().includes(search.toLowerCase()))
                                            && (!section || '{{ $offering->section->name }}' === section)
                                        ">
                                    <td class="px-4 py-2 font-semibold">{{ $offering->subject->code }}</td>
                                    <td class="px-4 py-2 font-semibold">{{ $offering->subject->name }}</td>
                                    <td class="px-4 py-2 font-semibold">{{ $offering->section->name }}</td>
                                    <td class="px-4 py-2 text-center">{{ $offering->enrollmentSubjectOfferings->count() }}</td>
                                    <td class="px-4 py-2 flex gap-2">
                                        <!-- Show Students Modal -->
                                        <div x-data="{ open: false, searchStudent: '' }">
                                            <button @click="open = true"
                                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                                Show Students
                                            </button>

                                            <div x-show="open"
                                                class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                                                <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
                                                    <button @click="open = false"
                                                        class="absolute top-2 right-2 px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                                        ✕
                                                    </button>

                                                    <h2 class="text-xl font-bold mb-4">Enrolled Students</h2>
                                                    <input type="text" placeholder="Search students..."
                                                        class="w-full p-2 border rounded mb-2"
                                                        x-model="searchStudent" />

                                                    <ul class="max-h-60 overflow-y-auto border p-2 rounded">
                                                        @foreach($offering->enrollmentSubjectOfferings as $eso)
                                                        <li class="py-2 px-3 border-b text-gray-800"
                                                            x-show="$el.textContent.toLowerCase().includes(searchStudent.toLowerCase())">
                                                            {{ $eso->enrollment->student->fullname }}
                                                        </li>
                                                        @endforeach
                                                    </ul>

                                                    <button @click="open = false"
                                                        class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 w-full">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    <td class="px-4 py-2 flex gap-2">
                                        <!-- View Grades Button -->
                                        <a href="{{ route('teachers.viewGrades', $offering->id) }}"
                                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                            View Grades
                                        </a>

                                        <!-- Edit Grades Button -->
                                        <a href="{{ route('teachers.grade_students', $offering->id) }}"
                                            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                            Edit Grades
                                        </a>
                                    </td>


                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>