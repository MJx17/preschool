<div x-data="{ activeTab: 'subjects' }" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <!-- Student Info -->
    <div class="mb-4">
        <h2 class="font-semibold text-lg">{{ $student->full_name }}</h2>
        <p>{{ $student->grade_level_text }} | {{ $student->category_text }}</p>
        <p>Semester: <span x-text="selectedSemesterName"></span></p>
    </div>

    <!-- Tabs -->
    <div class="border-b mb-4">
        <nav class="-mb-px flex space-x-4">
            <button :class="{'border-blue-500': activeTab==='subjects'}" @click="activeTab='subjects'" class="tab-button">Subjects</button>
            <button :class="{'border-blue-500': activeTab==='fees'}" @click="activeTab='fees'" class="tab-button">Tuition & Fees</button>
            <button :class="{'border-blue-500': activeTab==='financial'}" @click="activeTab='financial'" class="tab-button">Financial Info</button>
        </nav>
    </div>

    <!-- Tab Contents -->
    <div>
        <div x-show="activeTab==='subjects'">
            <x-enrollment-subjects :subjects="$subjects" />
        </div>

        <div x-show="activeTab==='fees'">
            <x-enrollment-fees :enrollment="$enrollment" />
        </div>

        <div x-show="activeTab==='financial'">
            <x-enrollment-financial :enrollment="$enrollment" />
        </div>
    </div>
</div>
