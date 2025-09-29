<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <!-- Title -->
        <h1 class="text-3xl font-bold mb-4 text-gray-800">{{ $lesson->title }}</h1>

        <!-- Description -->
        <div class="prose max-w-none mb-6 text-gray-700">
            {!! nl2br(e($lesson->description)) !!}
        </div>

        <!-- Lesson Image -->
        @if($lesson->image_url)
        <div class="mb-6">


            <img src="{{ $lesson->image_url }}"
                alt="Lesson Image"
                class="w-full rounded-lg shadow-lg">
        </div>
        @endif

        <!-- Lesson Video -->
        @if($lesson->video_url)
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Lesson Video</h2>
            <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden shadow-md">
                <iframe
                    src="{{ $lesson->video_url }}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    class="w-full h-96">
                </iframe>
            </div>
            <div class="mt-2">
                <a href="{{ $lesson->video_url }}"
                    target="_blank"
                    class="text-blue-600 underline">
                    Open Video in New Tab
                </a>
            </div>
        </div>
        @endif

        <!-- Lesson Document -->
        @if($lesson->document_url)
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Lesson Document</h2>
            <!-- <iframe
                src="{{ $lesson->document_url }}"
                class="w-full h-[600px] border rounded-lg shadow-md">
            </iframe> -->
            <iframe src="{{ asset('/Getting Started.pdf') }}"
                class="w-full h-[600px] border rounded-lg shadow-md">
            </iframe>
            <div class="mt-2">
                <a href="{{ $lesson->document_url }}"
                    target="_blank"
                    class="text-blue-600 underline">
                    Open Document in New Tab
                </a>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>