<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ➕ Add Lesson
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('lessons.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block font-medium mb-2">Title</label>
                            <input type="text" name="title" class="w-full border p-2 rounded" required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-2">Description</label>
                            <textarea name="description" class="w-full border p-2 rounded"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-2">Upload File</label>
                            <input type="file" name="file" class="w-full">
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-2">Video URL</label>
                            <input type="text" name="video_url" class="w-full border p-2 rounded">
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-2">Type</label>
                            <select name="type" class="w-full border p-2 rounded">
                                <option value="lecture">Lecture</option>
                                <option value="activity">Activity</option>
                                <option value="quiz">Quiz</option>
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                                Save
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
