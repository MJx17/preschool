<div x-data="studentSection()" x-init="init()" class="space-y-4">

    <!-- Active Semester -->
    <div class="bg-white">
        <input type="text"
            value="{{ $activeSemester->dropdown_label ?? 'N/A' }}"
            disabled
            class="w-full p-3 border rounded bg-gray-100 cursor-not-allowed">
        <input type="hidden" name="semester_id" value="{{ $activeSemester->id }}">
    </div>

    <!-- Student (locked for edit) -->
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
        <select x-model="grade_level_id" name="grade_level_id" required @change="loadSections()"
            class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-500">
            <option value="" disabled>Select Grade Level</option>
            @foreach($gradeLevels as $level)
            <option value="{{ $level->id }}">{{ $level->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Section -->
    <div>
        <select name="section_id" required
            x-model="selectedSection"
            x-ref="sectionSelect"
            @change="$dispatch('section-changed', selectedSection)"
            class="w-full p-3 border rounded">
            <option value="" disabled>Select Section</option>
            <template x-for="section in sections" :key="section.id">
                <option :value="section.id"
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
        <select name="category" required x-model="category"
            class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-500">
            <option value="new">New</option>
            <option value="old">Old</option>
            <option value="shifter">Shifter</option>
        </select>
    </div>

</div>

<script>
    function studentSection() {
        return {
            grade_level_id: @json($selectedGradeLevelId ?? ''),
            selectedSection: '',
            category: @json(old('category') ?? $enrollment -> category),
            sections: [],

            init() {
                if (this.grade_level_id) {
                    this.loadSections();
                }
            },

            async loadSections() {
                if (!this.grade_level_id) {
                    this.sections = [];
                    this.selectedSection = '';
                    return;
                }

                try {
                    const res = await fetch(`/sections/grade/${this.grade_level_id}`);
                    const data = await res.json();

                    this.sections = data.filter(s => s.enrollments_count < s.max_students);

                    // Pick first available section if none selected
                    if (!this.selectedSection && this.sections.length) {
                        this.selectedSection = this.sections[0].id;
                    }

                } catch (err) {
                    console.error('Error loading sections:', err);
                    this.sections = [];
                    this.selectedSection = '';
                }
            }
        }
    }
</script>