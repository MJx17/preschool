@extends('admin-lms.layouts.admin')

@section('title', 'Add Homework')
@section('page-title', '➕ Add Homework')

@section('content')
    <form action="{{ route('admin-lms.homework.store') }}" method="POST" class="bg-white shadow p-6 rounded-lg">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Class</label>
            <select name="class_id" class="w-full border p-2 rounded" required>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Homework Title</label>
            <input type="text" name="title" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Due Date / Day</label>
            <input type="text" name="due" class="w-full border p-2 rounded" required>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Save Homework</button>
    </form>
@endsection
