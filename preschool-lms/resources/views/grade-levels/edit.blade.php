<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Grade Level') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded-lg">
            <form action="{{ route('grade-levels.update', $grade->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" name="name" id="name" 
                           class="w-full p-3 border rounded-lg @error('name') border-red-500 @enderror"
                           value="{{ old('name', $grade->name) }}" required>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="code" class="block text-gray-700 font-medium mb-2">Code</label>
                    <input type="text" name="code" id="code" 
                           class="w-full p-3 border rounded-lg @error('code') border-red-500 @enderror"
                           value="{{ old('code', $grade->code) }}" required>
                    @error('code') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('grade-levels.index') }}" class="mr-2 px-4 py-2 bg-gray-300 rounded_
