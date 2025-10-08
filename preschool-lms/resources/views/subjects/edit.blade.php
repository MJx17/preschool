{{-- resources/views/subjects/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Subject – {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('subjects.update', $subject->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                        <input id="name" name="name" type="text"
                               value="{{ old('name', $subject->name) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Code --}}
                    <div class="mb-4">
                        <label for="code" class="block font-medium text-sm text-gray-700">Code</label>
                        <input id="code" name="code" type="text"
                               value="{{ old('code', $subject->code) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Grade Level --}}
                    <div class="mb-4">
                        <label for="grade_level" class="block font-medium text-sm text-gray-700">Grade Level</label>
                        <select id="grade_level" name="grade_level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select Grade Level</option>
                            @foreach (['nursery','kinder','grade_1','grade_2','grade_3'] as $level)
                                <option value="{{ $level }}" {{ old('grade_level', $subject->grade_level)===$level ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_',' ',$level)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('grade_level')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Prerequisite Subject --}}
                    <div class="mb-4">
                        <label for="prerequisite_id" class="block font-medium text-sm text-gray-700">Prerequisite</label>
                        <select id="prerequisite_id" name="prerequisite_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">None</option>
                            @foreach ($subjects as $prereq)
                                <option value="{{ $prereq->id }}" {{ old('prerequisite_id', $subject->prerequisite_id)===$prereq->id ? 'selected' : '' }}>
                                    {{ $prereq->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('prerequisite_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fee --}}
                    <div class="mb-4">
                        <label for="fee" class="block font-medium text-sm text-gray-700">Fee</label>
                        <input id="fee" name="fee" type="number" step="0.01"
                               value="{{ old('fee', $subject->fee) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('fee')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Units --}}
                    <div class="mb-4">
                        <label for="units" class="block font-medium text-sm text-gray-700">Units</label>
                        <input id="units" name="units" type="number" step="0.1"
                               value="{{ old('units', $subject->units) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('units')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Update Subject
                        </button>
                        <a href="{{ route('subjects.index') }}" class="ml-3 text-gray-600 hover:underline">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
