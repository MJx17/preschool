<!-- Subjects Tab -->
<div x-data="subjectsTab()" x-show="activeTab === 'subjects'" x-cloak class="space-y-4">
    <h3 class="text-lg font-semibold text-blue-800 dark:text-white">Subjects</h3>
    <p class="text-gray-500 dark:text-gray-400">
        Subjects will be automatically assigned based on the selected section and semester.
    </p>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 border-b">Code</th>
                    <th class="px-4 py-2 border-b">Subject</th>
                    <th class="px-4 py-2 border-b">Units</th>
                    <th class="px-4 py-2 border-b">Days</th>
                    <th class="px-4 py-2 border-b">Time</th>
                    <th class="px-4 py-2 border-b">Room</th>
                    <th class="px-4 py-2 border-b">Teacher</th>
                </tr>
            </thead>
            <tbody>
                <template x-if="subjects.length">
                    <template x-for="subject in subjects" :key="subject.id">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 border-b" x-text="subject.subject_code"></td>
                            <td class="px-4 py-2 border-b" x-text="subject.subject_name"></td>
                            <td class="px-4 py-2 border-b" x-text="subject.units ?? 1"></td>
                            <td class="px-4 py-2 border-b" x-text="subject.days"></td>
                            <td class="px-4 py-2 border-b" x-text="subject.start_time + ' - ' + subject.end_time"></td>
                            <td class="px-4 py-2 border-b" x-text="subject.room ?? 'N/A'"></td>
                            <td class="px-4 py-2 border-b" x-text="subject.teacher_name"></td>
                        </tr>
                    </template>
                </template>
                <template x-if="!subjects.length">
                    <tr>
                        <td colspan="7" class="text-gray-400 text-center py-4">
                            Select a section in the Student tab to view subjects.
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <script>
        function subjectsTab() {
            return {
                // Preload subjects and selected subjects from backend for edit
                subjects: @json($subjects ?? []),

                init() {
                    window.addEventListener('section-changed', event => {
                        this.fetchSubjects(event.detail);
                    });
                },

                async fetchSubjects(sectionId) {
                    if (!sectionId) {
                        this.subjects = [];
                        return;
                    }

                    const semesterId = document.querySelector('input[name="semester_id"]').value;

                    try {
                        const response = await fetch(`{{ route('get.subjects') }}?section_id=${sectionId}&semester_id=${semesterId}`);
                        const data = await response.json();

                        this.subjects = data;

                    } catch (error) {
                        console.error('Error fetching subjects:', error);
                        this.subjects = [];
                    }
                }
            }
        }
    </script>
</div>
