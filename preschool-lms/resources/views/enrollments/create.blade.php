<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add New Enrollment
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-12 px-6 sm:px-8 lg:px-10">
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg p-8">
            <form action="{{ route('enrollments.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @csrf

                <!-- Student & Semester Selection -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-blue-800 dark:text-white">Student & Enrollment</h3>

                    <select name="student_id" required
                        class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled>Select Student</option>
                        @foreach($students as $student)
                            @if($availableStudentIds->contains($student->id))
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->fullname }}
                                </option>
                            @endif
                        @endforeach
                    </select>

                    <select name="semester_id" required
                        class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled>Select Semester</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                {{ $semester->semester }} Semester
                            </option>
                        @endforeach
                    </select>

                    <select name="grade_level" required
                        class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled>Select Grade Level</option>
                        @foreach($gradeLevels as $level)
                            <option value="{{ $level }}" {{ old('grade_level') == $level ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $level)) }}
                            </option>
                        @endforeach
                    </select>

                    <select name="category" required
                        class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="new" {{ old('category') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="old" {{ old('category') == 'old' ? 'selected' : '' }}>Old</option>
                    </select>
                </div>

                <!-- Tuition & Fees -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-blue-800 dark:text-white">Tuition & Fees</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <input type="number" name="tuition_fee" placeholder="Tuition Fee"
                            class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500"
                            value="{{ old('tuition_fee') }}" required>
                        <input type="number" name="lab_fee" placeholder="Lab Fee"
                            class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500"
                            value="{{ old('lab_fee') }}">
                        <input type="number" name="miscellaneous_fee" placeholder="Miscellaneous Fee"
                            class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500"
                            value="{{ old('miscellaneous_fee') }}">
                        <input type="number" name="other_fee" placeholder="Other Fee"
                            class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500"
                            value="{{ old('other_fee') }}">
                        <input type="number" name="discount" placeholder="Discount"
                            class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500"
                            value="{{ old('discount') }}">
                        <input type="number" name="initial_payment" placeholder="Initial Payment"
                            class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500"
                            value="{{ old('initial_payment') }}">
                    </div>
                </div>

                <!-- Subjects Section -->
                <div id="subjects-container" class="col-span-1 md:col-span-2 rounded-lg mt-3">
                    <h3 class="text-lg font-semibold text-blue-800 dark:text-white">Subjects</h3>
                    <p class="text-gray-500 dark:text-gray-400">
                        Subjects will appear here after selecting grade level and semester.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2" id="subjects-list"></div>
                </div>

                <!-- Financial Information -->
                <div class="col-span-1 md:col-span-2 mt-4">
                    @include('partials.financial-edit')
                </div>

                <!-- Submit -->
                <div class="col-span-1 md:col-span-2 flex justify-end gap-4 mt-6">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300">
                        Enroll Student
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const semesterSelect = document.querySelector('select[name="semester_id"]');
            const gradeLevelSelect = document.querySelector('select[name="grade_level"]');
            const subjectsList = document.getElementById('subjects-list');

            function fetchSubjects() {
                const semesterId = semesterSelect.value;
                const gradeLevel = gradeLevelSelect.value;

                if (!semesterId || !gradeLevel) {
                    subjectsList.innerHTML = '';
                    return;
                }

                fetch(`{{ route('get.subjects') }}?semester_id=${semesterId}&grade_level=${gradeLevel}`)
                    .then(res => res.json())
                    .then(data => {
                        subjectsList.innerHTML = '';
                        if (Object.keys(data).length === 0) {
                            subjectsList.innerHTML = '<p class="text-gray-500 dark:text-gray-400">No subjects available.</p>';
                        } else {
                            Object.keys(data).forEach(year => {
                                const yearContainer = document.createElement('div');
                                yearContainer.className = 'border p-4 rounded-lg bg-white dark:bg-gray-900 shadow';

                                const yearHeader = document.createElement('h3');
                                yearHeader.textContent = year.replace('_', ' ').toUpperCase();
                                yearHeader.className = 'text-lg font-semibold mb-2';
                                yearContainer.appendChild(yearHeader);

                                const subjectList = document.createElement('div');
                                subjectList.className = 'flex flex-col gap-2';

                                data[year].forEach(subject => {
                                    const label = document.createElement('label');
                                    label.className = 'flex items-center justify-between w-full';

                                    const span = document.createElement('span');
                                    span.textContent = subject.name;

                                    const checkbox = document.createElement('input');
                                    checkbox.type = 'checkbox';
                                    checkbox.name = 'subjects[]';
                                    checkbox.value = subject.id;
                                    checkbox.className = 'form-checkbox';

                                    label.appendChild(span);
                                    label.appendChild(checkbox);
                                    subjectList.appendChild(label);
                                });

                                yearContainer.appendChild(subjectList);
                                subjectsList.appendChild(yearContainer);
                            });
                        }
                    })
                    .catch(err => console.error(err));
            }

            semesterSelect.addEventListener('change', fetchSubjects);
            gradeLevelSelect.addEventListener('change', fetchSubjects);
        });
    </script>
</x-app-layout>
