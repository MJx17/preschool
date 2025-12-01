<!-- resources/views/components/enrollment/subjects.blade.php -->
<div class="space-y-2">
    <h3 class="text-lg font-semibold text-blue-800 dark:text-white">Subjects</h3>
    <p class="text-gray-500 dark:text-gray-400">
        Subjects will be automatically assigned based on the selected grade level and semester.
    </p>
    <ul class="list-disc list-inside mt-2">
        @if($subjects && $subjects->count())
            @foreach($subjects as $subject)
                <li>{{ $subject->subject->name }} ({{ $subject->subject->code }})</li>
            @endforeach
        @else
            <li class="text-gray-400">Select a grade level and semester to view subjects.</li>
        @endif
    </ul>
</div>
