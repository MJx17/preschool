@extends('layouts.app')

@section('content')
<div class="max-w-full mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Attendance - Class A</h2>

    <!-- Hardcoded Month -->
    <p class="mb-2 font-medium">September 2025</p>

    <form method="POST" action="#">
        @csrf

        @php
            use Carbon\Carbon;
            use Carbon\CarbonPeriod;

            // Hardcoded students
            $students = ['John Doe', 'Jane Smith', 'Alice Brown'];

            // Generate all dates in September 2025
            $period = CarbonPeriod::create('2025-09-01', '2025-09-30');
            $dates = [];
            foreach ($period as $date) {
                $dates[] = $date->toDateString();
            }
        @endphp

        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-300 w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-1">Student</th>
                        @foreach($dates as $date)
                            <th class="border px-2 py-1 text-center">
                                {{ Carbon::parse($date)->format('d') }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td class="border px-2 py-1 font-medium">{{ $student }}</td>
                            @foreach($dates as $date)
                                <td class="border px-2 py-1 text-center">
                                    <select name="attendance[{{ $student }}][{{ $date }}]"
                                            class="border rounded p-1 text-xs">
                                        <option value="">-</option>
                                        <option value="present">P</option>
                                        <option value="absent">A</option>
                                        <option value="late">L</option>
                                    </select>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">
            Save Attendance
        </button>
    </form>
</div>
@endsection
