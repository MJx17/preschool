<div x-data="studentSection()" x-init="init()" class="space-y-4">

    <!-- Active Semester -->
    <div class="bg-white">
        <input type="text"
            value="{{ $activeSemester->dropdown_label ?? 'N/A' }}"
            disabled
            class="w-full p-3 border rounded bg-white-100 cursor-not-allowed">

        <!-- Hidden field needed for validation -->
        <input type="hidden" name="semester_id" value="{{ $activeSemester->id }}">
    </div>

    <!-- Student -->
    <!-- Student -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Student</label>
        <select name="student_id" required
            class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-500 @error('student_id') border-red-500 @enderror">
            <option value="" disabled selected>Select Student</option>
            @foreach($students as $student)
            @if($availableStudentIds->contains($student->id))
            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                {{ $student->fullname }}
            </option>
            @endif
            @endforeach
        </select>
        @error('student_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Grade Level -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Grade Level</label>
        <select x-model="grade_level_id" name="grade_level_id" required @change="loadSections()"
            class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-500 @error('grade_level_id') border-red-500 @enderror">
            <option value="" disabled>Select Grade Level</option>
            @foreach($gradeLevels as $level)
            <option value="{{ $level->id }}" {{ old('grade_level_id') == $level->id ? 'selected' : '' }}>
                {{ $level->name }}
            </option>
            @endforeach
        </select>
        @error('grade_level_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Section -->
    <div>
        <select name="section_id" required x-model="selectedSection" class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-500 @error('grade_level_id') border-red-500 @enderror">
            <option value="" disabled>Select Section</option>
            <template x-for="section in sections" :key="section.id">
                <option :value="section.id"
                    :selected="section.id == selectedSection"
                    x-text="`${section.name} (${section.enrollments_count}/${section.max_students})`">
                </option>
            </template>
        </select>
    </div>
    @error('section_id')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    <!-- Enrollment Category -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Enrollment Category</label>
        <select name="category" required
            class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-500 @error('category') border-red-500 @enderror">
            <option value="new" {{ old('category') == 'new' ? 'selected' : '' }}>New</option>
            <option value="old" {{ old('category') == 'old' ? 'selected' : '' }}>Old</option>
            <option value="shifter" {{ old('category') == 'shifter' ? 'selected' : '' }}>Shifter</option>
        </select>
        @error('category')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>

<script>
    function studentSection() {
        return {
            grade_level_id: @json(old('grade_level_id') ?? $selectedGradeLevelId ?? ''),
            sections: @json($sections ?? []),
            selectedSection: @json(old('section_id') ?? ''),

            async init() {
                // If grade level already selected, load sections
                if (this.grade_level_id) {
                    await this.loadSections();
                }
            },

            async loadSections() {
                if (!this.grade_level_id) {
                    this.sections = [];
                    this.selectedSection = '';
                    window.dispatchEvent(new CustomEvent('grade-changed', {
                        detail: null
                    }));
                    return;
                }

                try {
                    const response = await fetch(`/sections/grade/${this.grade_level_id}`);
                    const data = await response.json();
                    this.sections = data;

                    // Keep old selection if it exists in the new list
                    if (!this.sections.find(s => s.id == this.selectedSection)) {
                        this.selectedSection = '';
                    }

                    window.dispatchEvent(new CustomEvent('grade-changed', {
                        detail: this.grade_level_id
                    }));
                } catch (error) {
                    console.error('Error loading sections:', error);
                    this.sections = [];
                    this.selectedSection = '';
                    window.dispatchEvent(new CustomEvent('grade-changed', {
                        detail: null
                    }));
                }
            }
        }
    }
</script>