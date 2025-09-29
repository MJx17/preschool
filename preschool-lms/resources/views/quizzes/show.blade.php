<x-app-layout>
      <div class="flex justify-center py-6" x-data="{ openQuestionModal: false }">
        <!-- A4 Paper Layout -->
        <div class="bg-white shadow-lg p-10 w-[210mm] min-h-[297mm] relative">

            <!-- Quiz Header -->
            <div class="mb-6 border-b pb-4">
                <h1 class="text-3xl font-bold text-center mb-2">{{ $quiz->title }}</h1>
                <p class="text-gray-600 text-center">{{ $quiz->description }}</p>
                <div class="mt-4 text-sm text-gray-700 grid grid-cols-3 gap-2">
                    <div><strong>Lesson:</strong> {{ $quiz->lesson->title ?? '—' }}</div>
                    <div><strong>Time Limit:</strong> {{ $quiz->time_limit ? $quiz->time_limit . ' min' : '—' }}</div>
                    <div>
                        <strong>Status:</strong>
                        @if($quiz->status === 'draft')
                            <span class="text-gray-500 font-semibold">Draft</span>
                        @elseif($quiz->status === 'published')
                            <span class="text-green-600 font-semibold">Published</span>
                        @elseif($quiz->status === 'archived')
                            <span class="text-red-600 font-semibold">Archived</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <h2 class="text-xl font-semibold mb-4">Questions</h2>

            <ol class="space-y-6 list-decimal pl-6">
                @forelse($questions as $question)
                    <li class="pb-4 border-b">
                        <!-- Question -->
                        <div class="mb-2">
                            @if($question->question_text)
                                <p class="font-semibold">{{ $question->question_text }}</p>
                            @endif
                            @if($question->question_image)
                                <img src="{{ asset('storage/' . $question->question_image) }}" alt="Question Image" class="max-w-xs mt-2">
                            @endif
                        </div>

                        <!-- Options -->
                        <div class="pl-4 space-y-2 text-gray-700">
                            @foreach(['a','b','c','d'] as $opt)
                                @php
                                    $optText = "option_{$opt}";
                                    $optImage = "option_{$opt}_image";
                                @endphp
                                @if($question->$optText || $question->$optImage)
                                    <div class="flex items-start gap-2">
                                        <span class="font-semibold uppercase">{{ $opt }}.</span>
                                        <div>
                                            @if($question->$optText)
                                                <p>{{ $question->$optText }}</p>
                                            @endif
                                            @if($question->$optImage)
                                                <img src="{{ asset('storage/' . $question->$optImage) }}" alt="Option {{ strtoupper($opt) }}" class="max-w-[120px] mt-1">
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Correct Answer -->
                        <p class="text-green-600 mt-2 text-sm">
                            <strong>Correct Answer:</strong> {{ strtoupper($question->correct_answer) }}
                        </p>
                    </li>
                @empty
                    <li class="text-gray-500 italic">No questions added yet.</li>
                @endforelse
            </ol>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $questions->links() }}
            </div>

            <!-- Add Question Button -->
            <button
                class="fixed bottom-8 right-8 bg-blue-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-blue-700"
                @click="openQuestionModal = true">
                + Add Question
            </button>
        </div>

        <!-- Inject Question Modal -->
        <x-question.modal :quiz="$quiz" />
    </div>
</x-app-layout>
