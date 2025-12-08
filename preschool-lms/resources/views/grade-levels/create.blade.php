<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Grade Level') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded-lg">
            <form action="{{ route('grade-levels.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" name="name" id="name" 
                           class="w-full p-3 border rounded-lg @error('name') border-red-500 @enderror"
                           value="{{ old('name') }}" required>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="code" class="block text-gray-700 font-medium mb-2">Code</label>
                    <input type="text" name="code" id="code" 
                           class="w-full p-3 border rounded-lg @error('code') border-red-500 @enderror"
                           value="{{ old('code') }}" required>
                    @error('code') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('grade-levels.index') }}" class="mr-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Create</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
