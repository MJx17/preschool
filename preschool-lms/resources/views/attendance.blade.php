<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Calendar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-6xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6">Attendance - September 2025</h2>

    @php
        use Carbon\Carbon;
        use Carbon\CarbonPeriod;

        $month = '2025-09';
        $start = Carbon::parse($month . '-01');
        $end = $start->copy()->endOfMonth();
        $period = CarbonPeriod::create($start, $end);

        // Hardcoded students
        $students = ['John Doe', 'Jane Smith', 'Alice Brown', 'Mark Borja', 'Sarah Cruz'];
    @endphp

    <!-- Calendar -->
    <div class="grid grid-cols-7 gap-2 mb-6">
        <!-- Weekday Labels -->
        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
            <div class="text-center font-semibold">{{ $day }}</div>
        @endforeach

        <!-- Empty slots before first day -->
        @for($i = 0; $i < $start->dayOfWeek; $i++)
            <div></div>
        @endfor

        <!-- Days -->
        @foreach($period as $date)
            <div class="bg-white shadow p-2 text-center cursor-pointer hover:bg-blue-100 rounded"
                 onclick="showAttendance('{{ $date->toDateString() }}')">
                {{ $date->format('d') }}
            </div>
        @endforeach
    </div>

    <!-- Attendance Section -->
    <div id="attendanceSection" class="hidden bg-white p-6 rounded shadow">
        <h3 class="text-xl font-bold mb-4">Mark Attendance for <span id="attendanceDate"></span></h3>

        <form method="POST" action="#">
            @csrf
            <input type="hidden" id="attendance_date" name="attendance_date">

            <div class="space-y-2 max-h-96 overflow-y-auto">
                @foreach($students as $student)
                    <div class="flex justify-between items-center border-b pb-2">
                        <span>{{ $student }}</span>
                        <select name="attendance[{{ $student }}]" class="border rounded p-1 text-sm">
                            <option value="">-</option>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="late">Late</option>
                        </select>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Save Attendance
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showAttendance(date) {
        document.getElementById('attendance_date').value = date;
        document.getElementById('attendanceDate').innerText = date;
        document.getElementById('attendanceSection').classList.remove('hidden');
        document.getElementById('attendanceSection').scrollIntoView({ behavior: 'smooth' });
    }
</script>
</body>
</html>
