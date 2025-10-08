<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Edit Subject Assignment</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-12 px-6">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <form action="/subject_assignment/{{ $subject_assignment->id }}/update" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                {{-- Subject --}}
                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700">Subject</label>
                    <select name="subject_id" id="subject_id" required class="w-full p-2 border rounded">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $subject_assignment->subject_id == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Semester --}}
                <div>
                    <label for="semester_id" class="block text-sm font-medium text-gray-700">Semester</label>
                    <select name="semester_id" id="semester_id" required class="w-full p-2 border rounded">
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ $subject_assignment->semester_id == $semester->id ? 'selected' : '' }}>
                                {{ $semester->semester }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Teacher --}}
                <div>
                    <label for="teacher_id" class="block text-sm font-medium text-gray-700">Teacher</label>
                    <select name="teacher_id" id="teacher_id" required class="w-full p-2 border rounded">
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ $subject_assignment->teacher_id == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user->name ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Block --}}
                <div>
                    <label for="block" class="block text-sm font-medium text-gray-700">Block</label>
                    <input type="text" name="block" id="block" value="{{ $subject_assignment->block }}" required
                           class="w-full p-2 border rounded">
                </div>

                {{-- Room --}}
                <div>
                    <label for="room" class="block text-sm font-medium text-gray-700">Room</label>
                    <input type="text" name="room" id="room" value="{{ $subject_assignment->room }}" required
                           class="w-full p-2 border rounded">
                </div>

                {{-- Days --}}
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Days</label>
                    <div class="flex flex-wrap gap-4">
                        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="days[]" value="{{ $day }}" class="rounded border-gray-300"
                                       {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                                <span>{{ $day }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Start Time --}}
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                    <input type="time" name="start_time" id="start_time" value="{{ $subject_assignment->start_time }}" required
                           class="w-full p-2 border rounded">
                </div>

                {{-- End Time --}}
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                    <input type="time" name="end_time" id="end_time" value="{{ $subject_assignment->end_time }}" required
                           class="w-full p-2 border rounded">
                </div>

                {{-- Submit Buttons --}}
                <div class="col-span-1 md:col-span-2 flex justify-end gap-4 mt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                        Update
                    </button>
                    <a href="{{ route('subject_assignment.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-medium py-2 px-4 rounded">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
