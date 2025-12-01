<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Subject') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <strong>Whoops! Something went wrong.</strong>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('subjects.store') }}">
                    @csrf

                    <!-- Subject Name -->
                    <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700">Subject Name</label>
                        <input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('name') }}" required>
                    </div>

                    <!-- Subject Code -->
                    <div class="mb-4">
                        <label for="code" class="block font-medium text-sm text-gray-700">Subject Code</label>
                        <input id="code" name="code" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('code') }}" required>
                    </div>

                
                    <!-- Grade Level -->
                    <div class="mb-4">
                        <label for="grade_level_id" class="block font-medium text-sm text-gray-700">Grade Level</label>
                        <select id="grade_level_id" name="grade_level_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Select Grade Level --</option>
                            @foreach ($gradeLevels as $level)
                            <option value="{{ $level->id }}" {{ old('grade_level_id') == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('grade_level_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Prerequisite -->
                    <div class="mb-4">
                        <label for="prerequisite_id" class="block font-medium text-sm text-gray-700">Prerequisite (optional)</label>
                        <select id="prerequisite_id" name="prerequisite_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- None --</option>
                            @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('prerequisite_id')==$subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fee -->
                    <div class="mb-4">
                        <label for="fee" class="block font-medium text-sm text-gray-700">Fee</label>
                        <input id="fee" name="fee" type="number" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('fee') }}" required>
                    </div>

                    <!-- Units -->
                    <div class="mb-4">
                        <label for="units" class="block font-medium text-sm text-gray-700">Units</label>
                        <input id="units" name="units" type="number" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('units') }}" required>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Create Subject</button>
                        <a href="{{ route('subjects.index') }}" class="text-gray-600 hover:underline">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>