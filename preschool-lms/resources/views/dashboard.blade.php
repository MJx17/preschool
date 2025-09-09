<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">

            {{-- Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-dashboard.stat-card title="Users" value="1,245" subtitle="+120 this month" color="indigo">
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a7 7 0 00-14 0v2h5m0-4a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </x-slot>
                </x-dashboard.stat-card>

                <x-dashboard.stat-card title="Courses" value="56" subtitle="5 new this week" color="green">
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5 12.083 12.083 0 015.84 10.578L12 14z" />
                        </svg>
                    </x-slot>
                </x-dashboard.stat-card>

                <x-dashboard.stat-card title="Attendance" value="92%" subtitle="Stable from last month" color="yellow">
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6a9 9 0 100 18 9 9 0 000-18z" />
                        </svg>
                    </x-slot>
                </x-dashboard.stat-card>

                <x-dashboard.stat-card title="Reports" value="14" subtitle="3 pending review" color="red">
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2h6v2m-6-8h6v6H9V9z" />
                        </svg>
                    </x-slot>
                </x-dashboard.stat-card>
            </div>


            <div class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-12">

                {{-- Row 1: 2 equal columns --}}
                <div class="col-span-12 md:col-span-6">
                    <x-dashboard.chart-card
                        title="Attendance Trend"
                        id="attendanceChart"
                        type="line"
                        :labels="$months"
                        :datasets="$attendanceDatasets" />
                </div>
                <div class="col-span-12 md:col-span-6">
                    <x-dashboard.chart-card
                        title="Reports by Status"
                        id="reportsChart"
                        type="bar"
                        :labels="$months"
                        :datasets="$attendanceDatasets" />
                </div>


                <div class="col-span-12 md:col-span-4 flex flex-col gap-6 max-h-300px]">
                    <x-dashboard.chart-card
                        title="Gender Distribution"
                        id="genderChart"
                        type="pie"
                        :labels="$genderLabels"
                        :datasets="$genderDatasets"
                        class="flex-1 overflow-hidden" />

                    <x-dashboard.chart-card
                        title="Grade Levels"
                        id="gradeChart"
                        type="doughnut"
                        :labels="$gradeLabels"
                        :datasets="$gradeDatasets"
                        class="flex-1 overflow-hidden" />
                </div>
                <div class="col-span-12 md:col-span-8 ">
                    <x-dashboard.table-card title="Student Performance">
                        {{-- Filter radios --}}
                        {{-- Filter radios --}}
                        <form method="GET" id="performanceFilterForm" class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                            <h4 class="font-semibold text-gray-700 mb-2 sm:mb-0">Filter by Performance:</h4>

                            <div class="flex flex-wrap gap-2 mb-4">
                                @php
                                $filters = ['All', 'Excellent', 'Good', 'Average'];
                                @endphp
                                @foreach($filters as $f)
                                <label class="relative cursor-pointer">
                                    <input
                                        type="radio"
                                        name="performance"
                                        value="{{ $f }}"
                                        class="sr-only peer filter-radio"
                                        onchange="document.getElementById('performanceFilterForm').submit()"
                                        {{ ($filter === $f) ? 'checked' : '' }}>
                                    <span class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 
                                                hover:bg-indigo-50 hover:text-indigo-700 transition 
                                                peer-checked:bg-indigo-600 peer-checked:text-white
                                                peer-checked:border-indigo-600">
                                        {{ $f }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </form>


                        {{-- Student table --}}
                        <div class="col-span-12 md:col-span-8 max-h-[600px] overflow-auto">
                            <table class="min-w-full text-sm text-left border-collapse">
                                <thead class="bg-gray-100 uppercase text-gray-600 text-xs font-medium">
                                    <tr>
                                        <th class="px-4 py-3">
                                            <input type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 rounded">
                                        </th>
                                        <th class="px-4 py-3">Name</th>
                                        <th class="px-4 py-3">Grade</th>
                                        <th class="px-4 py-3">Performance</th>
                                        <th class="px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($paginatedStudents as $student)
                                    <tr data-performance="{{ $student['performance'] }}" class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <input type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 rounded">
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-800">{{ $student['name'] }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $student['grade'] }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $student['performance'] === 'Excellent' ? 'bg-green-100 text-green-800' : ($student['performance'] === 'Good' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ $student['performance'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex flex-col sm:flex-row justify-center items-center gap-2">
                                                <!-- Edit button -->
                                                <button class="flex items-center gap-2 px-3 py-1 text-blue-600 hover:bg-blue-50 rounded-md" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                    <span>Edit</span>
                                                </button>

                                                <!-- Delete button -->
                                                <button class="flex items-center gap-2 px-3 py-1 text-red-600 hover:bg-red-50 rounded-md" title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                    <span>Delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $paginatedStudents->links() }}
                        </div>
                    </x-dashboard.table-card>



                </div>

                {{-- Row 3: full-width --}}
                <div class="col-span-12">
                    {{-- Filter radios --}}
                    <x-dashboard.table-card>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                            <h4 class="font-semibold text-gray-700 mb-2 sm:mb-0">Filter by Status:</h4>

                            <div class="flex flex-wrap gap-2 mb-4">
                                @php
                                $statuses = ['All', 'Active', 'Inactive'];
                                @endphp
                                @foreach($statuses as $status)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="status_filter" value="{{ $status }}"
                                        class="sr-only peer filter-radio"
                                        onchange="window.location='?status='+this.value"
                                        {{ $filteredData === $status ? 'checked' : '' }}>
                                    <span class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 
                                        hover:bg-indigo-50 hover:text-indigo-700 transition 
                                        peer-checked:bg-indigo-600 peer-checked:text-white
                                        peer-checked:border-indigo-600">
                                        {{ $status }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Student Table --}}
                        <div class="col-span-12 md:col-span-12 max-h-[600px] overflow-auto x">
                            <table class="min-w-full text-sm text-left border-collapse">
                                <thead class="bg-gray-100 uppercase text-gray-600 text-xs font-medium">
                                    <tr>
                                        <th class="px-4 py-3">Name</th>
                                        <th class="px-4 py-3">Email</th>
                                        <th class="px-4 py-3">Phone</th>
                                        <th class="px-4 py-3">DOB</th>
                                        <th class="px-4 py-3">Grade</th>
                                        <th class="px-4 py-3">Enrollment Date</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Guardian</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($paginatedStudentsData as $studentData)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-800">{{ $studentData['name'] }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $studentData['email'] }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $studentData['phone'] }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $studentData['dob'] }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $studentData['grade'] }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $studentData['enrollment_date'] }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold 
                        {{ $studentData['status'] === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $studentData['status'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">{{ $studentData['guardian'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $paginatedStudents->links() }}
                        </div>

                </div>


            </div>
            </x-dashboard.table-card>

        </div>
    </div>

    {{-- ApexCharts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll("canvas[data-type]").forEach((canvas) => {
                const ctx = canvas.getContext("2d");

                const type = canvas.dataset.type || "bar";
                const labels = JSON.parse(canvas.dataset.labels || "[]");
                const datasets = JSON.parse(canvas.dataset.datasets || "[]");

                new Chart(ctx, {
                    type: type,
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    },
                });
            });
        });
    </script>

    <script>
        document.querySelectorAll('.filter-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const value = this.value;
                document.querySelectorAll('#studentTable tbody tr').forEach(row => {
                    if (value === 'All' || row.dataset.performance === value) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>




</x-app-layout>