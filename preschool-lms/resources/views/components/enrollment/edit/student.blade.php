<div x-data="studentSection()" x-init="init()" class="space-y-4">

    <!-- Active Semester -->
    <div class="bg-white">
        <input type="text"
               value="{{ $activeSemester->dropdown_label ?? 'N/A' }}"
               disabled
               class="w-full p-3 border rounded bg-gray-100 cursor-not-allowed">
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
                @change="window.dispatchEvent(new CustomEvent('section-changed', { detail: selectedSection }))"
                class="w-full p-3 border rounded">
            <option value="" disabled>Select Section</option>
            <template x-for="section in sections" :key="section.id">
                <option :value="section.id"
                        x-text="`${section.name} (${section.enrollments_count}/${section.max_students})`">
                </option>
            </template>
        </select>
        @error('section_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Enrollment Category -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Enrollment Category</label>
        <select x-model="category"
                name="category"
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
        // Pre-fill grade level, section, and category from backend
        grade_level_id: @json(old('grade_level_id') ?? $enrollment->grade_level_id),
        sections: @json($sections ?? []),
        selectedSection: @json(old('section_id') ?? $enrollment->section_id),
        category: @json(old('category') ?? $enrollment->category),

        async init() {
            // Only load sections dynamically if no backend sections are provided
            if (!this.sections.length && this.grade_level_id) {
                await this.loadSections();
            }
        },

        async loadSections() {
            if (!this.grade_level_id) {
                this.sections = [];
                this.selectedSection = null;
                this.fireSectionChanged();
                return;
            }

            try {
                const response = await fetch(`/sections/grade/${this.grade_level_id}`);
                const data = await response.json();
                this.sections = data;

                // Keep current selection if it exists; otherwise pick first available
                if (!this.sections.find(s => s.id == this.selectedSection)) {
                    this.selectedSection = this.sections.length ? this.sections[0].id : null;
                }

                this.fireSectionChanged();

            } catch (error) {
                console.error('Error loading sections:', error);
                this.sections = [];
                this.selectedSection = null;
                this.fireSectionChanged();
            }
        },

        fireSectionChanged() {
            window.dispatchEvent(new CustomEvent('section-changed', {
                detail: this.selectedSection
            }));
        }
    }
}
</script>
