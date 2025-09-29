@props(['quiz'])

<div 
    x-show="openQuestionModal" 
    x-transition
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    style="display: none;"
>
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <button @click="openQuestionModal = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            &times;
        </button>

        <h2 class="text-2xl font-semibold mb-4">Add Question</h2>

        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
            
            <!-- Question -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Question Text</label>
                <textarea name="question_text" class="w-full border rounded px-3 py-2" required></textarea>
            </div>

            <!-- Options -->
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Option A</label>
                    <input type="text" name="option_a" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Option B</label>
                    <input type="text" name="option_b" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Option C</label>
                    <input type="text" name="option_c" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Option D</label>
                    <input type="text" name="option_d" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <!-- Correct Answer -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Correct Answer</label>
                <select name="correct_answer" class="w-full border rounded px-3 py-2" required>
                    <option value="">— Select —</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Save Question
                </button>
            </div>
        </form>
    </div>
</div>
