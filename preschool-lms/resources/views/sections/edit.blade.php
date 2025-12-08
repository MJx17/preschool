<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Section') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded-lg">
            <form action="{{ route('sections.update', $section->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Section Name</label>
                    <input type="text" name="name" id="name"
                           class="w-full p-3 border rounded-lg @error('name') border-red-500 @enderror"
                           value="{{ old('name', $section->name) }}" required>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="grade_level_id" class="block text-gray-700 font-medium mb-2">Grade Level</label>
                    <select name="grade_level_id" id="grade_level_id"
                            class="w-full p-3 border rounded-lg @error('grade_level_id') border-red-500 @enderror" required>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ old('grade_level_id', $section->grade_level_id) == $grade->id ? 'selected' : '' }}>
                                {{ $grade->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('grade_level_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('sections.index') }}" class="mr-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
