<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Enrollment
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-12 px-6 sm:px-8 lg:px-10">

        <form action="{{ route('enrollments.update', $enrollment->id) }}"
            method="POST"
            x-data="{ activeTab: 'student' }"
            class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Tabs Navigation -->
            <div class="flex border-b mb-4 space-x-6">
                @foreach ([
                'student' => 'Student',
                'fees' => 'Tuition & Fees',
                'subjects' => 'Subjects',
                'financial' => 'Financial Info'
                ] as $tabKey => $tabLabel)
                <button
                    type="button"
                    @click="activeTab='{{ $tabKey }}'"
                    class="pb-2 border-b-2 font-medium"
                    :class="activeTab === '{{ $tabKey }}' 
                            ? 'border-blue-500 text-blue-500' 
                            : 'border-transparent text-gray-500'">
                    {{ $tabLabel }}
                </button>
                @endforeach
            </div>

            <!-- Tabs Content -->
            <div class="mt-6">

                <!-- Student Tab -->
                <!-- Student Tab -->
                <div x-show="activeTab === 'student'" x-cloak>
                    <x-enrollment.edit.student
                        :students="$students"
                        :active-semester="$activeSemester"
                        :grade-levels="$gradeLevels"
                        :sections="$sections"
                        :enrollment="$enrollment" />
                </div>

                <!-- Fees Tab -->
                <div x-show="activeTab === 'fees'" x-cloak>
                    <x-enrollment.edit.fees
                        :fee="$fee" />
                </div>

                <!-- Subjects Tab -->
                <div x-show="activeTab === 'subjects'" x-cloak>
                    <x-enrollment.edit.subjects
                        :subjects="$subjects"
                        :selected-subjects="$selectedSubjects" />
                </div>

                <!-- Financial Tab -->
                <div x-show="activeTab === 'financial'" x-cloak>
                    <x-enrollment.edit.financial
                        :enrollment="$financialData" />
                </div>

            </div>

            <!-- Submit -->
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300">
                    Update Enrollment
                </button>
            </div>

        </form>
    </div>
</x-app-layout>