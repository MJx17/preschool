<!-- Student & Section Selection -->
<div x-data="studentSection()" x-init="init()" class="space-y-4">
    <h3 class="text-lg font-semibold text-blue-800 dark:text-white mb-4">Student & Section</h3>

    <!-- Student -->
    <select name="student_id" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
        <option value="" disabled>Select Student</option>
        @foreach($students as $student)
            @if($availableStudentIds->contains($student->id))
                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                    {{ $student->fullname }}
                </option>
            @endif
        @endforeach
    </select>

    <!-- Semester -->
    <select x-model="semester_id" name="semester_id" required @change="loadSections()"
        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
        <option value="" disabled>Select Semester</option>
        @foreach($semesters as $semester)
            <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                {{ $semester->semester }} Semester
            </option>
        @endforeach
    </select>

    <!-- Grade Level -->
    <select x-model="grade_level_id" name="grade_level_id" required @change="loadSections()"
        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
        <option value="" disabled>Select Grade Level</option>
        @foreach($gradeLevels as $level)
            <option value="{{ $level->id }}" {{ old('grade_level_id') == $level->id ? 'selected' : '' }}>
                {{ $level->name }}
            </option>
        @endforeach
    </select>

    <!-- Section -->
    <template x-if="sections.length">
        <select name="section_id" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="" disabled>Select Section</option>
            <template x-for="section in sections" :key="section.id">
                <option :value="section.id" 
                        x-text="`${section.name} (${section.enrollments_count}/${section.max_students})`"
                        :selected="section.id == @json(old('section_id') ?? '')"></option>
            </template>
        </select>
    </template>

    <template x-if="!sections.length && grade_level_id && semester_id">
        <p class="text-red-500 text-sm">No available sections for selected grade level and semester.</p>
    </template>

    <!-- Category -->
    <select name="category" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
        <option value="new" {{ old('category') == 'new' ? 'selected' : '' }}>New</option>
        <option value="old" {{ old('category') == 'old' ? 'selected' : '' }}>Old</option>
        <option value="shifter" {{ old('category') == 'shifter' ? 'selected' : '' }}>Shifter</option>
    </select>
</div>

<script>
function studentSection() {
    return {
        grade_level_id: @json(old('grade_level_id') ?? ''),
        semester_id: @json(old('semester_id') ?? ''),
        sections: [],
        async loadSections() {
            if (!this.grade_level_id || !this.semester_id) {
                this.sections = [];
                return;
            }

            try {
                const response = await fetch(`/api/sections?grade_level_id=${this.grade_level_id}&semester_id=${this.semester_id}`);
                const data = await response.json();
                this.sections = data; // [{id, name, enrollments_count, max_students}]
            } catch (error) {
                console.error('Error loading sections:', error);
                this.sections = [];
            }
        },
        init() {
            // Load sections if old values exist (after validation error)
            if (this.grade_level_id && this.semester_id) {
                this.loadSections();
            }
        }
    }
}
</script>
