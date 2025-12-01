<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add New Enrollment
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-12 px-6 sm:px-8 lg:px-10">
        <form action="{{ route('enrollments.store') }}" method="POST" class="space-y-6" x-data="{ activeTab: 'student' }">
            @csrf

            <!-- Tabs Navigation -->
            <div class="flex border-b mb-4 space-x-4">
                <button type="button" @click="activeTab='student'" :class="{'border-blue-500 text-blue-500': activeTab==='student'}" class="pb-2 border-b-2 font-medium">Student</button>
                <button type="button" @click="activeTab='fees'" :class="{'border-blue-500 text-blue-500': activeTab==='fees'}" class="pb-2 border-b-2 font-medium">Tuition & Fees</button>
                <button type="button" @click="activeTab='subjects'" :class="{'border-blue-500 text-blue-500': activeTab==='subjects'}" class="pb-2 border-b-2 font-medium">Subjects</button>
                <button type="button" @click="activeTab='financial'" :class="{'border-blue-500 text-blue-500': activeTab==='financial'}" class="pb-2 border-b-2 font-medium">Financial Info</button>
            </div>

            <!-- Tabs Content -->
            <div>
                <div x-show="activeTab==='student'">
                    <x-enrollment.student
                        :students="$students"
                        :available-student-ids="$availableStudentIds"
                        :semesters="$semesters"
                        :grade-levels="$gradeLevels"
                        :sections="$sections"
                        :old-data="old()" />
                </div>

                <div x-show="activeTab==='fees'">
                    <x-enrollment.fees :old-data="old()" />
                </div>

                <div x-show="activeTab==='subjects'">
                    <x-enrollment.subjects :subjects="$subjects ?? collect()" />
                </div>

                <div x-show="activeTab==='financial'">
                    <x-enrollment.financial :old-data="old()" :enrollment="null" />
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300">
                    Enroll Student
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
