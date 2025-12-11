<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Subject Assignment
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-8 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 shadow sm:rounded-lg p-6">

            @if($errors->any())
            <div class="mb-6 text-red-600">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    @if($errors->has('duplicate'))
                    <li>{{ $errors->first('duplicate') }}</li>
                    @endif
                </ul>
            </div>
            @endif

            <form action="{{ route('subject_assignment.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Subject -->
                    <div>
                        <label class="block font-semibold mb-1">Subject</label>
                        <select name="subject_id" class="w-full border rounded p-2">
                            @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Semester -->
                    {{-- Semester --}}
                    <div>
                        <label for="semester_id" class="block text-sm font-medium text-gray-700">Semester</label>

                        {{-- Show semester name --}}
                        <input
                            type="text"
                            value="{{ $activeSemester->semester }}"
                            readonly
                            class="w-full p-2 border rounded bg-gray-100">

                        {{-- Actual value submitted --}}
                        <input
                            type="hidden"
                            name="semester_id"
                            value="{{ $activeSemester->id }}">
                    </div>


                    <!-- Teacher -->
                    <div>
                        <label class="block font-semibold mb-1">Teacher</label>
                        <select name="teacher_id" class="w-full border rounded p-2">
                            @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Section -->
                    <div>
                        <label class="block font-semibold mb-1">Section</label>
                        <select name="section_id" class="w-full border rounded p-2" required>
                            <option value="">Select Section</option>
                            @foreach ($sections as $section)
                            <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->name }} ({{ $section->gradeLevel->name }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Block -->
                    <div>
                        <label class="block font-semibold mb-1">Block</label>
                        <input type="text" name="block" value="{{ old('block') }}" class="w-full border rounded p-2">
                    </div>

                    <!-- Room -->
                    <div>
                        <label class="block font-semibold mb-1">Room</label>
                        <input type="text" name="room" value="{{ old('room') }}" class="w-full border rounded p-2">
                    </div>

                    <!-- Start Time -->
                    <div>
                        <label class="block font-semibold mb-1">Start Time</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full border rounded p-2">
                    </div>

                    <!-- End Time -->
                    <div>
                        <label class="block font-semibold mb-1">End Time</label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full border rounded p-2">
                    </div>

                    <!-- Days (full width) -->
                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-2">Days</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="days[]" value="{{ $day }}"
                                    {{ is_array(old('days')) && in_array($day, old('days')) ? 'checked' : '' }}
                                    class="form-checkbox">
                                <span>{{ $day }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                        Save Assignment
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>