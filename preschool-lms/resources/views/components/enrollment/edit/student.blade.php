<div x-data="studentSection()" x-init="init()" class="space-y-4">

    <!-- Active Semester -->
    <div class="bg-white">
        <input type="text"
               value="{{ $activeSemester->dropdown_label ?? 'N/A' }}"
               disabled
               class="w-full p-3 border rounded bg-white-100 cursor-not-allowed">
        <input type="hidden" name="semester_id" value="{{ $activeSemester->id }}">
    </div>

    <!-- Student (disabled for edit) -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Student</label>
        <input type="text"
               value="{{ $enrollment->student->fullname }}"
               disabled
               class="w-full p-3 border rounded bg-gray-100 cursor-not-allowed">
        <input type="hidden" name="student_id" value="{{ $enrollment->student_id }}">
    </div>

    <!-- Grade Level -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Grade Level</label>
        <select x-model="grade_level_id"
                name="grade_level_id"
                required
                @change="loadSections()"
                class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-500">
            <option value="" disabled>Select Grade Level</option>
            @foreach($gradeLevels as $level)
                <option value="{{ $level->id }}"
                        {{ $level->id == $enrollment->grade_level_id ? 'selected' : '' }}>
                    {{ $level->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Section -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Section</label>
        <select name="section_id"
                required
                x-model="selectedSection"
                class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-500">
            <option value="" disabled>Select Section</option>

            <template x-for="section in sections" :key="section.id">
                <option :value="section.id"
                        :selected="section.id == selectedSection"
                        x-text="`${section.name} (${section.enrollments_count}/${section.max_students})`">
                </option>
            </template>

        </select>
    </div>

    <!-- Enrollment Category -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Enrollment Category</label>
        <select name="category"
                required
                class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-500">
            <option value="new" {{ $enrollment->category == 'new' ? 'selected' : '' }}>New</option>
            <option value="old" {{ $enrollment->category == 'old' ? 'selected' : '' }}>Old</option>
            <option value="shifter" {{ $enrollment->category == 'shifter' ? 'selected' : '' }}>Shifter</option>
        </select>
    </div>

</div>

<script>
function studentSection() {
    return {
        grade_level_id: @json($enrollment->grade_level_id),
        sections: @json($sections), // only the filtered sections
        selectedSection: @json($enrollment->section_id),

        init() {
            // no fetch initially, sections already loaded
        },

        async loadSections() {
            if (!this.grade_level_id) {
                this.sections = [];
                this.selectedSection = '';
                return;
            }

            try {
                const response = await fetch(`/sections/grade/${this.grade_level_id}`);
                const data = await response.json();

                // Replace sections entirely with new grade sections
                // Only keep current selectedSection if it exists
                const currentSection = this.sections.find(s => s.id == this.selectedSection);
                this.sections = data;

                if (currentSection && !this.sections.some(s => s.id == currentSection.id)) {
                    // Append current section if it's no longer in new list (for edit safety)
                    this.sections.push(currentSection);
                }

                // Reset selectedSection if it no longer exists
                if (!this.sections.some(s => s.id == this.selectedSection)) {
                    this.selectedSection = '';
                }

            } catch (error) {
                console.error(error);
                this.sections = [];
                this.selectedSection = '';
            }
        }
    }
}
</script>
