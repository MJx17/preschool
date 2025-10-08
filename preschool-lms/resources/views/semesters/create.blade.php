<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New Semester
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('semesters.store') }}" method="POST">
                    @csrf

                    {{-- Semester Name Dropdown --}}
                    <div class="mb-4">
                        <label for="semester" class="block font-semibold mb-1">
                            Semester Name <span class="text-sm text-gray-500">(auto-generated)</span>
                        </label>
                        <select name="semester" id="semester" class="w-full border rounded p-2">
                            <option value="">Select a semester</option>
                            @foreach ($semesterOptions as $option)
                                <option
                                    value="{{ $option['value'] }}"
                                    data-start="{{ $option['start_date'] }}"
                                    data-end="{{ $option['end_date'] }}"
                                    {{ old('semester') == $option['value'] ? 'selected' : '' }}>
                                    {{ $option['label'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('semester')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Start Date --}}
                    <div class="mb-4">
                        <label for="start_date" class="block font-semibold mb-1">Start Date</label>
                        <input type="date" name="start_date" id="start_date"
                               value="{{ old('start_date') }}"
                               class="w-full border rounded p-2">
                        @error('start_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- End Date --}}
                    <div class="mb-4">
                        <label for="end_date" class="block font-semibold mb-1">End Date</label>
                        <input type="date" name="end_date" id="end_date"
                               value="{{ old('end_date') }}"
                               class="w-full border rounded p-2">
                        @error('end_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label for="status" class="block font-semibold mb-1">Status</label>
                        <select name="status" id="status" class="w-full border rounded p-2">
                            @foreach(['upcoming','active','closed'] as $status)
                                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Create Semester
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Script to auto-fill dates --}}
    <script>
        document.getElementById('semester').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            document.getElementById('start_date').value = selected.getAttribute('data-start') || '';
            document.getElementById('end_date').value   = selected.getAttribute('data-end') || '';
        });
    </script>
</x-app-layout>
