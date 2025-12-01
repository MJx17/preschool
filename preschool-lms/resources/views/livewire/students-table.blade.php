<!-- resources/views/livewire/students-table.blade.php -->
<div>
    <div class="flex space-x-4 mb-4">
        <div>
            <label>Performance:</label>
            <select wire:model="performanceFilter" class="border rounded px-2 py-1">
                <option value="All">All</option>
                <option value="Excellent">Excellent</option>
                <option value="Good">Good</option>
                <option value="Average">Average</option>
            </select>
        </div>

        <div>
            <label>Status:</label>
            <select wire:model="statusFilter" class="border rounded px-2 py-1">
                <option value="All">All</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
    </div>

    <h3 class="text-lg font-bold mb-2">Students</h3>
    <ul>
        @foreach ($students as $student)
            <li>{{ $student['name'] }} — {{ $student['performance'] }}</li>
        @endforeach
    </ul>

    <h3 class="text-lg font-bold mt-6 mb-2">Detailed Students</h3>
    <ul>
        @foreach ($detailedStudents as $student)
            <li>{{ $student['name'] }} — {{ $student['status'] }}</li>
        @endforeach
    </ul>
</div>
