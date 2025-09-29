@extends('admin-lms.layouts.admin')

@section('title', 'Add Class')
@section('page-title', '➕ Add Class')

@section('content')
    <form action="{{ route('admin-lms.classes.store') }}" method="POST" class="bg-white shadow p-6 rounded-lg">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Class Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Teacher</label>
            <input type="text" name="teacher" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Schedule</label>
            <input type="text" name="schedule" class="w-full border p-2 rounded" required>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Save Class</button>
    </form>
@endsection
