@extends('admin-lms.layouts.admin')

@section('title', 'Edit Homework')
@section('page-title', '✏️ Edit Homework')

@section('content')
    <form action="{{ route('admin-lms.homework.update', $homework->id) }}" method="POST" class="bg-white shadow p-6 rounded-lg">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1">Class</label>
            <select name="class_id" class="w-full border p-2 rounded" required>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}" @if($class->id == $homework->class_id) selected @endif>{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Homework Title</label>
            <input type="text" name="title" class="w-full border p-2 rounded" value="{{ $homework->title }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Due Date / Day</label>
            <input type="text" name="due" class="w-full border p-2 rounded" value="{{ $homework->due }}" required>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Update Homework</button>
    </form>
@endsection
