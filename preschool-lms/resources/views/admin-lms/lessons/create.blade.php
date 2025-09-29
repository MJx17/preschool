@extends('admin-lms.layouts.admin')

@section('title', 'Add Lesson')
@section('page-title', '➕ Add Lesson')

@section('content')
<form action="{{ route('admin-lms.lessons.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
    @csrf

    <!-- Lesson Title -->
    <div>
        <label class="block font-medium text-gray-700">Title</label>
        <input type="text" name="title" class="w-full border p-2 rounded" required>
    </div>

    <!-- Class Selection -->
    <div>
        <label class="block font-medium text-gray-700">Class</label>
        <select name="class_id" class="w-full border p-2 rounded" required>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- File Upload -->
    <div>
        <label class="block font-medium text-gray-700">File (PDF/PPT)</label>
        <input type="file" name="file" accept=".pdf,.ppt,.pptx" class="w-full border p-2 rounded" required>
    </div>

    <!-- Quiz Section -->
    <div id="quiz-section">
        <h3 class="font-semibold mb-2">Quiz</h3>
        <div class="quiz-item bg-gray-50 p-4 rounded shadow mb-4">
            <label class="font-medium">Question</label>
            <input type="text" name="quiz[0][question]" placeholder="Enter question" class="border p-2 rounded w-full mb-2" required>

            <div class="space-y-2">
                <input type="text" name="quiz[0][options][]" placeholder="Option 1" class="border p-2 rounded w-full" required>
                <input type="text" name="quiz[0][options][]" placeholder="Option 2" class="border p-2 rounded w-full" required>
                <input type="text" name="quiz[0][options][]" placeholder="Option 3" class="border p-2 rounded w-full" required>
            </div>

            <label class="block mt-2 font-medium">Answer</label>
            <input type="text" name="quiz[0][answer]" placeholder="Correct answer" class="border p-2 rounded w-full" required>
        </div>
    </div>

    <button type="button" id="add-quiz" class="bg-gray-200 px-3 py-1 rounded">Add Another Question</button>

    <div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded mt-4">Save Lesson</button>
    </div>
</form>

<script>
let quizIndex = 1;
document.getElementById('add-quiz').addEventListener('click', () => {
    const container = document.getElementById('quiz-section');
    const div = document.createElement('div');
    div.classList.add('quiz-item', 'bg-gray-50', 'p-4', 'rounded', 'shadow', 'mb-4');
    div.innerHTML = `
        <label class="font-medium">Question</label>
        <input type="text" name="quiz[${quizIndex}][question]" placeholder="Enter question" class="border p-2 rounded w-full mb-2" required>

        <div class="space-y-2">
            <input type="text" name="quiz[${quizIndex}][options][]" placeholder="Option 1" class="border p-2 rounded w-full" required>
            <input type="text" name="quiz[${quizIndex}][options][]" placeholder="Option 2" class="border p-2 rounded w-full" required>
            <input type="text" name="quiz[${quizIndex}][options][]" placeholder="Option 3" class="border p-2 rounded w-full" required>
        </div>

        <label class="block mt-2 font-medium">Answer</label>
        <input type="text" name="quiz[${quizIndex}][answer]" placeholder="Correct answer" class="border p-2 rounded w-full" required>
    `;
    container.appendChild(div);
    quizIndex++;
});
</script>
@endsection
