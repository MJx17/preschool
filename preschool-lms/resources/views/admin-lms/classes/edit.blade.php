@extends('admin-lms.layouts.admin')

@section('title', 'Edit Class')
@section('page-title', '✏️ Edit Class')

@section('content')
    <form action="{{ route('admin-lms.classes.update', $class->id) }}" method="POST" class="bg-white shadow p-6 rounded-lg">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1">Class Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ $class->name }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Teacher</label>
            <input type="text" name="teacher" class="w-full border p-2 rounded" value="{{ $class->teacher }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Schedule</label>
            <input type="text" name="schedule" class="w-full border p-2 rounded" value="{{ $class->schedule }}" required>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Update Class</button>
    </form>
@endsection
