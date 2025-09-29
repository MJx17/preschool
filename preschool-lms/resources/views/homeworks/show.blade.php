<x-app-layout>
    <div class="max-w-3xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">{{ $homework->title }}</h1>

        <p><strong>Lesson:</strong> {{ $homework->lesson->title ?? '—' }}</p>
        <p><strong>Due Date:</strong> {{ $homework->due_date ?? '—' }}</p>

        <div class="mt-4">
            <h2 class="font-semibold">Instructions:</h2>
            <p>{{ $homework->instructions }}</p>
        </div>

        @if($homework->file_url)
            <p class="mt-4">
                <a href="{{ $homework->file_url }}" target="_blank" class="text-blue-500">📄 View File</a>
            </p>
        @endif

        @if($homework->video_url)
            <div class="mt-4">
                <iframe width="100%" height="315" src="{{ $homework->video_url }}" frameborder="0" allowfullscreen></iframe>
            </div>
        @endif
    </div>
</x-app-layout>
