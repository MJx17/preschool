<div x-data="subjectsTab()" x-show="activeTab === 'subjects'" x-cloak>
    <h3 class="text-lg font-semibold text-blue-800 dark:text-white">Subjects</h3>
    <p class="text-gray-500 dark:text-gray-400">
        Subjects will be automatically assigned based on the selected grade level and semester.
    </p>
    <ul class="list-disc list-inside mt-2">
        <template x-if="subjects.length">
            <template x-for="subject in subjects" :key="subject.id">
                <li x-text="subject.name + ' (' + subject.code + ')'"></li>
            </template>
        </template>
        <template x-if="!subjects.length">
            <li class="text-gray-400">Select a grade level in the Student tab to view subjects.</li>
        </template>
    </ul>

    <script>
        function subjectsTab() {
            return {
                // Preload subjects from server if available
                subjects: @json($subjects ?? []),

                init() {
                    // Listen for grade-changed events from the Student tab
                    window.addEventListener('grade-changed', event => {
                        this.fetchSubjects(event.detail);
                    });

                    // On page load, if subjects are preloaded, flatten grouped structure
                    if (this.subjects && this.subjects.length && this.subjects[0].subject) {
                        this.subjects = this.subjects.map(s => ({
                            id: s.subject.id,
                            name: s.subject.name,
                            code: s.subject.code,
                        }));
                    }
                },

                async fetchSubjects(gradeLevelId) {
                    if (!gradeLevelId) {
                        this.subjects = [];
                        return;
                    }

                    try {
                        const response = await fetch(`{{ route('get.subjects') }}?grade_level_id=${gradeLevelId}`);
                        const data = await response.json();

                        // Flatten grouped subjects if needed
                        let flatSubjects = [];
                        Object.values(data).forEach(group => {
                            flatSubjects = flatSubjects.concat(group.map(s => ({
                                id: s.id,
                                name: s.name,
                                code: s.code
                            })));
                        });

                        this.subjects = flatSubjects;
                    } catch (error) {
                        console.error('Error fetching subjects:', error);
                        this.subjects = [];
                    }
                }
            }
        }
    </script>
</div>
